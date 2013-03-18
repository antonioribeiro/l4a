<?php

class BankingController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|

	http://nas.escritorio.cys.cysdns.com:8080/l3a/billet/7/19800/30be95fd041dcd61c9075f0ab436cfa2

	*/

	public function showBillet($customer, $invoice, $hash)
	{
		$billet = DB::select("select first 1 
									cl.razao_social
								,	cl.cpf_cnpj
								,	cl.logradouro
								,	cl.numero
								,	cl.complemento
								,	cl.bairro
								,	cl.cidade
								,	cl.estado
								,	cl.cep

								,	co.valor
								, 	co.desconto
								, 	co.nosso_numero
								, 	co.data_vencimento
								, 	co.data_documento
							from CA_COBRANCA co 
							join CA_CLIENTE cl on cl.CODIGO_CLIENTE = co.CODIGO_CLIENTE
							where co.CODIGO_CLIENTE = '$customer' and NUMERO_DOCUMENTO = '$invoice'");

		$items = DB::select("select
							  trim(cast(
							               (select descricao_tipo_servico from CA_TIPO_SERVICO where codigo_tipo_servico = (case when sc.codigo_servico_cliente is null then
							                                                                                                  sco.codigo_servico_cliente
							                                                                                                else
							                                                                                                  sc.codigo_tipo_servico
							                                                                                                end) )
							  || coalesce(' - '||sc.objeto_servico, '') as VARCHAR(500))) descricao_servico
							, 

							(case when sco.data_referencia is null then
							  trim(cast(ExtractMonth( (select data_vencimento from CA_COBRANCA where numero_documento = sco.numero_documento) ) as CHAR(2))) || '/' || cast(ExtractYear(  (select data_vencimento from CA_COBRANCA where numero_documento = sco.numero_documento)  ) as CHAR(4))
							else
							  trim(cast(ExtractMonth(data_referencia) as CHAR(2))) || '/' || cast(ExtractYear(data_referencia) as CHAR(4))
							end) as referencia

							, sco.codigo_cliente
							, sco.codigo_servico_cliente
							, sco.codigo_servico_cobrado
							, sco.numero_documento
							, sco.data_referencia
							, sco.valor              as valor_servico
							, sco.desconto           as desconto
							, sco.valor-sco.desconto as valor
							, sco.data_pagamento_comissao

							from CA_SERVICO_COBRADO sco

							left join CA_SERVICO_CLIENTE sc on sc.codigo_servico_cliente = sco.codigo_servico_cliente and sc.CODIGO_CLIENTE = sco.CODIGO_CLIENTE
							/* join CA_TIPO_SERVICO    ts on ts.codigo_tipo_servico    = sc.codigo_tipo_servico */

							where sco.codigo_cliente = $customer and
							      sco.numero_documento = $invoice

							order by sco.data_referencia, sco.codigo_servico_cobrado");

		//dd($billet);
		if (!$billet or $hash != md5($billet[0]->VALOR)) {
			return "Boleto não encontrado.";
		}

		$bradesco = new Bradesco;

		$bradesco->dias_de_prazo_para_pagamento = 1;
		$bradesco->taxa_boleto = 0;
		$bradesco->data_venc = date("d/m/Y", time() + ($bradesco->dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
		$bradesco->valor_cobrado = number_format($billet[0]->VALOR-$billet[0]->DESCONTO,2,".",""); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
		$bradesco->valor_cobrado = str_replace(",", ".",$bradesco->valor_cobrado);
		$bradesco->valor_boleto=number_format($bradesco->valor_cobrado+$bradesco->taxa_boleto, 2, ',', '');

		$bradesco->dadosboleto = array();
		
		$bradesco->dadosboleto["nosso_numero"] = $billet[0]->NOSSO_NUMERO;  // Nosso numero sem o DV - REGRA: Máximo de 11 caracteres!
		$bradesco->dadosboleto["numero_documento"] = $billet[0]->NOSSO_NUMERO;	// Num do pedido ou do documento = Nosso numero
		$bradesco->dadosboleto["data_vencimento"] = date("d/m/Y", strtotime( $billet[0]->DATA_VENCIMENTO ) ); // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
		$bradesco->dadosboleto["data_documento"] = date("d/m/Y", strtotime( $billet[0]->DATA_DOCUMENTO ) ); // Data de emissão do Boleto
		$bradesco->dadosboleto["data_processamento"] =  date("d/m/Y", strtotime( $billet[0]->DATA_DOCUMENTO ) ); // Data de processamento do boleto (opcional)
		$bradesco->dadosboleto["valor_boleto"] = $bradesco->valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

		// DADOS DO SEU CLIENTE
		$bradesco->dadosboleto["sacado"] = $this->charsetDecode($billet[0]->RAZAO_SOCIAL ." - ". $billet[0]->CPF_CNPJ);
		$bradesco->dadosboleto["endereco1"] = $this->charsetDecode($billet[0]->LOGRADOURO .", ". $billet[0]->NUMERO . ($billet[0]->COMPLEMENTO ? " - ".$billet[0]->COMPLEMENTO : ""));
		$bradesco->dadosboleto["endereco2"] = $this->charsetDecode($billet[0]->CIDADE ." - ". $billet[0]->ESTADO ." - ". $billet[0]->CEP);

		// INFORMACOES PARA O CLIENTE
		$bradesco->dadosboleto["demonstrativo1"] = "";
		$bradesco->dadosboleto["demonstrativo2"] = "";
		$bradesco->dadosboleto["demonstrativo3"] = "";
		$bradesco->dadosboleto["instrucoes1"] = "Sr(a). Caixa, cobrar multa de 2% após o vencimento";
		$bradesco->dadosboleto["instrucoes2"] = "Receber até 10 dias após o vencimento";
		$bradesco->dadosboleto["instrucoes3"] = "";
		$bradesco->dadosboleto["instrucoes4"] = "";

		// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
		$bradesco->dadosboleto["quantidade"] = "001";
		$bradesco->dadosboleto["valor_unitario"] = $bradesco->valor_boleto;
		$bradesco->dadosboleto["aceite"] = "";		
		$bradesco->dadosboleto["especie"] = "R$";
		$bradesco->dadosboleto["especie_doc"] = "DS";

		// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //

		// DADOS DA SUA CONTA - Bradesco
		$bradesco->dadosboleto["agencia"] = "3469"; // Num da agencia, sem digito
		$bradesco->dadosboleto["agencia_dv"] = "0"; // Digito do Num da agencia
		$bradesco->dadosboleto["conta"] = "41000"; 	// Num da conta, sem digito
		$bradesco->dadosboleto["conta_dv"] = "4"; 	// Digito do Num da conta

		// DADOS PERSONALIZADOS - Bradesco
		$bradesco->dadosboleto["conta_cedente"] = "41000"; // ContaCedente do Cliente, sem digito (Somente Números)
		$bradesco->dadosboleto["conta_cedente_dv"] = "4"; // Digito da ContaCedente do Cliente
		$bradesco->dadosboleto["carteira"] = "09";  // Código da Carteira: pode ser 06 ou 03

		// SEUS DADOS
		$bradesco->dadosboleto["identificacao"] = "CyS";
		$bradesco->dadosboleto["cpf_cnpj"] = "04.277.840/0001-57";
		$bradesco->dadosboleto["endereco"] = "Antonio Carlos - (21) 8088-2233 e 9644-4722";
		$bradesco->dadosboleto["cidade_uf"] = "Anselmo - (21) 8088-2229 e 9919-0326";
		$bradesco->dadosboleto["cedente"] = "CyS - Cypher Systems Consultoria e Desenvolvimento em Informática Ltda.";

		$bradesco->viewName = 'views.banking.bradesco.billet';
		$bradesco->items = $items;

		return $bradesco->render();
	}

	function charsetDecode($s) {
		return htmlentities($s,ENT_COMPAT,'ISO-8859-1');
	}

}

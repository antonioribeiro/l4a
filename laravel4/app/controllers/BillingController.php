<?php

class BillingController extends BaseController {

	public function index()
	{
		$bills = DB::select("select 
											cl.codigo_cliente
										,	cl.razao_social
										,	cl.cpf_cnpj
										,	cl.logradouro
										,	cl.numero
										,	cl.complemento
										,	cl.bairro
										,	cl.cidade
										,	cl.estado
										,	cl.cep
										,   cl.email

										,	co.valor
										, 	co.desconto
										, 	co.nosso_numero
										, 	co.numero_documento
										, 	co.data_vencimento
										, 	co.data_documento
									from CA_COBRANCA co 
									join CA_CLIENTE cl on cl.CODIGO_CLIENTE = co.CODIGO_CLIENTE
									where co.DATA_PAGAMENTO is null and co.DATA_CANCELAMENTO is null
									and co.data_vencimento = '2013-03-15 00:00:00'
									order by cl.codigo_cliente, co.data_vencimento desc");


		return $this->sendBills($bills);

		return View::make('views.billing.index',array('bills' => $bills));
	}

	public function sendBills($bills) {
		foreach($bills as $bill) {
			Mail::send('views.billing.email', Helpers::toArray($bill), function($m)
			{
				$m->from('cobranca@cys.com.br', 'Cobrança CyS');
			    $m->to('acr@antoniocarlosribeiro.com', 'Antonio Carlos Ribeiro')->subject('Welcome!');
			});

			break;
		}

		return "Mail sent";
	}
}
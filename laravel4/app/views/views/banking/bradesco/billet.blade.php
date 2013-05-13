<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<TITLE><?php echo $dadosboleto["identificacao"]; ?></TITLE>
	<base href="{{ URL::to('/') }}">
	
	<meta name="Generator" content="CyS" />
	<link rel='stylesheet' type='text/css' href='assets/css/invoice_style.css' />
	<link rel='stylesheet' type='text/css' href='assets/css/invoice_print.css' media="print" />
	<script type='text/javascript' src='assets/js/jquery-1.3.2.min.js'></script>
	<script type='text/javascript' src='assets/js/invoice_example.js'></script>
	<style type=text/css>
		<!--.cp {  font: bold 10px Arial; color: black }
		<!--.lo {  font: 16px Arial, Helvetica, sans-serif }
		<!--.ti {  font: 9px Arial, Helvetica, sans-serif }
		<!--.ld { font: bold 15px Arial; color: #000000 }
		<!--.ct { FONT: 9px "Arial Narrow"; COLOR: #000033 }
		<!--.cn { FONT: 9px Arial; COLOR: black }
		<!--.bc { font: bold 20px Arial; color: #000000 }
		<!--.ld2 { font: bold 12px Arial; color: #000000 }
		<!--.billet { font: bold 12px Arial; color: #000000; border: 0px }
		<!--#billet table td, table th { border: 0px solid black; padding: 0px; }
		<!--#billet { width: 666px; margin-left: auto; margin-right: auto; }
		-->
	</style> 
</head>

<body>
	<div id="page-wrap">
		<div id="identity">
			<div id="logo">
			  <img id="image" src="assets/img/logo_cys_55px.png" alt="logo" />
			</div>
			<?php echo $dadosboleto["identificacao"]; ?>
			<?php echo isset($dadosboleto["cpf_cnpj"]) ? "<br>".$dadosboleto["cpf_cnpj"] : '' ?><br>
			<?php echo $dadosboleto["endereco"]; ?><br>
			<?php echo $dadosboleto["cidade_uf"]; ?><br>
		</div>
		
		<div style="clear:both"></div><br><br>
		
		<div id="customer">
			<div id="customer-title">
				<?php echo $dadosboleto["razao_social_cliente"]; ?><br>
				<?php echo $dadosboleto["cpf_cnpj_cliente"]; ?>
			</div>

			<table id="meta">
				<tr>
					<td class="meta-head">Documento #</td>
					<td>{{ $dadosboleto["numero_documento"] }}</td>
				</tr>
				<tr>

					<td class="meta-head">Vencimento</td>
					<td><div id="date">{{$dadosboleto["data_vencimento"]}}</div></td>
				</tr>
				<tr>
					<td class="meta-head">Valor</td>
					<td><div class="due">R$ {{ $dadosboleto["valor_boleto"] }}</div></td>
				</tr>

			</table>
		
		</div>
		
		<table id="items">
			<tr>
				<th>Referência</th>
				<th>Descrição</th>
				<th>Valor</th>
				<th>Desconto</th>
				<th>Total</th>
			</tr>
		  
			@foreach($billetObject->items as $item)
				<tr class="item-row">
					<td class="item-name">{{$item->REFERENCIA}}</td>
					<td class="description">{{$item->DESCRICAO_SERVICO}}</td>
					<td class="cost">R$ {{number_format($item->VALOR_SERVICO,2,",",".")}}</td>
					<td class="qty">R$ {{number_format($item->DESCONTO,2,",",".")}}</td>
					<td class="price">R$ {{number_format($item->VALOR_SERVICO-$item->DESCONTO,2,",",".")}}</td>
				</tr>
			@endforeach

			<tr>
				<td colspan="2" class="blank"> </td>
				<td colspan="2" class="total-line">Total</td>
				<td class="total-value">R$ {{ $dadosboleto["valor_total"] }}</td>
			</tr>

			<tr>
				<td colspan="2" class="blank"> </td>
				<td colspan="2" class="total-line">Desconto</td>
				<td class="total-value">R$ {{ $dadosboleto["desconto"] }}</td>
			</tr>

			<tr>
				<td colspan="2" class="blank"> </td>
				<td colspan="2" class="total-line balance">Valor a pagar</td>
				<td class="total-value balance"><div class="due">R$ {{ $dadosboleto["valor_boleto"] }}</div></td>
			</tr>
		</table>
	
		<div id="billet">
			<br><br><br><br><br>

			<table cellspacing="0" cellpadding="0" width="666" border="0">
				<tr>
					<td class="cp" width="150">
						<span class="campo"><img src="assets/img/logobradesco.jpg" width="150" height="40" border="0"></span>
					</td>
					<td width="3" valign="bottom">
						<img height="22" src="assets/img/3.png" width="2" border="0">
					</td>
					<td class="cpt" width="58" valign="bottom">
						<div align="center">
							<font class="bc"><?php echo $dadosboleto["codigo_banco_com_dv"]?></font>
						</div>
					</td>
					<td width="3" valign="bottom">
						<img height="22" src="assets/img/3.png" width="2" border="0">
					</td>
					<td class="ld" align="right" width="453" valign="bottom">
						<span class="ld"><span class="campotitulo"><?php echo $dadosboleto["linha_digitavel"]?></span></span>
					</td>
				</tr>
				<tbody>
					<tr>
						<td colspan="5">
							<img height="2" src="assets/img/2.png" width="666" border="0">
						</td>
					</tr>
				</tbody>
			</table>

			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
					<tr>
						<td class="ct" valign="top" width="7" height="13">
							<img height="13" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="ct" valign="top" width="472" height="13">
							Local de pagamento
						</td>
						<td class="ct" valign="top" width="7" height="13">
							<img height="13" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="ct" valign="top" width="180" height="13">
							Vencimento
						</td>
					</tr>
					<tr>
						<td class="cp" valign="top" width="7" height="12">
							<img height="12" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="cp" valign="top" width="472" height="12">
							Pagável em qualquer Banco até o vencimento
						</td>
						<td class="cp" valign="top" width="7" height="12">
							<img height="12" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="cp" valign="top" align="right" width="180" height="12">
							<span class="campo"><?php echo $dadosboleto["data_vencimento"]?></span>
						</td>
					</tr>
					<tr>
						<td valign="top" width="7" height="1">
							<img height="1" src="assets/img/2.png" width="7" border="0">
						</td>
						<td valign="top" width="472" height="1">
							<img height="1" src="assets/img/2.png" width="472" border="0">
						</td>
						<td valign="top" width="7" height="1">
							<img height="1" src="assets/img/2.png" width="7" border="0">
						</td>
						<td valign="top" width="180" height="1">
							<img height="1" src="assets/img/2.png" width="180" border="0">
						</td>
					</tr>
				</tbody>
			</table>
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
					<tr>
						<td class="ct" valign="top" width="7" height="13">
							<img height="13" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="ct" valign="top" width="472" height="13">
							Cedente
						</td>
						<td class="ct" valign="top" width="7" height="13">
							<img height="13" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="ct" valign="top" width="180" height="13">
							Agência/Código cedente
						</td>
					</tr>
					<tr>
						<td class="cp" valign="top" width="7" height="12">
							<img height="12" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="cp" valign="top" width="472" height="12">
							<span class="campo"><?php echo $dadosboleto["cedente"]?></span>
						</td>
						<td class="cp" valign="top" width="7" height="12">
							<img height="12" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="cp" valign="top" align="right" width="180" height="12">
							<span class="campo"><?php echo $dadosboleto["agencia_codigo"]?></span>
						</td>
					</tr>
					<tr>
						<td valign="top" width="7" height="1">
							<img height="1" src="assets/img/2.png" width="7" border="0">
						</td>
						<td valign="top" width="472" height="1">
							<img height="1" src="assets/img/2.png" width="472" border="0">
						</td>
						<td valign="top" width="7" height="1">
							<img height="1" src="assets/img/2.png" width="7" border="0">
						</td>
						<td valign="top" width="180" height="1">
							<img height="1" src="assets/img/2.png" width="180" border="0">
						</td>
					</tr>
				</tbody>
			</table>
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
					<tr>
						<td class="ct" valign="top" width="7" height="13">
							<img height="13" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="ct" valign="top" width="113" height="13">
							Data do documento
						</td>
						<td class="ct" valign="top" width="7" height="13">
							<img height="13" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="ct" valign="top" width="153" height="13">
							N<u>o</u> documento
						</td>
						<td class="ct" valign="top" width="7" height="13">
							<img height="13" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="ct" valign="top" width="62" height="13">
							Espécie doc.
						</td>
						<td class="ct" valign="top" width="7" height="13">
							<img height="13" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="ct" valign="top" width="34" height="13">
							Aceite
						</td>
						<td class="ct" valign="top" width="7" height="13">
							<img height="13" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="ct" valign="top" width="82" height="13">
							Data processamento
						</td>
						<td class="ct" valign="top" width="7" height="13">
							<img height="13" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="ct" valign="top" width="180" height="13">
							Nosso número
						</td>
					</tr>
					<tr>
						<td class="cp" valign="top" width="7" height="12">
							<img height="12" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="cp" valign="top" width="113" height="12">
							<div align="left">
								<span class="campo"><?php echo $dadosboleto["data_documento"]?></span>
							</div>
						</td>
						<td class="cp" valign="top" width="7" height="12">
							<img height="12" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="cp" valign="top" width="153" height="12">
							<span class="campo"><?php echo $dadosboleto["numero_documento"]?></span>
						</td>
						<td class="cp" valign="top" width="7" height="12">
							<img height="12" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="cp" valign="top" width="62" height="12">
							<div align="left">
								<span class="campo"><?php echo $dadosboleto["especie_doc"]?></span>
							</div>
						</td>
						<td class="cp" valign="top" width="7" height="12">
							<img height="12" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="cp" valign="top" width="34" height="12">
							<div align="left">
								<span class="campo"><?php echo $dadosboleto["aceite"]?></span>
							</div>
						</td>
						<td class="cp" valign="top" width="7" height="12">
							<img height="12" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="cp" valign="top" width="82" height="12">
							<div align="left">
								<span class="campo"><?php echo $dadosboleto["data_processamento"]?></span>
							</div>
						</td>
						<td class="cp" valign="top" width="7" height="12">
							<img height="12" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="cp" valign="top" align="right" width="180" height="12">
							<span class="campo"><?php echo $dadosboleto["nosso_numero"]?></span>
						</td>
					</tr>
					<tr>
						<td valign="top" width="7" height="1">
							<img height="1" src="assets/img/2.png" width="7" border="0">
						</td>
						<td valign="top" width="113" height="1">
							<img height="1" src="assets/img/2.png" width="113" border="0">
						</td>
						<td valign="top" width="7" height="1">
							<img height="1" src="assets/img/2.png" width="7" border="0">
						</td>
						<td valign="top" width="153" height="1">
							<img height="1" src="assets/img/2.png" width="153" border="0">
						</td>
						<td valign="top" width="7" height="1">
							<img height="1" src="assets/img/2.png" width="7" border="0">
						</td>
						<td valign="top" width="62" height="1">
							<img height="1" src="assets/img/2.png" width="62" border="0">
						</td>
						<td valign="top" width="7" height="1">
							<img height="1" src="assets/img/2.png" width="7" border="0">
						</td>
						<td valign="top" width="34" height="1">
							<img height="1" src="assets/img/2.png" width="34" border="0">
						</td>
						<td valign="top" width="7" height="1">
							<img height="1" src="assets/img/2.png" width="7" border="0">
						</td>
						<td valign="top" width="82" height="1">
							<img height="1" src="assets/img/2.png" width="82" border="0">
						</td>
						<td valign="top" width="7" height="1">
							<img height="1" src="assets/img/2.png" width="7" border="0">
						</td>
						<td valign="top" width="180" height="1">
							<img height="1" src="assets/img/2.png" width="180" border="0">
						</td>
					</tr>
				</tbody>
			</table>
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
					<tr>
						<td class="ct" valign="top" width="7" height="13">
							<img height="13" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="ct" valign="top" colspan="3" height="13">
							Uso do banco
						</td>
						<td class="ct" valign="top" height="13" width="7">
							<img height="13" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="ct" valign="top" width="83" height="13">
							Carteira
						</td>
						<td class="ct" valign="top" height="13" width="7">
							<img height="13" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="ct" valign="top" width="53" height="13">
							Espécie
						</td>
						<td class="ct" valign="top" height="13" width="7">
							<img height="13" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="ct" valign="top" width="123" height="13">
							Quantidade
						</td>
						<td class="ct" valign="top" height="13" width="7">
							<img height="13" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="ct" valign="top" width="72" height="13">
							Valor Documento
						</td>
						<td class="ct" valign="top" width="7" height="13">
							<img height="13" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="ct" valign="top" width="180" height="13">
							(=) Valor documento
						</td>
					</tr>
					<tr>
						<td class="cp" valign="top" width="7" height="12">
							<img height="12" src="assets/img/1.png" width="1" border="0">
						</td>
						<td valign="top" class="cp" height="12" colspan="3">
							<div align="left"></div>
						</td>
						<td class="cp" valign="top" width="7" height="12">
							<img height="12" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="cp" valign="top" width="83">
							<div align="left">
								<span class="campo"><?php echo $dadosboleto["carteira"]?></span>
							</div>
						</td>
						<td class="cp" valign="top" width="7" height="12">
							<img height="12" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="cp" valign="top" width="53">
							<div align="left">
								<span class="campo"><?php echo $dadosboleto["especie"]?></span>
							</div>
						</td>
						<td class="cp" valign="top" width="7" height="12">
							<img height="12" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="cp" valign="top" width="123">
							<span class="campo"><?php echo $dadosboleto["quantidade"]?></span>
						</td>
						<td class="cp" valign="top" width="7" height="12">
							<img height="12" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="cp" valign="top" width="72">
							<span class="campo"><?php echo $dadosboleto["valor_unitario"]?></span>
						</td>
						<td class="cp" valign="top" width="7" height="12">
							<img height="12" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="cp" valign="top" align="right" width="180" height="12">
							<span class="campo"><?php echo $dadosboleto["valor_boleto"]?></span>
						</td>
					</tr>
					<tr>
						<td valign="top" width="7" height="1">
							<img height="1" src="assets/img/2.png" width="7" border="0">
						</td>
						<td valign="top" width="7" height="1">
							<img height="1" src="assets/img/2.png" width="75" border="0">
						</td>
						<td valign="top" width="7" height="1">
							<img height="1" src="assets/img/2.png" width="7" border="0">
						</td>
						<td valign="top" width="31" height="1">
							<img height="1" src="assets/img/2.png" width="31" border="0">
						</td>
						<td valign="top" width="7" height="1">
							<img height="1" src="assets/img/2.png" width="7" border="0">
						</td>
						<td valign="top" width="83" height="1">
							<img height="1" src="assets/img/2.png" width="83" border="0">
						</td>
						<td valign="top" width="7" height="1">
							<img height="1" src="assets/img/2.png" width="7" border="0">
						</td>
						<td valign="top" width="53" height="1">
							<img height="1" src="assets/img/2.png" width="53" border="0">
						</td>
						<td valign="top" width="7" height="1">
							<img height="1" src="assets/img/2.png" width="7" border="0">
						</td>
						<td valign="top" width="123" height="1">
							<img height="1" src="assets/img/2.png" width="123" border="0">
						</td>
						<td valign="top" width="7" height="1">
							<img height="1" src="assets/img/2.png" width="7" border="0">
						</td>
						<td valign="top" width="72" height="1">
							<img height="1" src="assets/img/2.png" width="72" border="0">
						</td>
						<td valign="top" width="7" height="1">
							<img height="1" src="assets/img/2.png" width="7" border="0">
						</td>
						<td valign="top" width="180" height="1">
							<img height="1" src="assets/img/2.png" width="180" border="0">
						</td>
					</tr>
				</tbody>
			</table>
			<table cellspacing="0" cellpadding="0" width="666" border="0">
				<tbody>
					<tr>
						<td align="right" width="10">
							<table cellspacing="0" cellpadding="0" border="0" align="left">
								<tbody>
									<tr>
										<td class="ct" valign="top" width="7" height="13">
											<img height="13" src="assets/img/1.png" width="1" border="0">
										</td>
									</tr>
									<tr>
										<td class="cp" valign="top" width="7" height="12">
											<img height="12" src="assets/img/1.png" width="1" border="0">
										</td>
									</tr>
									<tr>
										<td valign="top" width="7" height="1">
											<img height="1" src="assets/img/2.png" width="1" border="0">
										</td>
									</tr>
								</tbody>
							</table>
						</td>
						<td valign="top" width="468" rowspan="5">
							<font class="ct">Instruções (Texto de responsabilidade do cedente)</font><br>
							<br>
							<span class="cp"><font class="campo"><?php echo $dadosboleto["instrucoes1"]; ?><br>
							<?php echo $dadosboleto["instrucoes2"]; ?><br>
							<?php echo $dadosboleto["instrucoes3"]; ?><br>
							<?php echo $dadosboleto["instrucoes4"]; ?></font><br>
							<br></span>
						</td>
						<td align="right" width="188">
							<table cellspacing="0" cellpadding="0" border="0">
								<tbody>
									<tr>
										<td class="ct" valign="top" width="7" height="13">
											<img height="13" src="assets/img/1.png" width="1" border="0">
										</td>
										<td class="ct" valign="top" width="180" height="13">
											(-) Desconto / Abatimentos
										</td>
									</tr>
									<tr>
										<td class="cp" valign="top" width="7" height="12">
											<img height="12" src="assets/img/1.png" width="1" border="0">
										</td>
										<td class="cp" valign="top" align="right" width="180" height="12"></td>
									</tr>
									<tr>
										<td valign="top" width="7" height="1">
											<img height="1" src="assets/img/2.png" width="7" border="0">
										</td>
										<td valign="top" width="180" height="1">
											<img height="1" src="assets/img/2.png" width="180" border="0">
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td align="right" width="10">
							<table cellspacing="0" cellpadding="0" border="0" align="left">
								<tbody>
									<tr>
										<td class="ct" valign="top" width="7" height="13">
											<img height="13" src="assets/img/1.png" width="1" border="0">
										</td>
									</tr>
									<tr>
										<td class="cp" valign="top" width="7" height="12">
											<img height="12" src="assets/img/1.png" width="1" border="0">
										</td>
									</tr>
									<tr>
										<td valign="top" width="7" height="1">
											<img height="1" src="assets/img/2.png" width="1" border="0">
										</td>
									</tr>
								</tbody>
							</table>
						</td>
						<td align="right" width="188">
							<table cellspacing="0" cellpadding="0" border="0">
								<tbody>
									<tr>
										<td class="ct" valign="top" width="7" height="13">
											<img height="13" src="assets/img/1.png" width="1" border="0">
										</td>
										<td class="ct" valign="top" width="180" height="13">
											(-) Outras deduções
										</td>
									</tr>
									<tr>
										<td class="cp" valign="top" width="7" height="12">
											<img height="12" src="assets/img/1.png" width="1" border="0">
										</td>
										<td class="cp" valign="top" align="right" width="180" height="12"></td>
									</tr>
									<tr>
										<td valign="top" width="7" height="1">
											<img height="1" src="assets/img/2.png" width="7" border="0">
										</td>
										<td valign="top" width="180" height="1">
											<img height="1" src="assets/img/2.png" width="180" border="0">
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td align="right" width="10">
							<table cellspacing="0" cellpadding="0" border="0" align="left">
								<tbody>
									<tr>
										<td class="ct" valign="top" width="7" height="13">
											<img height="13" src="assets/img/1.png" width="1" border="0">
										</td>
									</tr>
									<tr>
										<td class="cp" valign="top" width="7" height="12">
											<img height="12" src="assets/img/1.png" width="1" border="0">
										</td>
									</tr>
									<tr>
										<td valign="top" width="7" height="1">
											<img height="1" src="assets/img/2.png" width="1" border="0">
										</td>
									</tr>
								</tbody>
							</table>
						</td>
						<td align="right" width="188">
							<table cellspacing="0" cellpadding="0" border="0">
								<tbody>
									<tr>
										<td class="ct" valign="top" width="7" height="13">
											<img height="13" src="assets/img/1.png" width="1" border="0">
										</td>
										<td class="ct" valign="top" width="180" height="13">
											(+) Mora / Multa
										</td>
									</tr>
									<tr>
										<td class="cp" valign="top" width="7" height="12">
											<img height="12" src="assets/img/1.png" width="1" border="0">
										</td>
										<td class="cp" valign="top" align="right" width="180" height="12"></td>
									</tr>
									<tr>
										<td valign="top" width="7" height="1">
											<img height="1" src="assets/img/2.png" width="7" border="0">
										</td>
										<td valign="top" width="180" height="1">
											<img height="1" src="assets/img/2.png" width="180" border="0">
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td align="right" width="10">
							<table cellspacing="0" cellpadding="0" border="0" align="left">
								<tbody>
									<tr>
										<td class="ct" valign="top" width="7" height="13">
											<img height="13" src="assets/img/1.png" width="1" border="0">
										</td>
									</tr>
									<tr>
										<td class="cp" valign="top" width="7" height="12">
											<img height="12" src="assets/img/1.png" width="1" border="0">
										</td>
									</tr>
									<tr>
										<td valign="top" width="7" height="1">
											<img height="1" src="assets/img/2.png" width="1" border="0">
										</td>
									</tr>
								</tbody>
							</table>
						</td>
						<td align="right" width="188">
							<table cellspacing="0" cellpadding="0" border="0">
								<tbody>
									<tr>
										<td class="ct" valign="top" width="7" height="13">
											<img height="13" src="assets/img/1.png" width="1" border="0">
										</td>
										<td class="ct" valign="top" width="180" height="13">
											(+) Outros acréscimos
										</td>
									</tr>
									<tr>
										<td class="cp" valign="top" width="7" height="12">
											<img height="12" src="assets/img/1.png" width="1" border="0">
										</td>
										<td class="cp" valign="top" align="right" width="180" height="12"></td>
									</tr>
									<tr>
										<td valign="top" width="7" height="1">
											<img height="1" src="assets/img/2.png" width="7" border="0">
										</td>
										<td valign="top" width="180" height="1">
											<img height="1" src="assets/img/2.png" width="180" border="0">
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td align="right" width="10">
							<table cellspacing="0" cellpadding="0" border="0" align="left">
								<tbody>
									<tr>
										<td class="ct" valign="top" width="7" height="13">
											<img height="13" src="assets/img/1.png" width="1" border="0">
										</td>
									</tr>
									<tr>
										<td class="cp" valign="top" width="7" height="12">
											<img height="12" src="assets/img/1.png" width="1" border="0">
										</td>
									</tr>
								</tbody>
							</table>
						</td>
						<td align="right" width="188">
							<table cellspacing="0" cellpadding="0" border="0">
								<tbody>
									<tr>
										<td class="ct" valign="top" width="7" height="13">
											<img height="13" src="assets/img/1.png" width="1" border="0">
										</td>
										<td class="ct" valign="top" width="180" height="13">
											(=) Valor cobrado
										</td>
									</tr>
									<tr>
										<td class="cp" valign="top" width="7" height="12">
											<img height="12" src="assets/img/1.png" width="1" border="0">
										</td>
										<td class="cp" valign="top" align="right" width="180" height="12"></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
			<table cellspacing="0" cellpadding="0" width="666" border="0">
				<tbody>
					<tr>
						<td valign="top" width="666" height="1">
							<img height="1" src="assets/img/2.png" width="666" border="0">
						</td>
					</tr>
				</tbody>
			</table>
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
					<tr>
						<td class="ct" valign="top" width="7" height="13">
							<img height="13" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="ct" valign="top" width="659" height="13">
							Sacado
						</td>
					</tr>
					<tr>
						<td class="cp" valign="top" width="7" height="12">
							<img height="12" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="cp" valign="top" width="659" height="12">
							<span class="campo"><?php echo $dadosboleto["sacado"]?></span>
						</td>
					</tr>
				</tbody>
			</table>
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
					<tr>
						<td class="cp" valign="top" width="7" height="12">
							<img height="12" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="cp" valign="top" width="659" height="12">
							<span class="campo"><?php echo $dadosboleto["endereco1"]?></span>
						</td>
					</tr>
				</tbody>
			</table>
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
					<tr>
						<td class="ct" valign="top" width="7" height="13">
							<img height="13" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="cp" valign="top" width="472" height="13">
							<span class="campo"><?php echo $dadosboleto["endereco2"]?></span>
						</td>
						<td class="ct" valign="top" width="7" height="13">
							<img height="13" src="assets/img/1.png" width="1" border="0">
						</td>
						<td class="ct" valign="top" width="180" height="13">
							Cód. baixa
						</td>
					</tr>
					<tr>
						<td valign="top" width="7" height="1">
							<img height="1" src="assets/img/2.png" width="7" border="0">
						</td>
						<td valign="top" width="472" height="1">
							<img height="1" src="assets/img/2.png" width="472" border="0">
						</td>
						<td valign="top" width="7" height="1">
							<img height="1" src="assets/img/2.png" width="7" border="0">
						</td>
						<td valign="top" width="180" height="1">
							<img height="1" src="assets/img/2.png" width="180" border="0">
						</td>
					</tr>
				</tbody>
			</table>
			<table cellspacing="0" cellpadding="0" border="0" width="666">
				<tbody>
					<tr>
						<td class="ct" width="7" height="12"></td>
						<td class="ct" width="409">
							Sacador/Avalista
						</td>
						<td class="ct" width="250">
							<div align="right">
								Autenticação mecânica - <b class="cp">Ficha de Compensação</b>
							</div>
						</td>
					</tr>
					<tr>
						<td class="ct" colspan="3"></td>
					</tr>
				</tbody>
			</table>
			<table cellspacing="0" cellpadding="0" width="666" border="0">
				<tbody>
					<tr>
						<td valign="bottom" align="left" height="50">
							<?php $billetObject->fbarcode($dadosboleto["codigo_barras"]); ?>
						</td>
					</tr>
				</tbody>
			</table>
			<table cellspacing="0" cellpadding="0" width="666" border="0">
				<tr>
					<td class="ct" width="666"></td>
				</tr>
				<tbody>
					<tr>
						<td class="ct" width="666">
							<div align="right">
								Corte na linha pontilhada
							</div>
						</td>
					</tr>
					<tr>
						<td class="ct" width="666">
							<img height="1" src="assets/img/6.png" width="665" border="0">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	</body>
</html>


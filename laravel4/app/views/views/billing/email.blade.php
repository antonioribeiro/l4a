<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<img align="right" src="{{ URL::to('/') }}/assets/img/logo_cys_55px.png"><br>
		Prezado Cliente,<br>
		<br>
		Este é um e-mail de aviso de emissão de boleto de cobrança. A partir de agora seus boletos CyS estão disponíveis online, no nosso <a href="http://www.cys.com.br/web/index.php?option=com_wrapper&Itemid=84">Painel de Controle</a>.<br>
		<br>
		Segue o link para o boleto deste mês: {{ URL::to('http://cysmail.com/billet/'.$bill['CODIGO_CLIENTE'].'/'.$bill['NUMERO_DOCUMENTO'].'/'.md5($bill['VALOR'])) }}.<br>
		<br>

		@if($other)
			Constam em aberto também as faturas abaixo listadas:<br>
			<br>
			@foreach($other as $o)
				&nbsp;&nbsp;&nbsp;{{date("d/m/Y", strtotime($o['DATA_VENCIMENTO']))}} - 
				R$ {{number_format($o['VALOR']-$o['DESCONTO'], 2, ',', '.')}} - 
				<a href="{{ URL::to('http://cysmail.com/billet/'.$o['CODIGO_CLIENTE'].'/'.$o['NUMERO_DOCUMENTO'].'/'.md5($o['VALOR'])) }}">Boleto</a><br>	
			@endforeach
			<br>
		@endif

		Esta mensagem foi enviada para o(s) endereço(s) {{ $bill['EMAIL'] }}, caso deseje alterar destinatários dos e-mails de cobrança, por favor entre em contato conosco.<br>
		<br>
		Abaixo nossos telefones:<br>
		<br>
		8088-2233 ou 9644-4722 - Antonio Carlos<br>
		9919-0326 ou 8088-2229 - Anselmo<br>
		<br>
		Atenciosamente,<br>
		Equipe CyS<br>
		<br>
	</body>
</html>
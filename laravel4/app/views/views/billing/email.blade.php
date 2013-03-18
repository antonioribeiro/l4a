<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<img src="http://cysmail.com/img/logo_empresa.png">

		Prezado Cliente,<br>
		<br>
		Este é um e-mail de aviso de emissão de boleto de cobrança. A partir de agora seus boletos CyS estão disponíveis online, no nosso <a href="http://www.cys.com.br/web/index.php?option=com_wrapper&Itemid=84">Painel de Controle</a>.<br>
		<br>
		Segue o link para o boleto deste mês: {{ URL::to('http://cysmail.com/billet/'.$CODIGO_CLIENTE.'/'.$NUMERO_DOCUMENTO.'/'.md5($VALOR)) }}.<br>
		<br>
		Esta mensagem foi enviada para o(s) endereço(s) {{ $EMAIL }}, caso deseje alterar os endereços para envio da cobrança, por favor entre em contato conosco.<br>
		<br>
		Abaixo nossos telefones:<br>
		<br>
		8088-2233 ou 9644-4722 - Antonio Carlos<br>
		9919-0326 ou 8088-2229 - Anselmo<br>
		<br>
		Atenciosamente,<br>
		Equipe CyS<br>
	</body>
</html>
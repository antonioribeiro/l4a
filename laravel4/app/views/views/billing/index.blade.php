{{ htmlentities('Boletos do mês para enviar') }}<br>
<br>

<form method="GET" action="{{ URL::to('billing') }}">
	Data vencimento: 
		<input id="dueDate" name="dueDate" type="text" value="{{$dueDate}}">
		<input type="submit" value="Alterar vencimento">
		<input id="hid" name="hid" type="hidden" value="HHHHHHHHHHHHHH">
</form>

@foreach($bills as $bill)
	{{ Helpers::charsEtdecode($bill->RAZAO_SOCIAL) . " - " . date("d/m/Y", strtotime($bill->DATA_VENCIMENTO))  . " - " . $bill->EMAIL}} - <a href="{{ URL::to('http://cysmail.com/billet/'.$bill->CODIGO_CLIENTE.'/'.$bill->NUMERO_DOCUMENTO.'/'.md5($bill->VALOR)) }}">Boleto</a><br>
@endforeach
<br>

<form method="GET" action="{{ URL::to('/billing/send') }}">
	<input type="submit" value="Enviar todos os boletos com vencimento em {{$dueDate}} por e-mail">
</form>

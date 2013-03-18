{{ 'billing system' }}
<br>
@foreach($bills as $bill)
	{{ Helpers::charsEtdecode($bill->RAZAO_SOCIAL) . " - " . $bill->DATA_VENCIMENTO  . " - " . $bill->EMAIL}}<br>
@endforeach


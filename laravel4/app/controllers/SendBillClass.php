<?php

class SendBill {
	public function fire($job, $data)
	{

		$bill = $data['bill'];

		$other = DB::select("select 
											cl.codigo_cliente
										,	cl.razao_social
										,   cl.email
										,	co.valor
										,	co.desconto
										, 	co.numero_documento
										, 	co.data_vencimento
										, 	co.data_documento
									from CA_COBRANCA co 
									join CA_CLIENTE cl on cl.CODIGO_CLIENTE = co.CODIGO_CLIENTE
									where co.DATA_PAGAMENTO is null and co.DATA_CANCELAMENTO is null
									and co.data_vencimento < '2013-03-15 00:00:00'
									and cl.codigo_cliente = ".$bill->CODIGO_CLIENTE."
									order by cl.codigo_cliente, co.data_vencimento desc");


		Mail::send('views.billing.email', array('bill' => Helpers::toArray($bill), 'other' => Helpers::toArray($other)), function($m) use ($bill)
		{
			$bill->EMAIL="antoniocarlos@cys.com.br"; // for testing purposes
			$addresses = array($bill->EMAIL); // for testing purposes

			// just comment the following line to test:
			$addresses=split ('[,;]', $bill->EMAIL); $m->cc('cobranca@cys.com.br');
			
			$m->from('cobranca@cys.com.br', 'Cobrança CyS');
			$m->subject('[CyS - Cobrança] '.$bill->RAZAO_SOCIAL.' - Boleto com vencimento em 22/03/2013');
			$m->addReplyTo('relacionamento@cys.com.br');

			foreach ($addresses as $key => $address) {
				$m->to($address);
			}
		});
	}
}

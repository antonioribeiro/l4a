<?php

class BillingController extends BaseController {

	public function index()
	{
		$bills = $this->getUnpaidBills();

		return View::make('views.billing.index',array('bills' => $bills));
	}

	public function sendBills()
	{
		$bills = $this->getUnpaidBills();

		return $this->sendBillsEmails($bills);
	}

	public function sendBillsEmails($bills) {
		foreach($bills as $bill) {
			Queue::push('SendBill', array('bill' => $bill));

			break;
		}

		return "Mail sent";
	}

	public function getUnpaidBills() {
		return DB::select("select 
													cl.codigo_cliente
												,	cl.razao_social
												,   cl.email
												,	co.valor
												,	co.desconto
												, 	co.numero_documento
												, 	co.data_vencimento
											from CA_COBRANCA co 
											join CA_CLIENTE cl on cl.CODIGO_CLIENTE = co.CODIGO_CLIENTE
											where co.DATA_PAGAMENTO is null and co.DATA_CANCELAMENTO is null
											and co.data_vencimento = '2013-03-15 00:00:00'
											order by cl.codigo_cliente, co.data_vencimento desc");		
	}
}

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
									from CA_COBRANCA co 
									join CA_CLIENTE cl on cl.CODIGO_CLIENTE = co.CODIGO_CLIENTE
									where co.DATA_PAGAMENTO is null and co.DATA_CANCELAMENTO is null
									and co.data_vencimento < '2013-03-15 00:00:00'
									and cl.codigo_cliente = ".$data['bill']->CODIGO_CLIENTE."
									order by cl.codigo_cliente, co.data_vencimento desc");

		Mail::send('views.billing.email', array('bill' => Helpers::toArray($bill), 'other' => Helpers::toArray($other)), function($m) use ($bill)
		{
			$bill->EMAIL="antoniocarlos@cys.com.br,anselmo@cys.com.br";

			$addresses=split ('[,;]', $bill->EMAIL);

			$m->from('cobranca@cys.com.br', 'Cobrança CyS')
				->cc('cobranca@cys.com.br')
				->subject('[CyS - Cobrança] '.$bill->RAZAO_SOCIAL.' - Boleto com vencimento em 15/03/2013');

			foreach ($addresses as $key => $address) {
				$m->to($address);
			}
		});
    }

}

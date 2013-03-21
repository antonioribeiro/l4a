<?php

class BillingController extends BaseController {

	private $date;

	public function __construct()
	{
		$this->date = new ExpressiveDate;
		$this->date->setDefaultDateFormat('d/m/Y');

		App::make('swift.mailer')->registerPlugin(new Swift_Plugins_AntiFloodPlugin(9)); /// send 9 mails on a single connection
	}

	public function index()
	{
		$dueDate = $this->getDueDate();

		return $this->showBills($dueDate);
	}

	public function getDueDate() {
		$dueDate = Input::get('dueDate');

		if (!$dueDate) {
			$dueDate = $this->date;
		}

		return $dueDate;
	}

	public function showBills($dueDate) {
		$dueDateList = $this->getDueDateList(Helpers::englishDate($dueDate));
		$bills = $this->getUnpaidBills(Helpers::englishDate($dueDate));

		return View::make('views.billing.index',array('bills' => $bills, 'dueDate' => $dueDate, 'dueDateList' => $dueDateList));
	}

	public function filter($dueDate)
	{
		return $this->showBills($dueDate);
	}

	public function sendBills()
	{
		$dueDate = $this->getDueDate();
		$bills = $this->getUnpaidBills(Helpers::englishDate($dueDate));

		return $this->sendBillsEmails($bills);
	}

	public function sendBillsEmails($bills) {
		foreach($bills as $bill) {
			$this->sendBillEmail($bill);
		}

		return "<br>All e-mails sent.";
	}

	private function sendBillEmail($bill) {
		Queue::push('SendBill', array('bill' => $bill));
		echo "Sending billing mail to $bill->RAZAO_SOCIAL...<br>";
	}

	public function getUnpaidBills($dueDate) {
		if (!$dueDate) {
			return false;
		}

		return DB::select( $this->getBillingFields()."
											from CA_COBRANCA co 
											join CA_CLIENTE cl on cl.CODIGO_CLIENTE = co.CODIGO_CLIENTE
											where co.DATA_PAGAMENTO is null and co.DATA_CANCELAMENTO is null
											and co.data_vencimento = '".$dueDate." 00:00:00'
											order by cl.codigo_cliente, co.data_vencimento desc"
						);		
	}

	public function getBillingFields() {
		return "select 
							cl.codigo_cliente
						,	cl.razao_social
						,	cl.nome_fantasia
						,   cl.email
						,	co.valor
						,	co.desconto
						, 	co.numero_documento
						, 	co.data_vencimento
						, 	co.data_documento";
	}

	public function getDueDateList($dueDate) {
		return DB::select("select distinct co.data_vencimento from CA_COBRANCA co where co.DATA_PAGAMENTO is null and co.DATA_CANCELAMENTO is null order by co.data_vencimento desc");
	}

	public function buildFile() {
		$bills = $this->getUnpaidBills();

		$file = CNAB400::generateFile($bills);

		/*$fileName = "remessa.txt";
		header('Content-Type: application/txt'); 
		header("Content-length: " . strlen($file)); 
		header('Content-Disposition: attachment; filename="' . $fileName . '"'); 
		echo $file;

		exit();*/

		return strlen($file)." - ".$file;
	}

	public function locateBill($customer, $invoice, $hash) {
		$bill = DB::select( $this->getBillingFields()."
						from CA_COBRANCA co 
						join CA_CLIENTE cl on cl.CODIGO_CLIENTE = co.CODIGO_CLIENTE
						where co.CODIGO_CLIENTE = '$customer' and NUMERO_DOCUMENTO = '$invoice'");		

		if (!$bill or $hash != md5($bill[0]->VALOR)) {
			$bill = NULL;
		}

		return $bill;
	}

	public function sendBillet($customer, $invoice, $hash) {
		if(!($bill = $this->locateBill($customer, $invoice, $hash))) {
			return View::make('views.billing.billNotFound');
		} else {
			//$this->sendBillEmail($bill)
			return View::make('views.billing.billSent');
		}
	}
}

@extends('layouts.main')

@section('content')
	<h1>Cobrança</h1>
		<br>
		<div class="text-center">
			<form method="POST" action="{{ URL::to('billing') }}">
				<fieldset>
					<input type="text" class="input-medium search-query" name="dueDate" id="dueDate" placeholder="Vencimento" value="{{$dueDate}}">
					<button type="submit" class="btn">Filtrar</button>
				</fieldset>
			</form>

			<table class="table table-striped table-bordered center">
				<thead>
					<tr>
						<th><h4 class="text-center">Cobranças em aberto por data de vencimento</h4></th>
					</tr>
				</thead>
				<tr>
					<td><p class="text-center">
						<?php 
							$records = 0;
							foreach($dueDateList as $date) {
								$records++;
								$date = new ExpressiveDate($date->DATA_VENCIMENTO);
								$date->setDefaultDateFormat('d-m-Y');
								//echo '<form method="POST" action="'.URL::to('/billing/filter/'.$date).'">';
								echo '<button class="btn btn-mini btn-primary" type="submit" formmethod="POST" onclick="document.location=\''.URL::to('/billing/filter/'.$date).'\'"">'.$date.'</button>&nbsp;';
								//echo '</form>';
								if($records == 11) {
									echo "</p><p class=\"text-center\">";
								}
								if($records == 22) {
									break;
								}
							}
						?>
						</p>
					</td>
				</tr>
			</table>
		</div>
		<br>

		<h4>Boletos em aberto com vencimento em {{$dueDate}}</h4>
		<section id="tables">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Empresa</th>
						<th>Referência</th>
						<th>Vencimento</th>
						<th>Valor</th>
						<th>Link</th>
						<th>Ações</th>
					</tr>
				</thead>			
				@foreach($bills as $bill)
					<tr>
						<td><p>{{ Helpers::charsEtdecode($bill->RAZAO_SOCIAL) . ($bill->RAZAO_SOCIAL != $bill->NOME_FANTASIA ? ' ('.$bill->NOME_FANTASIA.')' : '') }}</p></td>
						<td class="text-center"><p>{{ date("d-m-Y", strtotime($bill->DATA_DOCUMENTO)) }}</p></td>
						<td class="text-center"><p>{{ date("d-m-Y", strtotime($bill->DATA_VENCIMENTO)) }}</p></td>
						<td><p>{{ $bill->VALOR }}</p></td>
						<td class="text-center"><p><a href="{{ URL::to('/billet/'.$bill->CODIGO_CLIENTE.'/'.$bill->NUMERO_DOCUMENTO.'/'.md5($bill->VALOR)) }}">Boleto</a></p></td>
						<td class="text-center"><button class="btn btn-mini btn-primary" type="submit" formmethod="GET" onclick="document.location='{{URL::to('/billet/'.$bill->CODIGO_CLIENTE.'/'.$bill->NUMERO_DOCUMENTO.'/'.md5($bill->VALOR).'/send')}}'">Enviar</button></td>

					</tr>
				@endforeach
			</table>
		</section>

		<br>

		<form method="POST" action="{{ URL::to('/billing/send') }}">
			<button type="submit" class="btn btn-danger">Enviar todos os boletos com vencimento em {{$dueDate}} por e-mail</button>
			<input id="dueDate" name="dueDate" type="hidden" size="12" value="{{$dueDate}}">
		</form>
@stop

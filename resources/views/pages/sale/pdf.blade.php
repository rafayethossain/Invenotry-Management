<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Print Sale</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<style type="text/css">
	.sign{
		padding-top: 60px;
	}
	.sign span{
		margin: 0 auto;
		width: 200px;
		padding-top: 10px;
		display: block;
		border-top: 1px solid #111;
		text-align: center;
	}
</style>
</head>
<body>
	<div class="container">
		<div class="container">
			<h2 style="text-align: center;">Order No {{$id}}</h2>
			<br>
			<div class="col-md-6">
				<table>
					<tr>
						<td>Sale Date: {{$sales[0]->sale_date}}</td>					
					</tr>
					<tr>
						<td>Invoice No.: {{$sales[0]->invoice_no}}</td>
					</tr>
					<tr>
						<td>Sales Representative: {{ $sales[0]->user->name }}</td>
					</tr>
				</table>
			</div>
			<div class="col-md-6">
				<table>
					<tr>
						<td>
							Customer Name: {{ $sales[0]->customer->customer_name }}
						</td>
					</tr>
					<tr>
						<td>Customer Address: {{ $sales[0]->customer->customer_address }}</td>
					</tr>
				</table>
			</div>
			<br>
			<div class="col-md-12">
				<table id="myTable">
					<thead>
						<tr>
							<th style="width:10%;">Sl</th>	
							<th style="width:20%;">Product Name</th>				
							<th style="width:15%;">Quantity</th>
							<th style="width:15%;">MRP</th>
							<th style="width:10%;">TP (%)</th>
							<th style="width:15%;">Trade Price</th>					
							<th style="width:15%;">Total</th>
						</tr>
					</thead>
					<tbody>
						@foreach($sales as $sale)
						<tr>
							<td>{{$loop->iteration}}</td>
							<td>{{ $sale->product->product_name }}</td>
							@php
							$sum = array();
							$quantity = explode("|",$sale->quantity);
							$sum = array_merge($sum, $quantity);
							$total = array_sum($sum);
							@endphp
							<td>{{ $total }}</td>
							<td>{{ $sale->product->mrp}}</td>
							<td>{{ $sale->trade_price}}</td>
							<td>{{ $sale->tp_amount}}</td>					
							<td>{{ $sale->total}}</td>				
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th colspan="6" style="text-align:right">Total: {{array_sum($sale_total)}}</th>
							<th></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
		<div class="row sign">
			<table class="col-md-12">
				<tr>
					<td><span>Authorized By</span></td>
					<td><span>Received By</span></td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>
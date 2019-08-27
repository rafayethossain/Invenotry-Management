<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Print Sale</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>	
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
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
	
	@media print {
		@page { 
			size: auto;
			margin-bottom: 1.3cm; margin-top: 4.75cm;
		}

		table { page-break-after:auto }
		tr    { page-break-inside:avoid; page-break-after:auto }
		td    { page-break-inside:avoid; page-break-after:auto }
		thead { display:table-header-group }
		tfoot { display:table-footer-group }
	}
</style>
</head>
<body>
	<div class="container">
		<div class="container">
			<h2 style="text-align: center;">Order No {{$id}}</h2>
			<br>
			<div class="row">
				<div class="col-sm-6">
					<h6>Sale Date: {{$sales[0]->sale_date}}</h6>
					<h6>Invoice No.: {{$sales[0]->invoice_no}}</h6>
					<h6>Sales Representative: {{ $sales[0]->user->name }}</h6>
				</div>
				<div class="col-sm-6">
					<h6>Customer Name: {{ $sales[0]->customer->customer_name }}</h6>
					<h6>Customer Address: {{ $sales[0]->customer->customer_address }}</h6>
				</div>
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
							<th colspan="6" style="text-align:right">Total:</th>
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
	
	<script>
		$(document).ready(function(){
			$('#myTable').DataTable({
				"columnDefs": [{
					"targets": 'no-sort',
					"orderable": false,
				}],
				searching: false, 
				paging: false,
				info: false,

				"footerCallback": function ( row, data, start, end, display ) {
					var api = this.api(), data;

			    // Remove the formatting to get integer data for summation
			    var intVal = function ( i ) {
			    	return typeof i === 'string' ?
			    	i.replace(/[\$,]/g, '')*1 :
			    	typeof i === 'number' ?
			    	i : 0;
			    };

			    // Total over all pages
			    total = api
			    .column( 6 )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    });

			    // Total over this page
			    pageTotal = api
			    .column( 6, { page: 'current'} )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    });

			    // Update footer
			    $( api.column( 6 ).footer() ).html(
			    	''+total +''
			    	);
			}
		});
		});
	</script>
</body>
</html>
@extends('layouts.master')
@section('title', 'Sale')

@section('content')
<div class="content-header">
	<a href="{{ url('sale') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Sales List
	</a>         
</div>
<br>

<div class="container">
	<h2 style="text-align: center;">Order No {{$id}}</h2>
	<hr>
	<h4>Sale Date: {{$sales[0]->sale_date}}</h4>
	<h4>Invoice No.: {{$sales[0]->invoice_no}}</h4>
	<h4>Customer Name: {{ $sales[0]->customer->customer_name }}</h4>
	<h4>Customer Address: {{ $sales[0]->customer->customer_address }}</h4>
	<h4>Sales Representative: {{ $sales[0]->user->name }}</h4>
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
@endsection

@section('script')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script>
	$(document).ready(function(){
		$('#myTable').DataTable({
			"columnDefs": [{
				"targets": 'no-sort',
				"orderable": false,
			}],
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
			        ''+pageTotal +' ( '+ total +' total)'
			    );
			}
		});
	});
</script>
<script>
	$(".delete-item").on("submit", function(){
		return confirm("Do you want to delete this item?");
	});
</script>
@endsection
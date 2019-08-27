@extends('layouts.master')
@section('title', 'Products')

@section('content')
<div class="content-header">
	<a href="{{url('printquotation', $trade_price)}}" target="_blank" class="btn btn-info">
		<i class="fa fa-print" aria-hidden="true" title="Print"></i>
		Print
	</a>
	<a href="{{url('pdfquotation', $trade_price)}}" target="_blank" class="btn btn-info">
		<i class="fa fa-file-pdf-o" aria-hidden="true" title="PDF"></i>
		PDF
	</a>
	<a href="{{url('excelquotation', $trade_price)}}" target="_blank" class="btn btn-info">
		<i class="fa fa-file-excel-o" aria-hidden="true" title="Excel"></i>
		Excel
	</a>
	<form id="particularexpense" method="GET" action="{{url('quotation/pricelist')}}" class="form-inline">
		{{ csrf_field() }}
		<label for="inlineFormCustomSelect">Trade Price (%)</label>
		<input type="number" step="any" min="0" name="trade_price" id="trade_price" class="form-control" placeholder="Trade Price">
		<button type="submit" class="btn btn-info">Calculate</button>
	</form>         
</div>
<br>
@if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
     	<strong>{{session('status')}}</strong>
      	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      	</button>
    </div>
@endif
<div class="container">
	<h2 style="text-align: center;">Price Quotation</h2>
	<hr>
	<div class="col-md-12">
		<table id="myTable">
			<thead>
				<tr>
					<th class="no-sort" style="width:10%;">Sl</th>
					<th style="width:30%;">Name</th>
					<th class="no-sort" style="width:20%;">MRP</th>
					<th class="no-sort" style="width:20%;">Trade Price ({{$trade_price}} %)</th>
					<th class="no-sort" style="width:20%;">Image</th>
				</tr>
			</thead>
			<tbody>
				@foreach($products as $product)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{ $product->product_name }}</td>
					<td>{{ $product->mrp }}</td>
					<td>{{ceil(($product->mrp * 100 ) / ($trade_price + 100))}}</td>
					<td><img src="{{ asset('images/products/'.$product->product_image) }}" class="avatar"></td>
				</tr>
				@endforeach
			</tbody>
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
			}]
		});
	});
</script>
<script>
	$(".delete-item").on("submit", function(){
		return confirm("Do you want to delete this item?");
	});
</script>
@endsection
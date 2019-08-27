@extends('layouts.master')
@section('title', 'Purchases')

@section('content')
<div class="content-header">
	<a href="{{ url('purchase/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add Purchase
	</a>
	<a href="{{ url('purchase/add-via-barcode') }}" class="btn btn-info">
		<i class="fa fa-barcode" aria-hidden="true"></i>
		Add via Barcode
	</a>
	<form id="particularexpense" method="GET" action="{{url('purchase/report')}}" class="form-inline">
		{{ csrf_field() }}
		<label for="inlineFormCustomSelect">Start Date</label>
		<input type="text" name="start_date" id="start_date" class="form-control" placeholder="Start Date">
		<label for="inlineFormCustomSelect">End Date</label>
		<input type="text" name="end_date" id="end_date" class="form-control" placeholder="End Date">
		<button type="submit" class="btn btn-info"><i class="fa fa-line-chart" aria-hidden="true"></i> Report</button>
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
	<h2 style="text-align: center;">Purchases List</h2>
	<hr>
	<div class="col-md-12">
		<table id="myTable">
			<thead>
				<tr>
					<th class="no-sort" style="width:10%;">Sl</th>
					<th style="width:15%;">Date</th>					
					<th style="width:20%;">Product Name</th>
					<th style="width:15%;">Invoice No</th>					
					<th style="width:15%;">Quantity</th>
					@role('super_admin')
					<th style="width:15%;">Purchase Price</th>
					<th style="width:10%;" class="no-sort">Actions</th>
					@endrole
				</tr>
			</thead>
			<tbody>
				@foreach($purchases as $purchase)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{ $purchase->purchase_date }}</td>
					<td>{{ $purchase->product->product_name }}</td>
					<td>{{ $purchase->invoice_no }}</td>					
					<td>{{ $purchase->quantity }}</td>
					@role('super_admin')
					<td>{{ $purchase->purchase_price }}</td>
					<td>

						<a href="{{route('purchase.edit', $purchase->id)}}" style="margin-left: 3px;"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit"></i></a>
						
					</td>
					@endrole
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

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script>
	$( function() {
		$( "#start_date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		});
	} );
</script>

<script>
	$( function() {
		$( "#end_date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		});
	} );
</script>
@endsection
@extends('layouts.master')
@section('title', 'Order')

@section('content')
<div class="content-header">
	<a href="{{ url('order/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add Order
	</a>         
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
	<h2 style="text-align: center;">Order List</h2>
	<hr>
	<div class="col-md-12">
		<table id="myTable">
			<thead>
				<tr>
					<th class="no-sort" style="width:10%;">Sl</th>	
					<th style="width:10%;">Order ID</th>				
					<th style="width:15%;">Order Date</th>
					<th style="width:20%;">Customer Name</th>								
					<th style="width:25%;">Seller Name</th>
					<th style="width:10%;">Status</th>
					<th style="width:10%;" class="no-sort">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($orders as $order)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{ $order->order_id }}</td>
					<td>{{ $order->order_date }}</td>
					<td>{{ $order->customer->customer_name }}</td>
					<td>{{ $order->user->name }}</td>
					@if($order->status == 0)
					<td><span class="badge badge-warning">Pending</span></td>
					@else
					<td><span class="badge badge-primary">Approved</span></td>
					@endif					
					<td>
						<a href="{{route('order.show', $order->order_id)}}"><i class="fa fa-eye" aria-hidden="true" title="Show"></i></a>
					</td>
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
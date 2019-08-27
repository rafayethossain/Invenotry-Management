@extends('layouts.master')
@section('title', 'Order')

@section('content')
<div class="content-header">
	<a href="{{ url('order') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Order List
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
	<h2 style="text-align: center;">Order No {{$id}}</h2>
	<hr>
	<h4>Order Date: {{$orders[0]->order_date}}</h4>
	<h4>Customer Name: {{ $orders[0]->customer->customer_name }}</h4>
	<h4>Customer Address: {{ $orders[0]->customer->customer_address }}</h4>
	<h4>Sales Representative: {{ $orders[0]->user->name }}</h4>
	<br>
	<div class="col-md-12">
		<table id="myTable">
			<thead>
				<tr>
					<th style="width:20%;">Sl</th>	
					<th style="width:50%;">Product Name</th>				
					<th style="width:30%;">Quantity</th>
				</tr>
			</thead>
			<tbody>
				@foreach($orders as $order)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{ $order->product->product_name }}</td>
					<td>{{ $order->quantity }}</td>					
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<br>
	@if(count($sales) > 0)
	<h3 style="text-align: center;">The Order Was Added To Sale</h3>
	@else 
	<a href="{{url('ordertosale', $id)}}" style="color: black;"><button class="btn btn-success">Add To Sale</button></a>
	@endif
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
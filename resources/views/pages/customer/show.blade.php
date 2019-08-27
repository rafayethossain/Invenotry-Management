@extends('layouts.master')
@section('title', 'Show Customer')

@section('content')
<div class="content-header">
	<a href="{{ url('customer') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Customers
	</a> 

	<a href="{{ url('customer/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add Customer
	</a>

	<a href="{{ url('customer/report',$customer->id) }}" class="btn btn-info">
		<i class="fa fa-line-chart" aria-hidden="true"></i>
		Report
	</a>          
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">{{$customer->customer_name}}</h2>
	<hr>
	<div class="col-md-12">
		<h5>Customer Mobile Number: {{$customer->customer_mobile}}</h5>
		<h5>Customer Email: {{$customer->customer_email}}</h5>
		<h5>Customer Area: {{$customer->area->area_name}}</h5>
		<h5>Trade Price: {{$customer->trade_price}} %</h5>
		<h5>Customer Address: {{$customer->customer_address}}</h5>
		<h5>Created By: {{$added_by->name}}</h5>
		@if($customer->edited_by)
		<h5>Edited By: {{$edited_by->name}}</h5>
		@endif
	</div>
</div>
@endsection
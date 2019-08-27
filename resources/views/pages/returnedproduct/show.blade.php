@extends('layouts.master')
@section('title', 'Show Return')

@section('content')
<div class="content-header">
	<a href="{{ url('returnedproduct') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Returned Product List
	</a> 

	<a href="{{ url('returnedproduct/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add Return
	</a>          
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">About this Return</h2>
	<hr>
	<div class="col-md-12">
		<h5>Return Date: {{ $returnedproduct->date }}</h5>
		<h5>Product {{ $returnedproduct->product->product_name }}</h5>
		<h5>Quantity: {{ $returnedproduct->quantity }}</h5>
		<h5>Customer Name: {{ $returnedproduct->customer->customer_name }}</h5>
		<h5>Created By: {{$added_by->name}}</h5>
		@if($returnedproduct->edited_by)
		<h5>Edited By: {{$edited_by->name}}</h5>
		@endif
		<h5>Details: {{ $returnedproduct->details }}</h5>

	</div>
</div>
@endsection
@extends('layouts.master')
@section('title', 'Show Income')

@section('content')
<div class="content-header">
	<a href="{{ url('income') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Income List
	</a> 

	<a href="{{ url('income/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add Income
	</a>          
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">About Income</h2>
	<hr>
	<div class="col-md-12">
		<h5>Income Date: {{ $income->income_date }}</h5>
		<h5>Customer Name: {{ $income->customer->customer_name }}</h5>
		<h5>Purpose: {{ $income->purpose }}</h5>
		<h5>Payment Type: {{$income->payment_type =='1' ? 'Cash' : 'Cheque'}}</h5>
		@if($income->payment_type == 2)
		<h5>Cheque Number: {{$income->cheque_number}}</h5>
		@endif
		<h5>Amount: {{ $income->amount }}</h5>
		<h5>Created By: {{$added_by->name}}</h5>
		@if($income->edited_by)
		<h5>Edited By: {{$edited_by->name}}</h5>
		@endif
		<h5>Details: {{ $income->details }}</h5>
	</div>
</div>
@endsection
@extends('layouts.master')
@section('title', 'Show Expense')

@section('content')
<div class="content-header">
	<a href="{{ url('expense') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Expense List
	</a> 

	<a href="{{ url('expense/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add Expense
	</a>
	@if($expense->expense_item_id == 2)
	<a href="{{url('print-expense', $expense->id)}}" target="_blank" class="btn btn-info">
		<i class="fa fa-print" aria-hidden="true" title="Print"></i>
		Print
	</a>
	@endif          
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">About Expense</h2>
	<hr>
	<div class="col-md-12">
		<h5>Expense Date: {{ $expense->expense_date }}</h5>
		<h5>Purpose: {{ $expense->expenseitem->name }}</h5>
		@if($expense->expense_item_id == 2)
		<h5>Customer Name: {{ $customer->customer_name }}</h5>
		<table id="myTable">
			<thead>
				<tr>
					<th class="no-sort" style="width:10%;">Sl</th>
					<th style="width:20%;">Product</th>					
					<th class="no-sort" style="width:30%;">Quantity</th>
				</tr>
			</thead>
			<tbody>
				@for ($i=0; $i < count($products); $i++)
				<tr>
					<td>{{$i+1}}</td>
					<td>{{ $products[$i]->product_name }}</td>
					<td>{{ $quantity[$i] }}</td>
				</tr>
				@endfor
			</tbody>
		</table>
		@endif

		@if($expense->expense_item_id == 1)
		<h5>Customer Name: {{ $customer->customer_name }}</h5>
		@endif

		@if($expense->expense_item_id == 3 || $expense->expense_item_id == 4)
		<h5>Employee Name: {{ $user->name }}</h5>
		@endif

		<h5>Amount: {{ $expense->amount }}</h5>
		<h5>Created By: {{$added_by->name}}</h5>
		@if($expense->edited_by)
		<h5>Edited By: {{$edited_by->name}}</h5>
		@endif
		<h5>Details: {{ $expense->details }}</h5>

	</div>
</div>
@endsection
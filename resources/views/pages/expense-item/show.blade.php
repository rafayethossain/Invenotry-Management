@extends('layouts.master')
@section('title', 'Show Expense Item')

@section('content')
<div class="content-header">
	<a href="{{ url('expenseitem') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Expense Item List
	</a> 

	<a href="{{ url('expenseitem/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add New Item
	</a>          
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">{{$expenseitem->name}}</h2>
	<hr>
	<div class="col-md-12">
		<p>{{$expenseitem->details}}</p>
	</div>
</div>
@endsection
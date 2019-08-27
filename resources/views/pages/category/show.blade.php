@extends('layouts.master')
@section('title', 'Show Category')

@section('content')
<div class="content-header">
	<a href="{{ url('category') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Category List
	</a> 

	<a href="{{ url('category/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add Category
	</a>          
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">{{$category->category_name}}</h2>
	<hr>
	<div class="col-md-12">
		<h5>Created By: {{$added_by->name}}</h5>
		@if($category->edited_by)
		<h5>Edited By: {{$edited_by->name}}</h5>
		@endif
		<h5>Category Details: </h5>
		<p>{{$category->category_details}}</p>
	</div>
</div>
@endsection
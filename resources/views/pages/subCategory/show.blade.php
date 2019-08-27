@extends('layouts.master')
@section('title', 'Show Sub Category')

@section('content')
<div class="content-header">
	<a href="{{ url('subcategory') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Sub Category List
	</a> 

	<a href="{{ url('subcategory/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add Sub Category
	</a>          
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">{{$subcategory->subCategory_name}}</h2>
	<hr>
	<div class="col-md-12">
		<h5>Category Name: {{$subcategory->category->category_name}}</h5>
		<h5>Created By: {{$added_by->name}}</h5>
		@if($subcategory->edited_by)
		<h5>Edited By: {{$edited_by->name}}</h5>
		@endif
		<h5>Sub Area Details: </h5>
		<p>{{$subcategory->subCategory_details}}</p>
	</div>
</div>
@endsection
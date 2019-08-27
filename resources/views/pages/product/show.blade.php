@extends('layouts.master')
@section('title', 'Show Product')

@section('content')
<div class="content-header">
	<a href="{{ url('product') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Product List
	</a> 

	<a href="{{ url('product/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add Product
	</a>          
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">{{$product->product_name}}</h2>
	<hr>
	<div class="row">
		<div class="col-sm-8">
			<h5>Product Code: {{$product->product_code}}</h5>
			<h5>Category Name: {{ $product->category->category_name }}</h5>
			<h5>SubCategory Name: {{ $product->subcategory->subCategory_name }}</h5>
			<h5>Current Stock: {{ $product->product_stock }}</h5>
			<h5>MRP: {{ $product->mrp }}</h5>
			<h5>Created By: {{$added_by->name}}</h5>
			@if($product->edited_by)
			<h5>Edited By: {{$edited_by->name}}</h5>
			@endif
			<h5>Product Details: </h5>
			<p>{{$product->product_details}}</p>
		</div>
		<div class="col-sm-4">
			<div>
				<img src="{{ asset('images/products/'.$product->product_image) }}" style="width: 175px;height: auto;">
			</div>
		</div>
	</div>
</div>
@endsection
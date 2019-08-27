@extends('layouts.master')
@section('title', 'Edit Product')

@section('content')
<div class="content-header">
	<a href="{{ url('product') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Product List
	</a>         
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">Edit {{$product->product_name}}</h2>
	<hr>
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-8">
			<form action="{{route('product.update', $product->id)}}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				{{ method_field('PATCH') }}
				<div class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
					<label for="product_name">Product Name <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product->product_name }}" placeholder="Product Name">
					@if ($errors->has('product_name'))
					<span class="help-block">
						<strong>{{ $errors->first('product_name') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('product_code') ? ' has-error' : '' }}">
					<label for="product_code">Product Code <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="text" class="form-control" id="product_code" name="product_code" value="{{ $product->product_code }}" placeholder=" Product Code">
					@if ($errors->has('product_code'))
					<span class="help-block">
						<strong>{{ $errors->first('product_code') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
					<label for="category_id">Category <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<select id="category_id" name="category_id" class="form-control">
						<option value="">Select Category</option>
						@foreach ($categories as $category)
						<option value="{{ $category->id }}" {{ $product->category_id == $category->id ? "selected":"" }}>{{ $category->category_name }}</option>
						@endforeach
					</select>
					@if ($errors->has('category_id'))
					<span class="help-block">
						<strong>{{ $errors->first('category_id') }}</strong>
					</span>
					@endif
				</div>

				<div id="subcategory_info" class="form-group{{ $errors->has('subCategory_id') ? ' has-error' : '' }}">
					<label for="subCategory_id">SubCategory <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<select id="subCategory_id" name="subCategory_id" class="form-control">
						<option value="{{$product->subcategory->id}}">{{$product->subcategory->subCategory_name}}</option>
					</select>
					@if ($errors->has('subCategory_id'))
					<span class="help-block">
						<strong>{{ $errors->first('subCategory_id') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('mrp') ? ' has-error' : '' }}">
					<label for="mrp">Product MRP <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="number" step="any" min="0" class="form-control" id="mrp" name="mrp" value="{{ $product->mrp }}" placeholder=" Product MRP">
					@if ($errors->has('mrp'))
					<span class="help-block">
						<strong>{{ $errors->first('mrp') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group">
					<label for="product_details">Product Details</label>
					<textarea class="form-control" id="product_details" name="product_details" placeholder="Product Details" rows="3" cols="50">{{ $product->product_details }}</textarea>
				</div>

				<div class="form-group">
					<label for="product_image">Product Image</label>
					<input type="file" name="product_image" id="product_image" onchange="readURL(this);">
					<br>
					<img id="blah" src="{{ asset('images/products/'.$product->product_image) }}" alt="" style="width: 150px; height: 125px;"/>
				</div>
				<button type="submit" class="btn btn-success">Update</button>
				<button type="button" class="btn btn-danger" onClick="window.location.href='/product'">Cancel</button>
			</form>
		</div>
		<div class="col-sm-3"></div>
	</div>
</div>
</div>
@endsection

@section('script')
<script>
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#blah')
				.attr('src', e.target.result)
				.width(150)
				.height(125);
			};

			reader.readAsDataURL(input.files[0]);
		}
	}

</script>

<script>
	$('#category_id').on('change', function(){
		var category_id = $('#category_id').val();
		if (category_id != '') {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$.ajax({
				url:"/getsubcategory/"+category_id,  
				method:'GET',                               
				success: function( data ) {
					console.log(data);
					sections = '';
					$.each( data, function( key, value ) {
						sections += '<option value="' + value.id + '">' + value.subCategory_name + '</option>';
					});
					sections += '';

					$( '#subCategory_id' ).html( sections );
				}
			}); 
		}
	});

</script>
@endsection

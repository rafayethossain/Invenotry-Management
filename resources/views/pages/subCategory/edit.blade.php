@extends('layouts.master')
@section('title', 'Edit Sub Category')

@section('content')
<div class="content-header">
	<a href="{{ url('subcategory') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Sub Category List
	</a>         
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">Edit {{$subcategory->subCategory_name}}</h2>
	<hr>
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-8">
			<form action="{{route('subcategory.update', $subcategory->id)}}" method="POST">
				{{ csrf_field() }}
				{{ method_field('PATCH') }}
				<div class="form-group{{ $errors->has('subCategory_name') ? ' has-error' : '' }}">
					<label for="subCategory_name">Sub Category Name <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="text" class="form-control" id="subCategory_name" name="subCategory_name" value="{{ $subcategory->subCategory_name }}" placeholder="Category Name">
					@if ($errors->has('subCategory_name'))
	                    <span class="help-block">
	                        <strong>{{ $errors->first('subCategory_name') }}</strong>
	                    </span>
                    @endif
				</div>

				<div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
					<label for="category_id">Category Name <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<select id="category_id" name="category_id" class="form-control">
						<option value="">Select Category</option>
						@foreach ($categories as $category)
						<option value="{{ $category->id }}" @if($category->id==$subcategory->category_id) selected='selected' @endif>{{ $category->category_name }}</option>
						@endforeach
					</select>
					@if ($errors->has('category_id'))
					<span class="help-block">
						<strong>{{ $errors->first('category_id') }}</strong>
					</span>
					@endif
				</div>
								
				<div class="form-group">
					<label for="subCategory_details">Sub Category Details</label>
					<textarea class="form-control" id="subCategory_details" name="subCategory_details" placeholder="Category Details" rows="5" cols="50">{{ $subcategory->subCategory_details }}</textarea>
				</div>
				<button type="submit" class="btn btn-success">Update</button>
				<button type="button" class="btn btn-danger" onClick="window.location.href='/subcategory'">Cancel</button>
			</form>
		</div>
		<div class="col-sm-3"></div>
	</div>
</div>
</div>
@endsection

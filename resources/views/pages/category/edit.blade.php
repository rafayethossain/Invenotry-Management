@extends('layouts.master')
@section('title', 'Edit Category')

@section('content')
<div class="content-header">
	<a href="{{ url('category') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Category List
	</a>         
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">Edit {{$category->category_name}}</h2>
	<hr>
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-8">
			<form action="{{route('category.update', $category->id)}}" method="POST">
				{{ csrf_field() }}
				{{ method_field('PATCH') }}
				<div class="form-group{{ $errors->has('category_name') ? ' has-error' : '' }}">
					<label for="category_name">Categoty Name <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="text" class="form-control" id="category_name" name="category_name" value="{{$category->category_name}}" placeholder="Category Name">
					@if ($errors->has('category_name'))
	                    <span class="help-block">
	                        <strong>{{ $errors->first('category_name') }}</strong>
	                    </span>
                    @endif
				</div>
				<div class="form-group">
					<label for="category_details">Category Details</label>
					<textarea class="form-control" id="category_details" name="category_details" placeholder="Category Details" rows="5" cols="50">{{$category->category_details}}</textarea>
				</div>
				<button type="submit" class="btn btn-success">Update</button>
				<button type="button" class="btn btn-danger" onClick="window.location.href='/category'">Cancel</button>
			</form>
		</div>
		<div class="col-sm-3"></div>
	</div>
</div>
</div>
@endsection

@extends('layouts.master')
@section('title', 'Create Expense Item')

@section('content')
<div class="content-header">
	<a href="{{ url('expenseitem') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Expense Item List
	</a>         
	<a href="{{ url('expense') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Expense List
	</a>  
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">Create a New Expense Item</h2>
	<hr>
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-8">
			<form action="/expenseitem" method="POST">
				{{ csrf_field() }}
				<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
					<label for="name">Categoty Name <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Expnse Item Name">
					@if ($errors->has('name'))
	                    <span class="help-block">
	                        <strong>{{ $errors->first('name') }}</strong>
	                    </span>
                    @endif
				</div>
				<div class="form-group">
					<label for="details">Details</label>
					<textarea class="form-control" id="details" name="details" placeholder="Details" rows="5" cols="50">{{ old('details') }}</textarea>
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
		<div class="col-sm-3"></div>
	</div>
</div>
</div>
@endsection

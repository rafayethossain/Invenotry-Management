@extends('layouts.master')
@section('title', 'Create Customer')

@section('content')
<div class="content-header">
	<a href="{{ url('customer') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Customer List
	</a>         
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">Add a New Customer</h2>
	<hr>
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-8">
			<form action="/customer" method="POST">
				{{ csrf_field() }}
				<div class="form-group{{ $errors->has('customer_name') ? ' has-error' : '' }}">
					<label for="customer_name">Customer Name <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" placeholder="Customer Name">
					@if ($errors->has('customer_name'))
					<span class="help-block">
						<strong>{{ $errors->first('customer_name') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('customer_mobile') ? ' has-error' : '' }}">
					<label for="customer_mobile">Customer Mobile <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="text" class="form-control" id="customer_mobile" name="customer_mobile" value="{{ old('customer_mobile') }}" placeholder="Customer Mobile">
					@if ($errors->has('customer_mobile'))
					<span class="help-block">
						<strong>{{ $errors->first('customer_mobile') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group">
					<label for="customer_email">Customer Email</label>
					<input type="text" class="form-control" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" placeholder="Customer Email">
				</div>

				<div class="form-group{{ $errors->has('area_id') ? ' has-error' : '' }}">
					<label for="area_id">Area Name <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<select id="area_id" name="area_id" class="form-control">
						<option value="">Select Area</option>
						@foreach ($areas as $area)
						<option value="{{ $area->id }}">{{ $area->area_name }}</option>
						@endforeach
					</select>
					@if ($errors->has('area_id'))
					<span class="help-block">
						<strong>{{ $errors->first('area_id') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('trade_price') ? ' has-error' : '' }}">
					<label for="trade_price">Trade Price <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="text" class="form-control" id="trade_price" name="trade_price" value="{{ old('trade_price') }}" placeholder="Trade Price (%)">
					@if ($errors->has('trade_price'))
					<span class="help-block">
						<strong>{{ $errors->first('trade_price') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group">
					<label for="customer_address">Customer Address</label>
					<textarea class="form-control" id="customer_address" name="customer_address" placeholder="Customer Address" rows="5" cols="50">{{ old('customer_address') }}</textarea>
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
		<div class="col-sm-3"></div>
	</div>
</div>
</div>
@endsection

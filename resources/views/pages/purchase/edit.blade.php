@extends('layouts.master')
@section('title', 'Edit Purchase')

@section('content')
<div class="content-header">
	<a href="{{ url('purchase') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Purchase List
	</a>         
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">Add Products Purchase Price</h2>
	<hr>
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-8">
			<form action="{{route('purchase.update', $purchase->id)}}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				{{ method_field('PATCH') }}

				<div class="form-group{{ $errors->has('purchase_price') ? ' has-error' : '' }}">
					<label for="purchase_price">Purchase Price <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="number" min="0" class="form-control" id="purchase_price" name="purchase_price" @if($purchase->purchase_price) value="{{$purchase->purchase_price}}" @else value="{{ old('purchase_price') }}" @endif placeholder="Purchase Price">
					@if ($errors->has('purchase_price'))
					<span class="help-block">
						<strong>{{ $errors->first('purchase_price') }}</strong>
					</span>
					@endif
				</div>

				<button type="submit" class="btn btn-success">Submit</button>
			</form>
		</div>
		<div class="col-sm-3"></div>
	</div>
</div>
</div>
@endsection

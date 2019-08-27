@extends('layouts.master')
@section('title', 'Quotation')

@section('content')
<div class="content-header">
	<h2 style="text-align: center;">Price Quotation</h2> 
	<br><br>
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<form id="particularexpense" method="GET" action="{{url('quotation/pricelist')}}" class="form-inline">
				{{ csrf_field() }}
				<label for="inlineFormCustomSelect">Trade Price (%)</label>
				<input type="number" step="any" min="0" name="trade_price" id="trade_price" class="form-control" placeholder="Trade Price">
				<button type="submit" class="btn btn-info">Calculate</button>
			</form>
		</div>
		<div class="col-md-2"></div>
	</div>       
</div>
@endsection

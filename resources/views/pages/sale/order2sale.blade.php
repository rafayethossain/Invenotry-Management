@extends('layouts.master')
@section('title', 'Create Sale')

@section('content')
<div class="content-header">
	<a href="{{ url('sale') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Sale List
	</a>         
</div>
<br>
@if(session('status'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>{{session('status')}}</strong>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif
<div class="container">
	<h2 style="text-align: center;">Order No {{$id}}</h2>
	<hr>
	<h4>Order Date: {{$orders[0]->order_date}}</h4>
	<h4>Customer Name: {{ $orders[0]->customer->customer_name }}</h4>
	<h4>Customer Address: {{ $orders[0]->customer->customer_address }}</h4>
	<h4>Sales Representative: {{ $orders[0]->user->name }}</h4>
	<br>
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-8">
			<form action="{{route('sale.store')}}" method="POST">
				@csrf

				<input type="hidden" name="customer_id" value="{{ $orders[0]->customer_id }}">
				<input type="hidden" name="seller_id" value="{{ $orders[0]->seller_id }}">
				<input type="hidden" name="order_id" value="{{ $id }}">

				<div class="form-group{{ $errors->has('sale_date') ? ' has-error' : '' }}">
					<label for="sale_date">Sale Date <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="text" class="form-control" id="sale_date" name="sale_date" value="{{ old('sale_date') }}" placeholder="Sale Date">
					@if ($errors->has('sale_date'))
					<span class="help-block">
						<strong>{{ $errors->first('sale_date') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group">
					<label for="invoice_no">Invoice No</label>
					<input type="text" class="form-control" id="invoice_no" name="invoice_no" placeholder="Invoice No" value="{{ $invoice}}" readonly="readonly">
				</div>

				<table id="myTable">
					<thead>
						<tr>
							<th style="width:5%;">Sl</th>	
							<th style="width:40%;">Product</th>				
							<th style="width:15%;">Quantity</th>
							<th style="width:15%;">(Stock)</th>
							<th style="width:25%;">Trade Price</th>
						</tr>
					</thead>
					<tbody>
						@for($i = 0; $i <count($orders); $i++)
						<tr>
							<td>{{$i+1}}</td>
							<td>
								<div class="form-group">
									<input type="text" class="form-control" value="{{ $orders[$i]->product->product_name }}">
									<input type="hidden" name="product_id[]" id="product_id" value="{{$orders[$i]->product_id}}" >
								</div>
							</td>
							<td>
								<div class="form-group">
									<input type="number" min="0" class="form-control" id="quantity" name="quantity[]" value="{{ $orders[$i]->quantity }}" required="required">
								</div>
							</td>	

							<td>
								<div class="form-group">
									<input type="number" min="0" class="form-control" id="" name="" value="{{ $stocks[$i] }}" readonly="readonly">
								</div>
							</td>

							<td>
								<div class="form-group">
									<input type="number" min="0" class="form-control" id="trade_price" name="trade_price[]" placeholder="Trade Price" required="required" value="{{ $orders[$i]->customer->trade_price }}">
								</div>
							</td>
						</tr>
						@endfor
					</tbody>
				</table>

				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
		<div class="col-sm-3"></div>
	</div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>
	$( function() {
		$( "#sale_date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		});
	} );
</script>
@endsection
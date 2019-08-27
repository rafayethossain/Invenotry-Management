@extends('layouts.master')
@section('title', 'Add Purchase')

@section('content')
<div class="content-header">
	<a href="{{ url('purchase') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Purchase List
	</a>
	<a href="{{ url('purchase/add-via-barcode') }}" class="btn btn-info">
		<i class="fa fa-barcode" aria-hidden="true"></i>
		Add via Barcode
	</a>          
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">Add a New Purchase</h2>
	<hr>
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-8">
			<form action="/purchase" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}

				<div class="form-group{{ $errors->has('purchase_date') ? ' has-error' : '' }}">
					<label for="purchase_date">Purchase Date <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="text" class="form-control" id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}" placeholder="Purchase Date">
					@if ($errors->has('purchase_date'))
					<span class="help-block">
						<strong>{{ $errors->first('purchase_date') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('product_id') ? ' has-error' : '' }}">
					<label for="product_id">Product Name <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<select id="product_id" name="product_id" class="form-control product_id">
						<option value="">Select Product</option>
						@foreach ($products as $product)
						<option value="{{ $product->id }}" {{ old('product_id') == $product->id ? "selected":"" }}>{{ $product->product_name }}</option>
						@endforeach
					</select>
					@if ($errors->has('product_id'))
					<span class="help-block">
						<strong>{{ $errors->first('product_id') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
					<label for="quantity">Quantity <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="number" min="0" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}" placeholder="Quantity">
					@if ($errors->has('quantity'))
					<span class="help-block">
						<strong>{{ $errors->first('quantity') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group">
					<label for="invoice_no">Invoice No</label>
					<input type="text" class="form-control" id="invoice_no" name="invoice_no" placeholder="Invoice No" value="{{ old('invoice_no') }}">
				</div>

				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
		<div class="col-sm-3"></div>
	</div>
</div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>
	$( function() {
		$( "#purchase_date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		});
	} );
</script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">
	$('.product_id').select2({
    	placeholder: 'Select Product',

   		ajax: {
      		url: '{!!URL::route('productautocompletesearch')!!}',
      		dataType: 'json',
      		delay: 250,
     		processResults: function (data) {
        		return {
          			results: data
        		};
      		},
      		cache: true
    	},
    	theme: "bootstrap"
  	}); 
</script>
@endsection

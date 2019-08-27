@extends('layouts.master')
@section('title', 'Add Purchase')

@section('content')
<div class="content-header">
	<a href="{{ url('purchase') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Purchase List
	</a>
	<a href="{{ url('purchase/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add Purchase
	</a>         
</div>
<br>
@if(session('status'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
     	<strong>{{session('status')}}</strong>
      	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      	</button>
    </div>
@endif
<div class="container">
	<h2 style="text-align: center;">Add a New Purchase</h2>
	<hr>
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-8">
			<form action="{{url('purchase/via-barcode')}}" method="POST">
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

				<div class="form-group{{ $errors->has('product_code') ? ' has-error' : '' }}">
					<label for="product_code">Product Code <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="text" id="product_code" name="product_code" class="form-control product_code" placeholder="Product Code" autofocus="autofocus">
					@if ($errors->has('product_code'))
					<span class="help-block">
						<strong>{{ $errors->first('product_code') }}</strong>
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

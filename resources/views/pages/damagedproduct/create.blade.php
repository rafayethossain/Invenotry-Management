@extends('layouts.master')
@section('title', 'Add Damage')

@section('content')
<div class="content-header">
	<a href="{{ url('damagedproduct') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Damage List
	</a>         
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">Add a New Damage</h2>
	<hr>
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-8">
			<form action="/damagedproduct" method="POST">
				{{ csrf_field() }}

				<div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
					<label for="date">Date <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="text" class="form-control" id="date" name="date" value="{{ old('date') }}" placeholder="Date">
					@if ($errors->has('date'))
					<span class="help-block">
						<strong>{{ $errors->first('date') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('product_id') ? ' has-error' : '' }}">
					<label for="product_id">Product <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<select id="product_id" name="product_id" class="form-control product_id" required="required">
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

				<div class="form-group{{ $errors->has('damage_type') ? ' has-error' : '' }}">
					<label for="damage_type">Damage Type <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<select id="damage_type" name="damage_type" class="form-control damage_type" required="required">
						<option value="">Select Type</option>
						<option value="1">Replaced to Customer</option>
						<option value="2">Not Replaced</option>
						<option value="3">Damaged in Store</option>
					</select>
					@if ($errors->has('damage_type'))
					<span class="help-block">
						<strong>{{ $errors->first('damage_type') }}</strong>
					</span>
					@endif
				</div>

				<div id="customer_info"></div>

				<div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
					<label for="quantity">Quantity <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="number" min="0" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}" placeholder="Quantity" required="required">

					@if ($errors->has('quantity'))
					<span class="help-block">
						<strong>{{ $errors->first('quantity') }}</strong>
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

@section('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
	$( function() {
		$( "#date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		});
	} );
</script>

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

<script>
	$('#damage_type').on('change', function(){
		var damage_type = $('#damage_type').val();
		if (damage_type == 2) {
			$('#customer_info').html('');
			customer_info = '';
			customer_info += '<div class="form-group{{ $errors->has('invoice_no') ? 'has-error' : '' }}"><label for="invoice_no">Sale Invoice No <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label><input type="text" class="form-control" id="invoice_no" name="invoice_no" value="{{ old('invoice_no') }}" placeholder="Sale Invoice Number">@if ($errors->has('invoice_no'))<span class="help-block"><strong>{{ $errors->first('invoice_no') }}</strong></span>@endif</div>';
			$('#customer_info').html(customer_info);

			$('.customer_id').select2({
				placeholder: 'Select Customer',

				ajax: {
					url: '{!!URL::route('customerautocompletesearch')!!}',
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
		}
		else if(damage_type == 3) {
			$('#customer_info').html('');
			customer_info = '';
			customer_info += '<div class="form-group{{ $errors->has('purchase_invoice') ? 'has-error' : '' }}"><label for="purchase_invoice">Purchase Invoice No <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label><input type="text" class="form-control" id="purchase_invoice" name="purchase_invoice" value="{{ old('purchase_invoice') }}" placeholder="Purchase Invoice Number">@if ($errors->has('purchase_invoice'))<span class="help-block"><strong>{{ $errors->first('purchase_invoice') }}</strong></span>@endif</div>';
			$('#customer_info').html(customer_info);
		}
		else{
			$('#customer_info').html('');
		}
	});
</script>
@endsection

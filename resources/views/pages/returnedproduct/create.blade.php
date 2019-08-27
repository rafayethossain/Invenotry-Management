@extends('layouts.master')
@section('title', 'Add Return')

@section('content')
<div class="content-header">
	<a href="{{ url('returnedproduct') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Return List
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
	<h2 style="text-align: center;">Add a New Return</h2>
	<hr>
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-8">
			<form action="/returnedproduct" method="POST">
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

				<div class="form-group{{ $errors->has('invoice_no') ? ' has-error' : '' }}">
					<label for="invoice_no">Invoice <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="text" class="form-control" id="invoice_no" name="invoice_no" value="{{ old('invoice_no') }}" placeholder="Invoice Number" required="required">

					@if ($errors->has('invoice_no'))
					<span class="help-block">
						<strong>{{ $errors->first('invoice_no') }}</strong>
					</span>
					@endif
				</div>

				<div class="row">
					<div class="col-md-2">
						<button id="add_more" class="btn btn-info mt-4"><i class="fa fa-plus" title="Add More Product">Add More</i></button>
					</div>
					<div class="col-md-10">
						<div id="more_product">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="product_id">Product <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
										<select id="product_id" name="product_id[]" class="form-control product_id" required="required">
											<option value="">Select Product</option>
											@foreach ($products as $product)
											<option value="{{ $product->id }}">{{ $product->product_name }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="quantity">Quantity <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
										<input type="number" min="0" class="form-control" id="quantity" name="quantity[]" value="" placeholder="Quantity" required="required">
									</div>
								</div>
							</div>
						</div>
					</div>
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

<script>
	$(document).ready(function() {
		var max_fields      = 1000;
		var wrapper         = $("#more_product");
		var add_button      = $("#add_more");
		
		var x = 1;
		$(add_button).click(function(e){
			e.preventDefault();
			if(x < max_fields){
				x++;
				$(wrapper).append('<div class="row"><div class="form-group col-sm-6"><label for="product_id">Product <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label><select id="product_id" name="product_id[]" class="form-control product_id" required="required"><option value="">Select Product</option>@foreach ($products as $product)<option value="{{ $product->id }}" >{{ $product->product_name }}</option>@endforeach</select></div><div class="form-group col-sm-4"><label for="quantity">Quantity <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label><input type="number" min="0" class="form-control" id="quantity" name="quantity[]" value="" placeholder="Quantity" required="required"></div><div class="col-sm-2"><a href="#" class="remove_field"><button style="margin-top: 30px;" class="btn btn-info"><i class="fa fa-minus" title="Remove Item"></i></button></a></div></div>');

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
			}
		});
		
		$(wrapper).on("click",".remove_field", function(e){
			e.preventDefault(); 
			$(this).parent().parent('div').remove(); 
			x--;
		})
	});
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

<script type="text/javascript">
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
</script>
@endsection

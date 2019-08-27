@extends('layouts.master')
@section('title', 'Add Expense')

@section('content')
<div class="content-header">
	<a href="{{ url('expense') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Expenses List
	</a>
	<a href="{{ url('expenseitem') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Expense Item List
	</a>         
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">Add a New Expense</h2>
	<hr>
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-8">
			<form action="/expense" method="POST">
				{{ csrf_field() }}
				<div class="form-group{{ $errors->has('expense_date') ? ' has-error' : '' }}">
					<label for="expense_date">Expense Date <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="text" class="form-control" id="expense_date" name="expense_date" value="{{ old('expense_date') }}" placeholder="Expense Date">
					@if ($errors->has('expense_date'))
					<span class="help-block">
						<strong>{{ $errors->first('expense_date') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('expense_item_id') ? ' has-error' : '' }}">
					<label for="expense_item_id">Purpose <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<select id="expense_item_id" name="expense_item_id" class="form-control">
						<option value="">Select Purpose</option>
						@foreach ($expenseitems as $expenseitem)
						<option value="{{ $expenseitem->id }}" {{ old('expense_item_id') == $expenseitem->id ? "selected":"" }}>{{ $expenseitem->name }}</option>
						@endforeach
					</select>
					@if ($errors->has('expense_item_id'))
					<span class="help-block">
						<strong>{{ $errors->first('expense_item_id') }}</strong>
					</span>
					@endif
				</div>

				<div id="extra_info"></div>
				<div id="amountsection">
					<div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
						<label for="amount">Amount <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
						<input type="number" min="0" step="any" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" placeholder="Amount">
						@if ($errors->has('amount'))
						<span class="help-block">
							<strong>{{ $errors->first('amount') }}</strong>
						</span>
						@endif
					</div>
				</div>

				<div class="form-group">
					<label for="details">Expense Details</label>
					<textarea class="form-control" id="details" name="details" placeholder="Expense Details" rows="5" cols="50">{{ old('details') }}</textarea>
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
		$( "#expense_date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		});
	} );
</script>

<script>
	$('#expense_item_id').on('change', function(){
		var expense_item_id = $('#expense_item_id').val();
		if (expense_item_id == 1) {
			$('#extra_info').html('');
			extra_info = '';
			extra_info += '<div class="form-group{{ $errors->has('customer_id') ? 'has-error' : '' }}"><label for="customer_id">Customer Name <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label><select id="customer_id" name="customer_id" class="form-control customer_id" required="required"><option value="">Select Customer</option>@foreach ($customers as $customer)<option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>@endforeach</select>@if ($errors->has('customer_id'))<span class="help-block"><strong>{{ $errors->first('customer_id') }}</strong></span>@endif</div>';
			$('#extra_info').html(extra_info);
			$('#amountsection').css('display','block');
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
		else if (expense_item_id == 2){
			$('#extra_info').html('');
			extra_info = '';
			extra_info += '<div class="form-group{{ $errors->has('customer_id') ? 'has-error' : '' }}"><label for="customer_id">Customer Name <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label><select id="customer_id" name="customer_id" class="form-control customer_id"><option value="" required="required">Select Customer</option>@foreach ($customers as $customer)<option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>@endforeach</select>@if ($errors->has('customer_id'))<span class="help-block"><strong>{{ $errors->first('customer_id') }}</strong></span>@endif</div><div class="row"><div class="col-md-2"><button id="add_more" class="btn btn-info mt-4"><i class="fa fa-plus" title="Add More Product">Add More</i></button></div><div class="col-md-10"><div id="more_product"><div class="row"><div class="col-md-6"><div class="form-group"><label for="product_id">Product <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label><select id="product_id" name="product_id[]" class="form-control product_id" required="required"><option value="">Select Product</option>@foreach ($products as $product)<option value="{{ $product->id }}">{{ $product->product_name }}</option>@endforeach</select></div></div><div class="col-md-4"><div class="form-group"><label for="quantity">Quantity <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label><input type="number" min="0" class="form-control" id="quantity" name="quantity[]" value="" placeholder="Quantity" required="required"></div></div></div></div></div></div>';
			$('#extra_info').html(extra_info);
			$('#amountsection').css('display','none');
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
		}

		else if (expense_item_id == 3 || expense_item_id == 4) {
			$('#extra_info').html('');
			extra_info = '';
			extra_info += '<div class="form-group{{ $errors->has('user_id') ? 'has-error' : '' }}"><label for="user_id">Employee Name <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label><select id="user_id" name="user_id" class="form-control user_id" required="required"><option value="">Select Employee</option>@foreach ($users as $user)<option value="{{ $user->id }}">{{ $user->name }}</option>@endforeach</select>@if ($errors->has('user_id'))<span class="help-block"><strong>{{ $errors->first('user_id') }}</strong></span>@endif</div>';
			$('#extra_info').html(extra_info);
			$('#amountsection').css('display','block');
	// $('.user_id').select2({
	// 	placeholder: 'Select Customer',

	// 	ajax: {
	// 		url: '{!!URL::route('customerautocompletesearch')!!}',
	// 		dataType: 'json',
	// 		delay: 250,
	// 		processResults: function (data) {
	// 			return {
	// 				results: data
	// 			};
	// 		},
	// 		cache: true
	// 	},
	// 	theme: "bootstrap"
	// });
}
else{
	$('#extra_info').html('');
	$('#amountsection').css('display','block');
}
});
</script>
@endsection

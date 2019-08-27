@extends('layouts.master')
@section('title', 'Edit Income')

@section('content')
<div class="content-header">
	<a href="{{ url('income') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Incomes List
	</a>         
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">Edit Income</h2>
	<hr>
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-8">
			<form action="{{route('income.update', $income->id)}}" method="POST">
				{{ csrf_field() }}
				{{ method_field('PATCH') }}
				<div class="form-group{{ $errors->has('income_date') ? ' has-error' : '' }}">
					<label for="income_date">Income Date <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="text" class="form-control" id="income_date" name="income_date" value="{{ $income->income_date }}" placeholder="Income Date">
					@if ($errors->has('income_date'))
					<span class="help-block">
						<strong>{{ $errors->first('income_date') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('customer_id') ? ' has-error' : '' }}">
					<label for="customer_id">Customer Name <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<select id="customer_id" name="customer_id" class="form-control">
						<option value="">Select Customer</option>
						@foreach ($customers as $customer)
						<option value="{{ $customer->id }}" {{ $income->customer_id == $customer->id ? "selected":"" }}>{{ $customer->customer_name }}</option>
						@endforeach
					</select>
					@if ($errors->has('customer_id'))
					<span class="help-block">
						<strong>{{ $errors->first('customer_id') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('purpose') ? ' has-error' : '' }}">
					<label for="purpose">Purpose <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="text" class="form-control" id="purpose" name="purpose" value="{{ $income->purpose }}" placeholder="Purpose">
					@if ($errors->has('purpose'))
					<span class="help-block">
						<strong>{{ $errors->first('purpose') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('payment_type') ? ' has-error' : '' }}">
					<label for="payment_type">Payment Type <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<select id="payment_type" name="payment_type" class="form-control payment_type">
						<option value="">Select Type</option>
						<option value="1" {{ $income->payment_type == 1 ? "selected":"" }}>Cash</option>
						<option value="2" {{ $income->payment_type == 2 ? "selected":"" }}>Cheque</option>
						
					</select>
					@if ($errors->has('payment_type'))
					<span class="help-block">
						<strong>{{ $errors->first('payment_type') }}</strong>
					</span>
					@endif
				</div>

				<div id="cheque_info">
					@if($income->cheque_number)
					<div class="form-group{{ $errors->has('cheque_number') ? 'has-error' : '' }}"><label for="cheque_number">Cheque Number <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label><input type="text" class="form-control" id="cheque_number" name="cheque_number" value="{{ $income->cheque_number }}" placeholder="Cheque Number">@if ($errors->has('cheque_number'))<span class="help-block"><strong>{{ $errors->first('cheque_number') }}</strong></span>@endif</div>
					@endif
				</div>

				<div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
					<label for="amount">Amount <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="number" min="0" class="form-control" id="amount" name="amount" value="{{ $income->amount }}" placeholder="Amount">
					@if ($errors->has('amount'))
					<span class="help-block">
						<strong>{{ $errors->first('amount') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group">
					<label for="details">Income Details</label>
					<textarea class="form-control" id="details" name="details" placeholder="Income Details" rows="5" cols="50">{{ $income->details }}</textarea>
				</div>
				<button type="submit" class="btn btn-success">Update</button>
				<button type="button" class="btn btn-danger" onClick="window.location.href='/income'">Cancel</button>
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
		$( "#income_date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		});
	} );
</script>

<script>
	$('#payment_type').on('change', function(){
		var payment_type = $('#payment_type').val();
		if (payment_type == 2) {
			$('#cheque_info').html('');
			cheque_info = '';
			cheque_info += '<div class="form-group{{ $errors->has('cheque_number') ? 'has-error' : '' }}"><label for="cheque_number">Cheque Number <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label><input type="text" class="form-control" id="cheque_number" name="cheque_number" value="{{ old('cheque_number') }}" placeholder="Cheque Number">@if ($errors->has('cheque_number'))<span class="help-block"><strong>{{ $errors->first('cheque_number') }}</strong></span>@endif</div>';
			$('#cheque_info').html(cheque_info);
		}

		else{
			$('#cheque_info').html('');
		}
	});
</script>
@endsection

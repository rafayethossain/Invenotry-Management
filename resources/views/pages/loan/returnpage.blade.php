@extends('layouts.master')
@section('title', 'Sanction Loan')

@section('content')
<div class="content-header">
	<a href="{{ url('loan') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Loan List
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
	<h2 style="text-align: center;">Loan Payment</h2>
	<hr>
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-8">
			<form action="{{ url('loan/confirm-loan-payment') }}" method="POST">
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

				<div class="form-group{{ $errors->has('loan_number') ? ' has-error' : '' }}">
					<label for="loan_number">Loan Number <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="number" min="0" class="form-control" id="loan_number" name="loan_number" value="{{ old('loan_number') }}" placeholder="Loan Number">
					@if ($errors->has('loan_number'))
					<span class="help-block">
						<strong>{{ $errors->first('loan_number') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
					<label for="amount">Amount <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="number" min="0" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" placeholder="Amount">
					@if ($errors->has('amount'))
					<span class="help-block">
						<strong>{{ $errors->first('amount') }}</strong>
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
<script>
	$( function() {
		$( "#date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		});
	} );
</script>
@endsection

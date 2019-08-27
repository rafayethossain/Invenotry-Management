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
<div class="container">
	<h2 style="text-align: center;">Sanction a New Loan</h2>
	<hr>
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-8">
			<form action="{{route('loan.update', $loan->id)}}" method="POST">
				{{ csrf_field() }}
				{{ method_field('PATCH') }}
				<div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
					<label for="date">Date <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="text" class="form-control" id="date" name="date" value="{{ $loan->date }}" placeholder="Date">
					@if ($errors->has('date'))
					<span class="help-block">
						<strong>{{ $errors->first('date') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
					<label for="user_id">Employee Name <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<select id="user_id" name="user_id" class="form-control user_id">
						<option value="">Select Employee</option>
						@foreach ($users as $user)
						<option value="{{ $user->id }}" {{ $loan->user_id == $user->id ? "selected":"" }}>{{ $user->name }}</option>
						@endforeach
					</select>
					@if ($errors->has('user_id'))
					<span class="help-block">
						<strong>{{ $errors->first('user_id') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
					<label for="amount">Amount <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="number" min="0" class="form-control" id="amount" name="amount" value="{{ $loan->amount }}" placeholder="Amount">
					@if ($errors->has('amount'))
					<span class="help-block">
						<strong>{{ $errors->first('amount') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group">
					<label for="details">Details</label>
					<textarea class="form-control" id="details" name="details" placeholder="Details" rows="5" cols="50">{{ $loan->details }}</textarea>
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
				<button type="button" class="btn btn-danger" onClick="window.location.href='/loan'">Cancel</button>
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

@extends('layouts.master')
@section('title', 'Edit Expense')

@section('content')
<div class="content-header">
	<a href="{{ url('expense') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Expenses List
	</a>         
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">Edit Expense</h2>
	<hr>
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-8">
			<form action="{{route('expense.update', $expense->id)}}" method="POST">
				{{ csrf_field() }}
				{{ method_field('PATCH') }}
				<div class="form-group{{ $errors->has('expense_date') ? ' has-error' : '' }}">
					<label for="expense_date">Expense Date <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="text" class="form-control" id="expense_date" name="expense_date" value="{{ $expense->expense_date }}" placeholder="Expense Date">
					@if ($errors->has('expense_date'))
					<span class="help-block">
						<strong>{{ $errors->first('expense_date') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('expense_item_id') ? ' has-error' : '' }}">
					<label for="expense_item_id">Purpose <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<select id="expense_item_id" name="expense_item_id" class="form-control" disabled="disabled">
						<option value="">Select Purpose</option>
						@foreach ($expenseitems as $expenseitem)
						<option value="{{ $expenseitem->id }}" @if($expenseitem->id==$expense->expense_item_id) selected='selected' @endif>{{ $expenseitem->name }}</option>
						@endforeach
					</select>
					@if ($errors->has('expense_item_id'))
					<span class="help-block">
						<strong>{{ $errors->first('expense_item_id') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
					<label for="amount">Amount <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="number" min="0" step="any" class="form-control" id="amount" name="amount" value="{{ $expense->amount }}" placeholder="Amount">
					@if ($errors->has('amount'))
					<span class="help-block">
						<strong>{{ $errors->first('amount') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group">
					<label for="details">Expense Details</label>
					<textarea class="form-control" id="details" name="details" placeholder="Expense Details" rows="5" cols="50">{{ $expense->details }}</textarea>
				</div>
				<button type="submit" class="btn btn-success">Update</button>
				<button type="button" class="btn btn-danger" onClick="window.location.href='/expense'">Cancel</button>
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
		$( "#expense_date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		});
	} );
</script>
@endsection

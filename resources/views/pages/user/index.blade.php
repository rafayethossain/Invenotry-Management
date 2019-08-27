@extends('layouts.master')
@section('title', 'Users')

@section('content')
<div class="content-header">
	<a href="{{ url('user/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add User
	</a>
	<form id="particularexpense" method="GET" action="{{ url('user/payment-report') }}" class="form-inline">
		{{ csrf_field() }}
		<label for="inlineFormCustomSelect">From Date</label>
		<input type="text" name="start_date" id="from_date" class="form-control" required="required" placeholder="From Date">
		<label for="inlineFormCustomSelect">To Date</label>
		<input type="text" name="end_date" id="to_date" class="form-control" required="required" placeholder="To Date">
		<button type="submit" class="btn btn-info"><i class="fa fa-line-chart" aria-hidden="true"></i>
		Payment Report</button>
	</form>
	<br><br>
	<h4 style="text-align: center;">Representatives Sales Report </h4>
	<form id="particularexpense" method="GET" action="{{url('user/date-to-date-seller-report')}}" class="form-inline">
		{{ csrf_field() }}
		<label for="inlineFormCustomSelect">Start Date</label>
		<input type="text" name="start_date" id="start_date" class="form-control" required="required" placeholder="Start Date">
		<label for="inlineFormCustomSelect">End Date</label>
		<input type="text" name="end_date" id="end_date" class="form-control" required="required" placeholder="End Date">
		<label for="inlineFormCustomSelect">Sale Representative</label>
		<select name="seller_id" class="form-control" required="required">
			<option value="">Select Representative</option>
			@foreach ($salesmen as $seller)
			<option value="{{ $seller->id }}">{{ $seller->name }}</option>
			@endforeach
		</select>
		<button type="submit" class="btn btn-info"><i class="fa fa-line-chart" aria-hidden="true"></i> Report</button>
	</form>
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
	<h2 style="text-align: center;">User List</h2>
	<hr>
	<div class="col-md-12">
		<table id="myTable">
			<thead>
				<tr>
					<th class="no-sort" style="width:10%;">Sl</th>
					<th class="no-sort" style="width:20%;">Name</th>
					<th class="no-sort" style="width:15%;">Mobile</th>
					<th style="width:15%;">Role</th>
					<th class="no-sort" style="width:30%;">Address</th>
					<th style="width:10%;" class="no-sort">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $user)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{ $user->name }}</td>
					<td>{{ $user->mobile }}</td>
					<td>{{ $user->roles->first()->display_name }}</td>
					<td>{{ $user->address }}</td>
					<td>
						<a href="{{route('user.show', $user->id)}}"><i class="fa fa-eye" aria-hidden="true" title="Show"></i></a>

						<a href="{{route('user.edit', $user->id)}}" style="margin-left: 5px;"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit"></i></a>

						<form class="del delbtn" action="{{ route('user.destroy', $user->id) }}" method="POST" style="display: inline-block;">
							<input type="hidden" name="_method" value="DELETE">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<button type="submit" title="Delete" style="background: none;
							border: none;"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
						</form>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection

@section('script')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script>
	$(document).ready(function(){
		$('#myTable').DataTable({
			"columnDefs": [{
				"targets": 'no-sort',
				"orderable": false,
			}]
		});
	});
</script>
<script>
	$(".delbtn").on("submit", function(){
		return confirm("Do you want to delete this item?");
	});
</script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script>
	$( function() {
		$( "#start_date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		});
	} );

	$( function() {
		$( "#from_date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		});
	} );
</script>

<script>
	$( function() {
		$( "#end_date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		});
	} );

	$( function() {
		$( "#to_date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		});
	} );
</script>
@endsection
@extends('layouts.master')
@section('title', 'Loan')

@section('content')
<div class="content-header">
	<a href="{{ url('loan/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Sanction Loan
	</a>

	<a href="{{ url('loan/return') }}" class="btn btn-info">
		<i class="fa fa-undo" aria-hidden="true"></i>
		Loan Return
	</a>    
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
	<h2 style="text-align: center;">Loan List</h2>
	<hr>
	<div class="col-md-12">
		<table id="myTable">
			<thead>
				<tr>
					<th class="no-sort" style="width:10%;">Sl</th>
					<th style="width:15%;">Loan Number</th>
					<th style="width:15%;">Date</th>					
					<th style="width:20%;">Employee Name</th>
					<th style="width:15%;">Amount</th>
					<th style="width:15%;">Remaining Amount</th>
					<th style="width:10%;" class="no-sort">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($loans as $loan)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{ $loan->id }}</td>
					<td>{{ $loan->date }}</td>
					<td>{{ $loan->user->name }}</td>
					<td>{{ $loan->amount }}</td>
					<td>{{ $loan->remaining_amount }}</td>
					<td>
						<a href="{{route('loan.show', $loan->id)}}"><i class="fa fa-eye" aria-hidden="true" title="Show"></i></a>

						<a href="{{route('loan.edit', $loan->id)}}" style="margin-left: 5px;"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit"></i></a>
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
	$(".delete-item").on("submit", function(){
		return confirm("Do you want to delete this item?");
	});
</script>
@endsection
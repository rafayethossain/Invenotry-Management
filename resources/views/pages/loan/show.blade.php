@extends('layouts.master')
@section('title', 'Show Loan')

@section('content')
<div class="content-header">
	<a href="{{ url('loan') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Loan List
	</a> 

	<a href="{{ url('loan/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Sanction Loan
	</a>          
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">About Loan</h2>
	<hr>
	<div class="col-md-12">
		<h5>Loan Number: {{ $loan->id }}</h5>
		<h5>Sanction Date: {{ $loan->date }}</h5>
		<h5>Employee Name: {{ $loan->user->name }}</h5>
		<h5>Amount: {{ $loan->amount }}</h5>
		<h5>Remaining Amount: {{ $loan->remaining_amount }}</h5>
		<h5>Details: {{ $loan->details }}</h5>
	</div>
	<h2 style="text-align: center;">Installments Table</h2>
	<div class="col-md-12">
		<table id="myTable">
			<thead>
				<tr>
					<th class="no-sort" style="width:20%;">Sl</th>
					<th style="width:40%;">Installment Date</th>					
					<th style="width:40%;">Amount</th>
				</tr>
			</thead>
			<tbody>
				@foreach($payments as $payment)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{ $payment->date }}</td>
					<td>{{ $payment->amount }}</td>
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
@endsection
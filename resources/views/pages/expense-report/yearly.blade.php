@extends('layouts.master')
@section('title', 'Yearly Expenses Report')

@section('content')
<div class="content-header">
	<a href="{{ url('dailyreport') }}" class="btn btn-info">
		<i class="fa fa-line-chart" aria-hidden="true"></i>
		Daily Report
	</a>

	<a href="{{ url('weeklyreport') }}" class="btn btn-info">
		<i class="fa fa-line-chart" aria-hidden="true"></i>
		Weekly Report
	</a>  

	<a href="{{ url('monthlyreport') }}" class="btn btn-info">
		<i class="fa fa-line-chart" aria-hidden="true"></i>
		Monthly Report
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
	<h2 style="text-align: center;">Yearly Expenses</h2>
	<hr>
	<div class="col-md-12">
		<table id="myTable">
			<thead>
				<tr>
					<th class="no-sort" style="width:10%;">Sl</th>
					<th style="width:20%;">Date</th>					
					<th class="no-sort" style="width:40%;">Purpose</th>
					<th style="width:20%;">Amount</th>
					<th style="width:10%;" class="no-sort">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($expenses as $expense)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{ $expense->expense_date }}</td>
					<td>{{ $expense->expenseitem->name }}</td>
					<td>{{ $expense->amount }}</td>
					<td>
						<a href="{{route('expense.show', $expense->id)}}"><i class="fa fa-eye" aria-hidden="true" title="Show"></i></a>

						<a href="{{route('expense.edit', $expense->id)}}" style="margin-left: 3px;"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit"></i></a>
						
						<form class="delete-item" action="{{ route('expense.destroy', $expense->id) }}" method="POST" style="float: left;">
							<input type="hidden" name="_method" value="DELETE">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<button type="submit" class="delete-button"><i class="fa fa-trash-o" aria-hidden="true" title="Delete"></i></button>
						</form>	
					</td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th colspan="3" style="text-align:right">Total:</th>
					<th></th>
					<th></th>
				</tr>
			</tfoot>
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
			}],

			"footerCallback": function ( row, data, start, end, display ) {
			    var api = this.api(), data;
			
			    // Remove the formatting to get integer data for summation
			    var intVal = function ( i ) {
			        return typeof i === 'string' ?
			            i.replace(/[\$,]/g, '')*1 :
			            typeof i === 'number' ?
			                i : 0;
			    };
			
			    // Total over all pages
			    total = api
			        .column( 3 )
			        .data()
			        .reduce( function (a, b) {
			            return intVal(a) + intVal(b);
			        });
			
			    // Total over this page
			    pageTotal = api
			        .column( 3, { page: 'current'} )
			        .data()
			        .reduce( function (a, b) {
			            return intVal(a) + intVal(b);
			        });
			
			    // Update footer
			    $( api.column( 3 ).footer() ).html(
			        ''+pageTotal +' ( '+ total +' total)'
			    );
			}
		});
	});
</script>
<script>
	$(".delete-item").on("submit", function(){
		return confirm("Do you want to delete this item?");
	});
</script>
@endsection
@extends('layouts.master')
@section('title', 'Incomes')

@section('content')
<div class="content-header">
	<a href="{{ url('income/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add Income
	</a>

	<form id="particularexpense" method="GET" action="{{url('income/report')}}" class="form-inline">
		{{ csrf_field() }}
		<label for="inlineFormCustomSelect">Start Date</label>
		<input type="text" name="start_date" id="start_date" class="form-control" placeholder="Start Date">
		<label for="inlineFormCustomSelect">End Date</label>
		<input type="text" name="end_date" id="end_date" class="form-control" placeholder="End Date">
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
	<h2 style="text-align: center;">Incomes List</h2>
	<hr>
	<div class="col-md-12">
		<table id="myTable">
			<thead>
				<tr>
					<th class="no-sort" style="width:10%;">Sl</th>
					<th style="width:10%;">Date</th>					
					<th style="width:20%;">Customer Name</th>
					<th class="no-sort" style="width:25%;">Purpose</th>
					<th class="no-sort" style="width:15%;">Payment Type</th>
					<th style="width:10%;">Amount</th>
					<th style="width:10%;" class="no-sort">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($incomes as $income)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{ $income->income_date }}</td>
					<td>{{ $income->customer->customer_name }}</td>
					<td>{{ $income->purpose }}</td>
					<td >{{$income->payment_type =='1' ? 'Cash' : "Cheque (".$income->cheque_number.")"}}</td>
					<td>{{ $income->amount }}</td>
					<td>
						<a href="{{route('income.show', $income->id)}}"><i class="fa fa-eye" aria-hidden="true" title="Show"></i></a>

						<a href="{{route('income.edit', $income->id)}}" style="margin-left: 5px;"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit"></i></a>
						@if($income->payment_type == 2)
						<form class="del delete-item" action="{{ route('income.destroy', $income->id) }}" method="POST" style="display: inline-block;">
							<input type="hidden" name="_method" value="DELETE">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<button type="submit" title="Delete" style="background: none;
							border: none;"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
						</form>
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th colspan="5" style="text-align:right">Total:</th>
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
			    .column( 5 )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    });
			    
			    // Total over this page
			    pageTotal = api
			    .column( 5, { page: 'current'} )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    });
			    
			    // Update footer
			    $( api.column( 5 ).footer() ).html(
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
</script>

<script>
	$( function() {
		$( "#end_date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		});
	} );
</script>
@endsection
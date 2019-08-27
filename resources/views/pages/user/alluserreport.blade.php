@extends('layouts.master')
@section('title', 'User Report')

@section('content')
<div class="content-header">
	<a href="{{ url('user') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Users
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

	<form id="particularexpense" method="GET" action="{{ url('printpaymentreport') }}" class="form-inline">
		{{ csrf_field() }}
		<input type="hidden" name="start_date" id="start_date" class="form-control" required="required" value="{{$start_date}}">
		<input type="hidden" name="end_date" id="end_date" class="form-control" required="required" value="{{$end_date}}">
		<button type="submit" class="btn btn-info"><i class="fa fa-print" aria-hidden="true" title="Print"></i> Print</button>
	</form>    
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">Users Payment Report From <span>{{$start_date}}</span> To <span>{{$end_date}}</span></h2>
	<hr>
	<div class="col-md-12">
		<table id="myTable">
			<thead>
				<tr>
					<th class="no-sort" style="width:10%;">Sl</th>
					<th style="width:20%;">User Name</th>		
					<th style="width:20%;">Working Since</th>					
					<th style="width:20%;">Role</th>
					<th style="width:30%;">Paid Amount (with TA)</th>
				</tr>
			</thead>
			<tbody>
				@for($i=0;$i<count($users);$i++)
				<tr>
					<td>{{$i + 1}}</td>
					<td>{{ $users[$i]->name }}</td>
					<td>{{ $users[$i]->created_at->format('Y-m-d') }}</td>
					<td>{{ $users[$i]->roles->first()->display_name }}</td>
					<td>{{ $expense_total[$i] }}</td>
				</tr>
				@endfor
			</tbody>
			<tfoot>
				<tr>
					<th colspan="3" style="text-align:right"></th>
					<th></th>
					<th></th>
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
			    expensetotal = api
			        .column( 4 )
			        .data()
			        .reduce( function (a, b) {
			            return intVal(a) + intVal(b);
			        });
			
			    // Total over this page
			    expensepageTotal = api
			        .column( 4, { page: 'current'} )
			        .data()
			        .reduce( function (a, b) {
			            return intVal(a) + intVal(b);
			        });
			
			    // Update footer
			    $( api.column( 4 ).footer() ).html(
			        ''+expensepageTotal +' ( '+ expensetotal +' total)'
			    );
			}
		});
	});
</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script>
	$( function() {
		$( "#to_date" ).datepicker({
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
@endsection
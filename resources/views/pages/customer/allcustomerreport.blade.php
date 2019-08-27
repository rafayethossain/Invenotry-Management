@extends('layouts.master')
@section('title', 'Customer Report')

@section('content')
<div class="content-header">
	<div class="row">
		<div class="col-sm-9">
			<a href="{{ url('customer') }}" class="btn btn-info">
				<i class="fa fa-list" aria-hidden="true"></i>
				Customers
			</a>
			<form id="particularexpense" method="GET" action="{{ url('customer/all-customer-report') }}" class="form-inline">
				{{ csrf_field() }}
				<label for="inlineFormCustomSelect">Start Date</label>
				<input type="text" name="start_date" id="start_date" class="form-control" required="required" value="{{$start_date}}">
				<label for="inlineFormCustomSelect">End Date</label>
				<input type="text" name="end_date" id="end_date" class="form-control" required="required" value="{{$end_date}}">
				<button type="submit" class="btn btn-info">Report</button>
			</form>
		</div>
		<div class="col-sm-3">
			<form id="particularexpense" method="GET" action="{{ url('printallcustomerreport') }}" class="form-inline" style="margin: 0; display: inline-block;">
				{{ csrf_field() }}
				<input type="hidden" name="start_date" id="start_date" class="form-control" required="required" value="{{$start_date}}">
				<input type="hidden" name="end_date" id="end_date" class="form-control" required="required" value="{{$end_date}}">
				<button type="submit" class="btn btn-info"><i class="fa fa-print" aria-hidden="true" title="Print"></i> Print</button>
			</form>

			<form id="particularexpense" method="GET" action="{{ url('pdf-allcustomer-report') }}" style="margin: 0; display: inline-block;">
				{{ csrf_field() }}
				<input type="hidden" name="start_date" id="start_date" class="form-control" required="required" value="{{$start_date}}">
				<input type="hidden" name="end_date" id="end_date" class="form-control" required="required" value="{{$end_date}}">
				<button type="submit" class="btn btn-info"><i class="fa fa-file-pdf-o" aria-hidden="true" title="PDF"></i> PDF</button>
			</form>
			<form id="particularexpense" method="GET" action="{{ url('excel-allcustomer-report') }}" style="margin: 0; display: inline-block;">
				{{ csrf_field() }}
				<input type="hidden" name="start_date" id="start_date" class="form-control" required="required" value="{{$start_date}}">
				<input type="hidden" name="end_date" id="end_date" class="form-control" required="required" value="{{$end_date}}">
				<button type="submit" class="btn btn-info"><i class="fa fa-file-excel-o" aria-hidden="true" title="Excel"></i> Excel</button>
			</form>  
		</div>  
	</div> 
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
	<h2 style="text-align: center;">All Customer Transaction Report <span>{{$start_date}}</span> To <span>{{$end_date}}</span></h2>
	<hr>
	<div class="col-md-12">
		<table id="myTable">
			<thead>
				<tr>
					<th class="no-sort" style="width:5%;">Sl</th>
					<th style="width:20%;">Customer Name</th>		
					<th style="width:15%;">Sale Amount</th>					
					<th style="width:20%;">Received Amount</th>
					<th style="width:20%;">Remaining Amount</th>
					<th style="width:20%;">Expense(if any)</th>
				</tr>
			</thead>
			<tbody>
				@for($i=0;$i<count($customers);$i++)
				<tr>
					<td>{{$i + 1}}</td>
					<td>{{ $customers[$i]->customer_name }}</td>
					<td>{{ $sale_total[$i] }}</td>
					<td>{{ $income_total[$i] }}</td>
					<td>{{ $sale_total[$i] - $income_total[$i] }}</td>
					<td>{{ $expense_total[$i] }}</td>
				</tr>
				@endfor
			</tbody>
			<tfoot>
				<tr>
					<th colspan="2" style="text-align:right"></th>
					<th></th>
					<th></th>
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
			    incometotal = api
			    .column( 3 )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    });
			    incometotal = incometotal.toFixed(2);

			    // Total over this page
			    incomepageTotal = api
			    .column( 3, { page: 'current'} )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    });
			    incomepageTotal = incomepageTotal.toFixed(2);

			    // Update footer
			    $( api.column( 3 ).footer() ).html(
			    	''+incomepageTotal +' ( '+ incometotal +' total)'
			    	);

			    // Total over all pages
			    saletotal = api
			    .column( 2 )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    });
			    saletotal = saletotal.toFixed(2);

			    // Total over this page
			    salepageTotal = api
			    .column( 2, { page: 'current'} )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    });
			    salepageTotal = salepageTotal.toFixed(2);

			    // Update footer
			    $( api.column( 2 ).footer() ).html(
			    	''+salepageTotal +' ( '+ saletotal +' total)'
			    	);

			    // Total over all pages
			    remaintotal = api
			    .column( 4 )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    });
			    remaintotal = remaintotal.toFixed(2);

			    // Total over this page
			    remainpageTotal = api
			    .column( 4, { page: 'current'} )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    });
			    remainpageTotal = remainpageTotal.toFixed(2);

			    // Update footer
			    $( api.column( 4 ).footer() ).html(
			    	''+remainpageTotal +' ( '+ remaintotal +' total)'
			    	);


			    // Total over all pages
			    expensetotal = api
			    .column( 5 )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    });
			    expensetotal = expensetotal.toFixed(2);

			    // Total over this page
			    expensepageTotal = api
			    .column( 5, { page: 'current'} )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    });
			    expensepageTotal = expensepageTotal.toFixed(2);

			    // Update footer
			    $( api.column( 5 ).footer() ).html(
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
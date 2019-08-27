@extends('layouts.master')
@section('title', 'Expenses')

@section('content')
<div class="content-header">
	<a href="{{ url('expense/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add Expense
	</a>
	<form id="particularexpensedate" method="GET" action="{{url('expense/report')}}" class="form-inline">
		{{ csrf_field() }}
		<label for="inlineFormCustomSelect">Start Date </label>
		<input type="text" name="start_date" id="start_date" class="form-control" placeholder="Start Date">
		<label for="inlineFormCustomSelect">End Date </label>
		<input type="text" name="end_date" id="end_date" class="form-control" placeholder="End Date">
		<button type="submit" class="btn btn-info"><i class="fa fa-line-chart" aria-hidden="true"></i> Report</button>
	</form>
	<br><br>
	<form id="particularexpense" method="GET" action="{{url('expense/particular-expense')}}" class="form-inline">
		{{ csrf_field() }}
		<label for="inlineFormCustomSelect">Particular Expense Report </label>
		<select id="expense_item_id" name="expense_item_id" class="form-control">
			<option value="">Select Item</option>
			@foreach ($expenseitems as $expenseitem)
			<option value="{{ $expenseitem->id }}" {{ old('expense_item_id') == $expenseitem->id ? "selected":"" }}>{{ $expenseitem->name }}</option>
			@endforeach
		</select>
		<button type="submit" class="btn btn-info">Submit</button>
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
<div id="approval"></div>
<div class="container">
	<h2 style="text-align: center;">Expenses List</h2>
	<hr>
	<div class="col-md-12">
		<table id="myTable">
			<thead>
				<tr>
					<th class="no-sort" style="width:10%;">Sl</th>
					<th style="width:20%;">Date</th>					
					<th class="no-sort" style="width:30%;">Purpose</th>
					<th style="width:15%;">Amount</th>
					<th style="width:15%;">Status</th>
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
					<td id="confirmed{{$expense->id}}">{!!$expense->superAdmin_approval =='1' ? "<span class='badge badge-primary'>Approved</span>" : "<span class='badge badge-warning'>Pending</span>"!!}</td>
					<td>
						<a href="{{route('expense.show', $expense->id)}}"><i class="fa fa-eye" aria-hidden="true" title="Show"></i></a>

						<a href="{{route('expense.edit', $expense->id)}}" style="margin-left: 5px;"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit"></i></a>
						@role('super_admin')
						@if($expense->superAdmin_approval == 0)
						
						<form class="EditForm" method="POST" action="{{url('expenseapproval', $expense->id)}}" style="float: left;" id="approvalform{{$expense->id}}">											
							<button type="submit" class="delete-button"><i class="fa fa-exclamation" aria-hidden="true" title="Approve the Expense"></i></button>
						</form>
						
						@endif
						@endrole	
					</td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th colspan="3" style="text-align:right">Total:</th>
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

<script>
	$('.EditForm').on('submit', function(e){

		e.preventDefault(e);
		var method = $(this).attr('method');
		var url = $(this).attr('action');
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			url:url,  
			method:method,                               
			success: function( data ) {
				var html = '';
				html += '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong id="approval_message"></strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            	// Append the built HTML to a DOM element of your choice
            	$('#approval').empty().append(html);
            	document.getElementById("approval_message").innerHTML = 'You Have Approved the Expense';

            	var dataconfirmation = '';
            	dataconfirmation += data.superAdmin_approval =='1' ? "<span class='badge badge-primary'>Approved</span>" : "<span class='badge badge-warning'>Pending</span>";
            	$('#confirmed'+data.id).empty().append(dataconfirmation);
            	$('#approvalform'+data.id).empty();
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
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Print Sale</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>	
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<style type="text/css">
	.sign{
		padding-top: 60px;
	}
	.sign span{
		margin: 0 auto;
		width: 200px;
		padding-top: 10px;
		display: block;
		border-top: 1px solid #111;
		text-align: center;
	}
	
	@media print {
		@page { 
			size: auto;
			margin-bottom: 1.3cm; margin-top: 4.75cm;
		}

		table { page-break-after:auto }
		tr    { page-break-inside:avoid; page-break-after:auto }
		td    { page-break-inside:avoid; page-break-after:auto }
		thead { display:table-header-group }
		tfoot { display:table-footer-group }
	}
</style>
</head>
<body>
	<div class="container">
		<div class="container">
			<h2 style="text-align: center;">{{$expenseItem->name}} Expense Report</h2>
			<hr>
			<div class="col-md-12">
				<table id="myTable">
					<thead>
						<tr>
							<th class="no-sort" style="width:10%;">Sl</th>
							<th style="width:20%;">Date</th>					
							<th class="no-sort" style="width:40%;">Purpose</th>
							<th style="width:20%;">Amount</th>
						</tr>
					</thead>
					<tbody>
						@foreach($expenses as $expense)
						<tr>
							<td>{{$loop->iteration}}</td>
							<td>{{ $expense->expense_date }}</td>
							<td>{{ $expense->expenseitem->name }}</td>
							<td>{{ $expense->amount }}</td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th colspan="3" style="text-align:right">Total:</th>
							<th></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
		<div class="row sign">
			<table class="col-md-12">
				<tr>
					<td><span>Authorized By</span></td>
					<td><span>Received By</span></td>
				</tr>
			</table>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			$('#myTable').DataTable({
				"columnDefs": [{
					"targets": 'no-sort',
					"orderable": false,
				}],

				searching: false, 
				paging: false,
				info: false,

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
</body>
</html>
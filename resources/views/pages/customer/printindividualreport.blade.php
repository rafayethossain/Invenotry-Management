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
			<h2 style="text-align: center;">{{$customer->customer_name}}'s Transaction Report</h2>
			<hr>
			<div class="col-md-12">
				<table id="myTable">
					<thead>
						<tr>
							<th class="no-sort" style="width:10%;">Sl</th>
							<th style="width:20%;">Date</th>					
							<th class="no-sort" style="width:30%;">Purpose</th>
							<th class="no-sort" style="width:20%;">Payment Type</th>
							<th style="width:20%;">Amount</th>
						</tr>
					</thead>
					<tbody>
						@foreach($incomes as $income)
						<tr>
							<td>{{$loop->iteration}}</td>
							<td>{{ $income->income_date }}</td>
							<td>{{ $income->purpose }}</td>
							<td >{{$income->payment_type =='1' ? 'Cash' : "Cheque (".$income->cheque_number.")"}}</td>
							<td>{{ -$income->amount }}</td>
						</tr>
						@endforeach
						@for($i=0;$i<count($sales);$i++)
						<tr>
							<td>{{$i + 1}}</td>
							<td>{{ $sales[$i]->sale_date }}</td>
							<td>Sale</td>
							<td></td>
							<td>
								{{$sum[$i]}}
							</td>
						</tr>
						@endfor
					</tbody>
					<tfoot>
						<tr>
							<th colspan="4" style="text-align:right">Remaining:</th>
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
			    .column( 4 )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    });
			    total = total.toFixed(2);
			    // Total over this page
			    pageTotal = api
			    .column( 4, { page: 'current'} )
			    .data()
			    .reduce( function (a, b) {
			    	return intVal(a) + intVal(b);
			    });
			    pageTotal = pageTotal.toFixed(2);
			    // Update footer
			    $( api.column( 4 ).footer() ).html(
			    	''+pageTotal +' ( '+ total +' total)'
			    	);
			}
		});
		});
	</script>
</body>
</html>
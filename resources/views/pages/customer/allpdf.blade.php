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
	
</head>
<body>
	<div class="container">
		<div class="container">
			<h2 style="text-align: center;">All Customer Transaction Report <span>{{$start_date}}</span> To <span>{{$end_date}}</span></h2>
			<hr>
			<div class="col-md-12">
				<table id="myTable">
					<thead>
						<tr>
							<th class="no-sort" style="width:10%;">Sl</th>
							<th style="width:20%;">Customer Name</th>		
							<th style="width:15%;">Sale Amount</th>					
							<th style="width:15%;">Received Amount</th>
							<th style="width:15%;">Remaining Amount</th>
							<th style="width:25%;">Expense(if any)</th>
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
							<th colspan="6"><hr></th>
						</tr>
						<tr>
							<th colspan="2" style="text-align:right"></th>
							<th>{{array_sum($sale_total)}}</th>
							<th>{{array_sum($income_total)}}</th>
							<th>{{array_sum($sale_total) - array_sum($income_total)}}</th>
							<th>{{array_sum($expense_total)}}</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</body>
</html>
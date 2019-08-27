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
			<h2 style="text-align: center;">Incomes From {{$start_date}} To {{$end_date}}</h2>
			<hr>
			<div class="col-md-12">
				<table id="myTable">
					<thead>
						<tr>
							<th class="no-sort" style="width:10%;">Sl</th>
							<th style="width:10%;">Date</th>					
							<th style="width:25%;">Customer Name</th>
							<th class="no-sort" style="width:25%;">Purpose</th>
							<th class="no-sort" style="width:15%;">Payment Type</th>
							<th style="width:15%;">Amount</th>
						</tr>
					</thead>
					<tbody>
						@foreach($incomes as $income)
						<tr>
							<td>{{$loop->iteration}}</td>
							<td>{{ $income->income_date }}</td>
							<td>{{ $income->customer->customer_name }}</td>
							<td>{{ $income->purpose }}</td>
							<td >{{$income->payment_type =='1' ? 'Cash' : 'Cheque'}}</td>
							<td>{{ $income->amount }}</td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th colspan="6" style="text-align:right">Total: {{array_sum($total_income)}}</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</body>
</html>
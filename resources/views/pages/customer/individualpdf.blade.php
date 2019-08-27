<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
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
	
	.page-break {
		page-break-after: always;
	}
	table {
		border-collapse: collapse;
		width: 100%;
		table-layout:fixed;
	}

	td, th {
		border: 1px solid #dddddd;
		text-align: left;
		padding: 8px;
		font-size: 11px;
	}

	tr:nth-child(even) {
		background-color: #dddddd;
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
							<th>{{$remaining}}</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</body>
</html>
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
			<h2 style="text-align: center;">Price Quotation</h2>
			<hr>
			<div class="col-md-12">
				<table id="myTable">
					<thead>
						<tr>
							<th class="no-sort" style="width:10%;">Sl</th>
							<th style="width:30%;">Name</th>
							<th class="no-sort" style="width:20%;">MRP</th>
							<th class="no-sort" style="width:20%;">Trade Price ({{$trade_price}} %)</th>
						</tr>
					</thead>
					<tbody>
						@foreach($products as $product)
						<tr>
							<td>{{$loop->iteration}}</td>
							<td>{{ $product->product_name }}</td>
							<td>{{ $product->mrp }}</td>
							<td>{{ceil(($product->mrp * 100 ) / ($trade_price + 100))}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>
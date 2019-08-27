<!DOCTYPE html>
<html lang="en">
<body>
	<table>
		<thead>
			<tr>
				<th colspan="4">Price Quatation ({{$trade_price}}%)</th>
			</tr>
			<tr>
				<th>Sl</th>
				<th>Name</th>
				<th>MRP</th>
				<th>Trade Price ({{$trade_price}} %)</th>
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
</body>
</html>
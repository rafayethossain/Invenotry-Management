<!DOCTYPE html>
<html lang="en">
<body>
	<table>
		<thead>
			<tr>
				<th>Sl</th>
				<th>Name</th>
				<th>Stock</th>
			</tr>
		</thead>
		<tbody>
			@foreach($products as $product)
			<tr>
				<td>{{$loop->iteration}}</td>
				<td>{{ $product->product_name }}</td>
				<td>{{ $product->product_stock }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<body>
	<table>
		<thead>
			<tr>
				<td>Order No {{$id}}</td>
			</tr>
			<tr>
				<td>Sale Date: {{$sales[0]->sale_date}}</td>					
			</tr>
			<tr>
				<td>Invoice No.: {{$sales[0]->invoice_no}}</td>
			</tr>
			<tr>
				<td>Sales Representative: {{ $sales[0]->user->name }}</td>
			</tr>
			<tr>
				<td>
					Customer Name: {{ $sales[0]->customer->customer_name }}
				</td>
			</tr>
			<tr>
				<td>Customer Address: {{ $sales[0]->customer->customer_address }}</td>
			</tr>
			<tr>
				<th>Sl</th>	
				<th>Product Name</th>				
				<th>Quantity</th>
				<th>MRP</th>
				<th>TP (%)</th>
				<th>Trade Price</th>					
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			@foreach($sales as $sale)
			<tr>
				<td>{{$loop->iteration}}</td>
				<td>{{ $sale->product->product_name }}</td>
				@php
				$sum = array();
				$quantity = explode("|",$sale->quantity);
				$sum = array_merge($sum, $quantity);
				$total = array_sum($sum);
				@endphp
				<td>{{ $total }}</td>
				<td>{{ $sale->product->mrp}}</td>
				<td>{{ $sale->trade_price}}</td>
				<td>{{ $sale->tp_amount}}</td>					
				<td>{{ $sale->total}}</td>				
			</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<th>Grand Total: {{array_sum($sale_total)}}</th>
				<th></th>
			</tr>
		</tfoot>
	</table>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<body>
	<table>
		<thead>
			<tr>
				<th colspan="6">All Transaction from {{$start_date}} to {{$end_date}}</th>
			</tr>
			<tr>
				<th>Sl</th>
				<th>Customer Name</th>		
				<th>Sale Amount</th>					
				<th>Received Amount</th>
				<th>Remaining Amount</th>
				<th>Expense(if any)</th>
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
				<th colspan="2" style="text-align:right"></th>
				<th>{{array_sum($sale_total)}}</th>
				<th>{{array_sum($income_total)}}</th>
				<th>{{array_sum($sale_total) - array_sum($income_total)}}</th>
				<th>{{array_sum($expense_total)}}</th>
			</tr>
		</tfoot>
	</table>
</body>
</html>
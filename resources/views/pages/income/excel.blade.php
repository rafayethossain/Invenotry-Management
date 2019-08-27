<!DOCTYPE html>
<html lang="en">
<body>
	<table id="myTable">
		<thead>
			<tr>
				<th colspan="6">Incomes From {{$start_date}} To {{$end_date}}</th>
			</tr>
			<tr>
				<th>Sl</th>
				<th>Date</th>					
				<th>Customer Name</th>
				<th>Purpose</th>
				<th>Payment Type</th>
				<th>Amount</th>
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
</body>
</html>
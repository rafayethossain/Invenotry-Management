@extends('layouts.master')
@section('title', 'Customer Report')

@section('content')
<div class="content-header">
	<a href="{{ url('customer') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Customers
	</a> 

	<a href="{{ url('customer/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add Customer
	</a>

	<a href="{{url('individual-customer-report', $customer->id)}}" target="_blank" class="btn btn-info">
		<i class="fa fa-print" aria-hidden="true" title="Print"></i>
		Print
	</a>

	<a href="{{url('individual-customer-report-pdf', $customer->id)}}" target="_blank" class="btn btn-info">
		<i class="fa fa-file-pdf-o" aria-hidden="true" title="PDF"></i>
		PDF
	</a> 

	<a href="{{url('individual-customer-report-excel', $customer->id)}}" target="_blank" class="btn btn-info">
		<i class="fa fa-file-excel-o" aria-hidden="true" title="Excel"></i>
		Excel
	</a>      
</div>
<br>
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
					<th colspan="4" style="text-align:right">Total:</th>
					<th></th>
				</tr>
				@if(count($expenses) > 0)
				@foreach($expenses as $expense)
				<tr>
					<th colspan="4" style="text-align:right">{{ $expense->expenseitem->name }}:</th>
					<th>{{$expense->amount}}</th>
				</tr>
				@endforeach
				@endif
			</tfoot>
		</table>
	</div>
</div>
@endsection

@section('script')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script>
	$(document).ready(function(){
		$('#myTable').DataTable({
			"columnDefs": [{
				"targets": 'no-sort',
				"orderable": false,
			}],

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
@endsection
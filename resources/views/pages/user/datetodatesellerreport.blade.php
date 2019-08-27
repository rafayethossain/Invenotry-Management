@extends('layouts.master')
@section('title', 'Seller Report')

@section('content')
<div class="content-header"> 
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">{{$user->name}}'s Sales Report</h2>
	<h4 style="text-align: center;">Area Name: {{$user->area->area_name}} </h4>
	<h4 style="text-align: center;">Sub Area Name: {{$user->subArea->subArea_name}} </h4>
	<hr>
	<div class="col-md-12">
		<table id="myTable">
			<thead>
				<tr>
					<th class="no-sort" style="width:10%;">Sl</th>
					<th style="width:20%;">Date</th>		
					<th style="width:40%;">Customer Name</th>					
					<th style="width:30%;">Amount</th>
				</tr>
			</thead>
			<tbody>
				@foreach($sales as $sale)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{ $sale->sale_date }}</td>
					<td>{{ $sale->customer->customer_name }}</td>
					<td>{{ $sale->sum }}</td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th colspan="3" style="text-align:right"></th>
					<th></th>
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
			    expensetotal = api
			        .column( 3 )
			        .data()
			        .reduce( function (a, b) {
			            return intVal(a) + intVal(b);
			        });
			
			    // Total over this page
			    expensepageTotal = api
			        .column( 3, { page: 'current'} )
			        .data()
			        .reduce( function (a, b) {
			            return intVal(a) + intVal(b);
			        });
			
			    // Update footer
			    $( api.column( 3 ).footer() ).html(
			        ''+expensepageTotal +' ( '+ expensetotal +' total)'
			    );
			}
		});
	});
</script>
@endsection
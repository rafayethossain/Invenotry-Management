@extends('layouts.master')
@section('title', 'Area Sales Report')

@section('content')
<div class="content-header">
	<a href="{{ url('sale') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Sales List
	</a>         
</div>
<br>
@if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
     	<strong>{{session('status')}}</strong>
      	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      	</button>
    </div>
@endif

<div id="approval"></div>
<div class="container">
	<h2 style="text-align: center;">{{$area->area_name}} Area Sales Report</h2>
	<hr>
	<h3>Employees</h3>
	@foreach($users as $user)
	<p>{{$loop->iteration}} -- <a href="{{route('user.show', $user->id)}}">{{ $user->name }}</a></p> 
	@endforeach
	<br>
	<div class="col-md-12">
		<table id="myTable">
			<thead>
				<tr>
					<th class="no-sort" style="width:10%;">Sl</th>
					<th style="width:10%;">Date</th>			
					<th style="width:30%;">Customer Name</th>								
					<th style="width:30%;">Seller Name</th>
					<th style="width:20%;">Amount</th>
				</tr>
			</thead>
			<tbody>
				@foreach($totalsale as $sales)
				@foreach($sales as $sale)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{ $sale->sale_date }}</td>	
					<td>{{ $sale->customer->customer_name }}</td>
					<td>{{ $sale->user->name }}</td>
					<td>{{ $sale->sum }}</td>					
				</tr>
				@endforeach
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th colspan="4" style="text-align:right">Total:</th>
					<th></th>
				</tr>
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
			
			    // Total over this page
			    pageTotal = api
			        .column( 4, { page: 'current'} )
			        .data()
			        .reduce( function (a, b) {
			            return intVal(a) + intVal(b);
			        });
			
			    // Update footer
			    $( api.column( 4 ).footer() ).html(
			        ''+pageTotal +' ( '+ total +' total)'
			    );
			}
		});
	});
</script>
@endsection
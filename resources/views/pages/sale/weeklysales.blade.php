@extends('layouts.master')
@section('title', 'Weekly Sale')

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
	<h2 style="text-align: center;">Weekly Sales List</h2>
	<hr>
	<div class="col-md-12">
		<table id="myTable">
			<thead>
				<tr>
					<th class="no-sort" style="width:10%;">Sl</th>	
					<th style="width:10%;">Order ID</th>				
					<th style="width:20%;">Sale Date</th>
					<th style="width:20%;">Customer Name</th>								
					<th style="width:20%;">Seller Name</th>
					<th style="width:20%;">Amount</th>
					<th style="width:10%;" class="no-sort">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($sales as $sale)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{ $sale->order_id }}</td>
					<td>{{ $sale->sale_date }}</td>
					<td>{{ $sale->customer->customer_name }}</td>
					<td>{{ $sale->user->name }}</td>
					<td>{{ $sale->sum }}</td>					
					<td>
						<a href="{{route('sale.show', $sale->order_id)}}"><i class="fa fa-eye" aria-hidden="true" title="Show"></i></a>

						@role('super_admin')
						<form class="EditForm" method="POST" action="{{url('saleapproval', $sale->order_id)}}" style="float: left;">											
							<button type="submit" class="delete-button"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Approve the Sale"></i></button>
						</form>
						@endrole
					</td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th colspan="5" style="text-align:right">Total:</th>
					<th></th>
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
			        .column( 5 )
			        .data()
			        .reduce( function (a, b) {
			            return intVal(a) + intVal(b);
			        });
			
			    // Total over this page
			    pageTotal = api
			        .column( 5, { page: 'current'} )
			        .data()
			        .reduce( function (a, b) {
			            return intVal(a) + intVal(b);
			        });
			
			    // Update footer
			    $( api.column( 5 ).footer() ).html(
			        ''+pageTotal +' ( '+ total +' total)'
			    );
			}
		});
	});
</script>
<script>
	$('.EditForm').on('submit', function(e){

		e.preventDefault(e);
		var method = $(this).attr('method');
		var url = $(this).attr('action');
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			url:url,  
			method:method,                               
			success: function( data ) {
       			var html = '';
       			html += '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong id="approval_message"></strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            	// Append the built HTML to a DOM element of your choice
            	$('#approval').empty().append(html);
            	document.getElementById("approval_message").innerHTML = data;
        	}
    	});     
	});
</script>
@endsection
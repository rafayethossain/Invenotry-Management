@extends('layouts.master')
@section('title', 'Damaged Product')

@section('content')
<div class="content-header">
	<a href="{{ url('damagedproduct/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add Damage
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
<div class="container">
	<h2 style="text-align: center;">Damage List</h2>
	<hr>
	<div class="col-md-12">
		<table id="myTable">
			<thead>
				<tr>
					<th class="no-sort" style="width:10%;">Sl</th>
					<th style="width:15%;">Date</th>
					<th style="width:20%;">Product Name</th>
					<th style="width:15%;">Quantity</th>
					<th style="width:30%;" class="no-sort">Damage Type</th>
					<th style="width:10%;" class="no-sort">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($damagedproducts as $damage)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{ $damage->date }}</td>
					<td>{{ $damage->product->product_name }}</td>
					<td>{{ $damage->quantity }}</td>
					<td>
						@if($damage->damage_type == 1)
						Replaced To Customer
						@elseif($damage->damage_type == 2)
						Not Replaced
						@else
						Damaged in Store 
						@endif 
					</td>
					<td>
						<a href="{{route('damagedproduct.show', $damage->id)}}"><i class="fa fa-eye" aria-hidden="true" title="Show"></i></a>

						<a href="{{route('damagedproduct.edit', $damage->id)}}" style="margin-left: 5px;"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit"></i></a>
					</td>
				</tr>
				@endforeach
			</tbody>
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
			}]
		});
	});
</script>
<script>
	$(".delete-item").on("submit", function(){
		return confirm("The category may have some sub category.Those will be deleted too. Do you want to delete this item?");
	});
</script>
@endsection
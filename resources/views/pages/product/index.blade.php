@extends('layouts.master')
@section('title', 'Products')

@section('content')
<div class="content-header">
	@role(['super_admin','admin'])
	<a href="{{ url('product/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add Product
	</a>
	<a href="{{url('print-product')}}" target="_blank" class="btn btn-info">
		<i class="fa fa-print" aria-hidden="true" title="Print"></i>
		Print
	</a>
	<a href="{{url('product-pdf')}}" target="_blank" class="btn btn-info">
		<i class="fa fa-file-pdf-o" aria-hidden="true" title="PDF"></i>
		PDF
	</a> 
	<a href="{{url('product-excel')}}" target="_blank" class="btn btn-info">
		<i class="fa fa-file-excel-o" aria-hidden="true" title="Excel"></i>
		Excel
	</a>  
	@endrole         
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
	<h2 style="text-align: center;">Products List</h2>
	<hr>
	<div class="col-md-12">
		<table id="myTable">
			<thead>
				<tr>
					<th class="no-sort" style="width:5%;">Sl</th>
					<th style="width:20%;">Name</th>
					<th style="width:17%;">Category Name</th>
					<th style="width:18%;">SubCategory Name</th>
					<th class="no-sort" style="width:10%;">Stock</th>
					<th class="no-sort" style="width:10%;">MRP</th>
					<th class="no-sort" style="width:10%;">Image</th>
					@role(['super_admin','admin'])
					<th style="width:10%;" class="no-sort">Actions</th>
					@endrole
				</tr>
			</thead>
			<tbody>
				@foreach($products as $product)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{ $product->product_name }}</td>
					<td>{{ $product->category->category_name }}</td>
					<td>{{ $product->subcategory->subCategory_name }}</td>
					<td>{{ $product->product_stock }}</td>
					<td>{{ $product->mrp }}</td>
					<td><img src="{{ asset('images/products/'.$product->product_image) }}" class="avatar"></td>
					@role(['super_admin','admin'])
					<td>
						<a href="{{route('product.show', $product->id)}}"><i class="fa fa-eye" aria-hidden="true" title="Show"></i></a>

						<a href="{{route('product.edit', $product->id)}}" style="margin-left: 5px;"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit"></i></a>
					</td>
					@endrole
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
		return confirm("Do you want to delete this item?");
	});
</script>
@endsection
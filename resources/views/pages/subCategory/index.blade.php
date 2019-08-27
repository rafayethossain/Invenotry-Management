@extends('layouts.master')
@section('title', 'Sub Category')

@section('content')
<div class="content-header">
	<a href="{{ url('subcategory/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add Sub Category
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
	<h2 style="text-align: center;">Sub Category List</h2>
	<hr>
	<div class="col-md-12">
		<table id="myTable">
			<thead>
				<tr>
					<th class="no-sort" style="width:10%;">Sl</th>
					<th style="width:15%;">Name</th>
					<th style="width:15%;">Category Name</th>
					<th style="width:50%;" class="no-sort">Details</th>
					<th style="width:10%;" class="no-sort">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($subcategories as $subcategory)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{ $subcategory->subCategory_name }}</td>
					<td>{{ $subcategory->category->category_name }}</td>
					<td>{{substr($subcategory->subCategory_details, 0,65)}}{{strlen($subcategory->subCategory_details)>65?"...........":""}}</td>
					<td>
						<a href="{{route('subcategory.show', $subcategory->id)}}"><i class="fa fa-eye" aria-hidden="true" title="Show"></i></a>

						<a href="{{route('subcategory.edit', $subcategory->id)}}" style="margin-left: 5px;"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit"></i></a>
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
		return confirm("Do you want to delete this item?");
	});
</script>
@endsection
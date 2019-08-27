@extends('layouts.master')
@section('title', 'Category')

@section('content')
<div class="content-header">
	<a href="{{ url('category/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add Category
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
	<h2 style="text-align: center;">Category List</h2>
	<hr>
	<div class="col-md-12">
		<table id="myTable">
			<thead>
				<tr>
					<th class="no-sort" style="width:10%;">Sl</th>
					<th style="width:20%;">Name</th>
					<th style="width:60%;" class="no-sort">Details</th>
					<th style="width:10%;" class="no-sort">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($categories as $category)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{ $category->category_name }}</td>
					<td>{{substr($category->category_details, 0,85)}}{{strlen($category->category_details)>85?"...........":""}}</td>
					<td>
						<a href="{{route('category.show', $category->id)}}"><i class="fa fa-eye" aria-hidden="true" title="Show"></i></a>

						<a href="{{route('category.edit', $category->id)}}" style="margin-left: 5px;"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit"></i></a>
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
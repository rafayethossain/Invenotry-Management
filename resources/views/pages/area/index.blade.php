@extends('layouts.master')
@section('title', 'Area')

@section('content')
<div class="content-header">
	<a href="{{ url('area/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add Area
	</a>

	<form id="particularexpense" method="GET" action="{{url('area/report')}}" class="form-inline">
		{{ csrf_field() }}
		<label for="inlineFormCustomSelect">Start Date</label>
		<input type="text" name="start_date" id="start_date" class="form-control" required="required" placeholder="Start Date">
		<label for="inlineFormCustomSelect">End Date</label>
		<input type="text" name="end_date" id="end_date" class="form-control" required="required" placeholder="End Date">
		<label for="inlineFormCustomSelect">Area</label>
		<select name="area_id" class="form-control" required="required">
			<option value="">Select Area</option>
			@foreach ($areas as $area)
			<option value="{{ $area->id }}">{{ $area->area_name }}</option>
			@endforeach
		</select>
		<button type="submit" class="btn btn-info"><i class="fa fa-line-chart" aria-hidden="true" title="Report"></i> Report</button>
	</form>          
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
	<h2 style="text-align: center;">Area List</h2>
	<hr>
	<div class="col-md-12">
		<table id="myTable">
			<thead>
				<tr>
					<th class="no-sort" style="width:10%;">Sl</th>
					<th style="width:20%;">Area Name</th>
					<th style="width:60%;" class="no-sort">Details</th>
					<th style="width:10%;" class="no-sort">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($areas as $area)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{ $area->area_name }}</td>
					<td>{{substr($area->area_details, 0,85)}}{{strlen($area->area_details)>85?"...........":""}}</td>
					<td>
						<a href="{{route('area.show', $area->id)}}"><i class="fa fa-eye" aria-hidden="true" title="Show"></i></a>

						<a href="{{route('area.edit', $area->id)}}" style="margin-left: 3px;"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit"></i></a>
						
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

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script>
	$( function() {
		$( "#start_date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		});
	} );
</script>

<script>
	$( function() {
		$( "#end_date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		});
	} );
</script>
@endsection
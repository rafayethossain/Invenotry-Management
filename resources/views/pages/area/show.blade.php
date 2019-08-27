@extends('layouts.master')
@section('title', 'Show Area')

@section('content')
<div class="content-header">
	<a href="{{ url('area') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Area List
	</a> 

	<a href="{{ url('area/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add Area
	</a>          
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">{{$area->area_name}}</h2>
	<hr>
	<div class="col-md-12">
		@foreach($manager as $area_manager)
		@if($area_manager->hasRole('area_manager'))
		<h5>Area Manager: {{$area_manager->name}}</h5>
		@endif
		@endforeach
		@foreach($salesmen as $seller)
		@if($seller->hasRole('seller'))
		<h5>Sales Representatives: {{$seller->name}}</h5>
		@endif
		@endforeach
		<h5>Created By: {{$added_by->name}}</h5>
		@if($area->edited_by)
		<h5>Edited By: {{$edited_by->name}}</h5>
		@endif
		<h5>Area Details: </h5>
		<p>{{$area->area_details}}</p>
	</div>
</div>
@endsection
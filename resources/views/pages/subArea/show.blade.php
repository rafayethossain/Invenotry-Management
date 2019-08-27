@extends('layouts.master')
@section('title', 'Show Sub Area')

@section('content')
<div class="content-header">
	<a href="{{ url('subarea') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Sub Area List
	</a> 

	<a href="{{ url('subarea/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add Sub Area
	</a>          
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">{{$subarea->subArea_name}}</h2>
	<hr>
	<div class="col-md-12">
		<h5>Area Name: {{$subarea->area->area_name}}</h5>
		@foreach($salesmen as $seller)
		@if($seller->hasRole('seller'))
		<h5>Sales Representative: {{$seller->name}}</h5>
		@endif
		@endforeach
		<h5>Created By: {{$added_by->name}}</h5>
		@if($subarea->edited_by)
		<h5>Edited By: {{$edited_by->name}}</h5>
		@endif
		<h5>Sub Area Details: </h5>
		<p>{{$subarea->subArea_details}}</p>
	</div>
</div>
@endsection
@extends('layouts.master')
@section('title', 'Show User')

@section('content')
<div class="content-header">
	<a href="{{ url('user') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		User List
	</a> 

	<a href="{{ url('user/create') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Add User
	</a>          
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">{{$user->name}}</h2>
	<hr>
	<div class="row">
		<div class="col-sm-8">
			<h5>User Mobile Number: {{$user->mobile}}</h5>
			<h5>User Email: {{$user->email}}</h5>
			<h5>User Role: {{ $user->roles->first()->display_name }}</h5>

			@if($user->roles->first()->name == 'area_manager')
			<h5>Selling Area: {{$user->area->area_name}}</h5>
			@endif

			@if($user->roles->first()->name == 'seller')
			<h5>Area: {{$user->area->area_name}}</h5>
			<h5>Selling Area: {{$user->subarea->subArea_name}}</h5>
			@endif
			<h5>User Address: {{$user->address}}</h5>
		</div>
		<div class="col-sm-4">
			<div>
				<img src="{{ asset('images/'.$user->image) }}" style="width: 175px;height: auto;">
			</div>
		</div>
	</div>
</div>
@endsection
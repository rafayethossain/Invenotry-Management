@extends('layouts.master')
@section('title', 'Order')

@section('content')
<div class="content-header">
	<a href="{{ url('order') }}" class="btn btn-info">
		<i class="fa fa-plus-square" aria-hidden="true"></i>
		Order List
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
	<h2 style="text-align: center;" class="alert alert-danger">Sorry, You Dont Have Sufficient Product To Make This Sale</h2>
	<br>
	<h4>Insufficient Product List</h4>
	<ol>
	@foreach($list as $key => $value )
	
		<li>{{$value}}</li>
	
	@endforeach
	</ol>
</div>
@endsection
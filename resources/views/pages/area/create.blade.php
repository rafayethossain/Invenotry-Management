@extends('layouts.master')
@section('title', 'Add Area')

@section('content')
<div class="content-header">
	<a href="{{ url('area') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Area List
	</a>         
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">Add a New Area</h2>
	<hr>
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-8">
			<form action="/area" method="POST">
				{{ csrf_field() }}
				<div class="form-group{{ $errors->has('area_name') ? ' has-error' : '' }}">
					<label for="area_name">Area Name <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="text" class="form-control" id="area_name" name="area_name" value="{{ old('area_name') }}" placeholder="Area Name">
					@if ($errors->has('area_name'))
	                    <span class="help-block">
	                        <strong>{{ $errors->first('area_name') }}</strong>
	                    </span>
                    @endif
				</div>
				<div class="form-group">
					<label for="area_details">Area Details</label>
					<textarea class="form-control" id="area_details" name="area_details" placeholder="Area Details" rows="5" cols="50">{{ old('area_details') }}</textarea>
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
		<div class="col-sm-3"></div>
	</div>
</div>
</div>
@endsection

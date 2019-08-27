@extends('layouts.master')
@section('title', 'Edit Sub Area')

@section('content')
<div class="content-header">
	<a href="{{ url('subarea') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		Sub Area List
	</a>         
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">Edit {{$subarea->subArea_name}}</h2>
	<hr>
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-8">
			<form action="{{route('subarea.update', $subarea->id)}}" method="POST">
				{{ csrf_field() }}
				{{ method_field('PATCH') }}
				<div class="form-group{{ $errors->has('subArea_name') ? ' has-error' : '' }}">
					<label for="subArea_name">Sub Area Name <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="text" class="form-control" id="subArea_name" name="subArea_name" value="{{ $subarea->subArea_name }}" placeholder="Area Name">
					@if ($errors->has('subArea_name'))
	                    <span class="help-block">
	                        <strong>{{ $errors->first('subArea_name') }}</strong>
	                    </span>
                    @endif
				</div>

				<div class="form-group{{ $errors->has('area_id') ? ' has-error' : '' }}">
					<label for="area_id">Area Name <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<select id="area_id" name="area_id" class="form-control">
						<option value="">Select Area</option>
						@foreach ($areas as $area)
						<option value="{{ $area->id }}" @if($area->id==$subarea->area_id) selected='selected' @endif>{{ $area->area_name }}</option>
						@endforeach
					</select>
					@if ($errors->has('area_id'))
					<span class="help-block">
						<strong>{{ $errors->first('area_id') }}</strong>
					</span>
					@endif
				</div>
								
				<div class="form-group">
					<label for="subArea_details">Sub Area Details</label>
					<textarea class="form-control" id="subArea_details" name="subArea_details" placeholder="Area Details" rows="5" cols="50">{{ $subarea->subArea_details }}</textarea>
				</div>
				<button type="submit" class="btn btn-success">Update</button>
				<button type="button" class="btn btn-danger" onClick="window.location.href='/subarea'">Cancel</button>
			</form>
		</div>
		<div class="col-sm-3"></div>
	</div>
</div>
</div>
@endsection

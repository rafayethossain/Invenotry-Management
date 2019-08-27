@extends('layouts.master')
@section('title', 'Edit User')

@section('content')
<div class="content-header">
	<a href="{{ url('user') }}" class="btn btn-info">
		<i class="fa fa-list" aria-hidden="true"></i>
		User List
	</a>         
</div>
<br>
<div class="container">
	<h2 style="text-align: center;">Edit {{$user->name}}</h2>
	<hr>
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-8">
			<form action="{{route('user.update', $user->id)}}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				{{ method_field('PATCH') }}
				<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
					<label for="name">User Name <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" placeholder="User Name">
					@if ($errors->has('name'))
					<span class="help-block">
						<strong>{{ $errors->first('name') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
					<label for="mobile">User Mobile <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<input type="text" class="form-control" id="mobile" name="mobile" value="{{ $user->mobile }}" placeholder="User Mobile">
					@if ($errors->has('mobile'))
					<span class="help-block">
						<strong>{{ $errors->first('mobile') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
					<label for="role_id">Role <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
					<select id="role_id" name="role_id" class="form-control">
						<option value="">Select Role</option>
						@foreach ($roles as $role)
						<option value="{{ $role->id }}" @if($role->id==$user->roles->first()->id) selected='selected' @endif>{{ $role->display_name }}</option>
						@endforeach
					</select>
					@if ($errors->has('role_id'))
					<span class="help-block">
						<strong>{{ $errors->first('role_id') }}</strong>
					</span>
					@endif
				</div>
				<div id="area_info">
					@if($user->roles->first()->name == 'area_manager')
					<div class="form-group{{ $errors->has('area_id') ? ' has-error' : '' }}">
						<label for="area_id">Area <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
						<select id="area_id" name="area_id" class="form-control">
							<option value="">Select Area</option>
							@foreach ($areas as $area)
							<option value="{{ $area->id }}" @if($area->id==$user->area_id) selected='selected' @endif>{{ $area->area_name }}</option>
							@endforeach
						</select>
						@if ($errors->has('area_id'))
						<span class="help-block">
							<strong>{{ $errors->first('area_id') }}</strong>
						</span>
						@endif
					</div>
					@endif

					@if($user->roles->first()->name == 'seller')
					<div class="form-group{{ $errors->has('area_id') ? ' has-error' : '' }}">
						<label for="area_id">Area <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
						<select id="area_id" name="area_id" class="form-control">
							<option value="">Select Area</option>
							@foreach ($areas as $area)
							<option value="{{ $area->id }}" @if($area->id==$user->area_id) selected='selected' @endif>{{ $area->area_name }}</option>
							@endforeach
						</select>
						@if ($errors->has('area_id'))
						<span class="help-block">
							<strong>{{ $errors->first('area_id') }}</strong>
						</span>
						@endif
					</div>

					<div class="form-group{{ $errors->has('subArea_id') ? ' has-error' : '' }}">
						<label for="subArea_id">Selling Area <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label>
						<select id="subArea_id" name="subArea_id" class="form-control">
							<option value="">Select Area</option>
					
							<option value="{{ $user->subArea_id }}" selected='selected' >{{ $user->subarea->subArea_name }}</option>
						</select>
						@if ($errors->has('subArea_id'))
						<span class="help-block">
							<strong>{{ $errors->first('subArea_id') }}</strong>
						</span>
						@endif
					</div>
					@endif
				</div>

				<div class="form-group">
					<label for="address">User Address</label>
					<textarea class="form-control" id="address" name="address" placeholder="User Address" rows="3" cols="50">{{ $user->address }}</textarea>
				</div>

				<div class="form-group">
					<label for="image">Image</label>
					<input type="file" name="image" id="image" onchange="readURL(this);">
					<br>
					<img id="blah" src="{{ asset('images/'.$user->image) }}" alt="" style="width: 150px; height: 125px;" />
				</div>
				<button type="submit" class="btn btn-success">Update</button>
				<button type="button" class="btn btn-danger" onClick="window.location.href='/user'">Cancel</button>
			</form>
		</div>
		<div class="col-sm-3"></div>
	</div>
</div>
</div>
@endsection

@section('script')
<script>
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#blah')
				.attr('src', e.target.result)
				.width(150)
				.height(125);
			};

			reader.readAsDataURL(input.files[0]);
		}
	}

</script>

<script>
	$('#role_id').on('change', function(){
		var role_id = $('#role_id').val();
		if (role_id == 5) {
			$('#area_info').html('');
			area_info = '';
			area_info += '<div class="form-group{{ $errors->has('area_id') ? 'has-error' : '' }}"><label for="area_id">Selling Area <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label><select id="area_id" name="area_id" class="form-control"><option value="">Select Selling Area</option>@foreach ($areas as $area)<option value="{{ $area->id }}">{{ $area->area_name }}</option>@endforeach</select>@if ($errors->has('area_id'))<span class="help-block"><strong>{{ $errors->first('area_id') }}</strong></span>@endif</div>';
			$('#area_info').html(area_info);
		}

				else if (role_id == 6) {
			$('#area_info').html('');
			area_info = '';
			area_info += '<div class="form-group{{ $errors->has('area_id') ? 'has-error' : '' }}"><label for="area_id">Area <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label><select id="area_id_seller" name="area_id" class="form-control"><option value="">Select Area</option>@foreach ($areas as $area)<option value="{{ $area->id }}">{{ $area->area_name }}</option>@endforeach</select>@if ($errors->has('area_id'))<span class="help-block"><strong>{{ $errors->first('area_id') }}</strong></span>@endif</div><div class="form-group{{ $errors->has('subArea_id') ? 'has-error' : '' }}"><label for="subArea_id">Selling Area <i class="fa fa-asterisk text-danger require" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Required"></i></label><select id="subArea_id" name="subArea_id" class="form-control"><option value="">Select Selling Area</option></select>@if ($errors->has('subArea_id'))<span class="help-block"><strong>{{ $errors->first('subArea_id') }}</strong></span>@endif</div>';
			$('#area_info').html(area_info);

			$('#area_id_seller').on('change', function(){
				var area_id = $('#area_id_seller').val();
				if (area_id != '') {
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});

					$.ajax({
						url:"/getsubarea/"+area_id,  
						method:'GET',                               
						success: function( data ) {
							console.log(data);
							sections = '';
							$.each( data, function( key, value ) {
								sections += '<option value="' + value.id + '">' + value.subArea_name + '</option>';
							});
							sections += '';

							$( '#subArea_id' ).html( sections );
						}
					}); 
				}
			});
		}
		else{
			$('#area_info').html('');
		}
	});
</script>
@endsection

@extends('_layout.dashboard')

@section('body')
	@foreach($errors->all() as $e)
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{$e}}
		</div>
	
	@endforeach
	<div class="container">
		<form action="{{url('/dashboard/users')}}/{{$users_container->id}}" method="POST">
			<div class="row">
				<div class="col-lg-6 col-lg-offset-3">
					<div class="form--container">
						<div class="box">
							<div class="box-body">
								<div class="form-group">
									<label for="email">Email</label>
									<input type="text" class="form-control" name="email" value="{{$users_container->email}}" readonly="readonly">
									<p class="help-block">Unfortunately you can't change the users email account. Please create a new account instead.</p>
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input type="text" class="form-control" name="password">
									<p class="help-block">Only fill this input if you want to change the users password.</p>
								</div>
								<div class="form-group">
									<label for="first_name">First Name</label>
									<input type="text" class="form-control" name="first_name" value="{{$users_container->first_name}}">
								</div>
								<div class="form-group">
									<label for="last_name">Last Name</label>
									<input type="text" class="form-control" name="last_name" value="{{$users_container->last_name}}">
								</div>
								<div class="form-group">
									<label for="role">Role</label>
									<select name="role" id="role" class="form-control">
										@foreach($roles as $r)
											<option value="{{$r->id}}">{{$r->name}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group" id="element--cobrand">
									<label for="cobrand_id">CoBrand</label>
									<select class="form-control" name="cobrand_id">
										@foreach($options as $key => $o)
											@if($o->id == $users_container->cobrand_id)
												<option value="{{$o->id}}" selected="selected">{{$o->name}}</option>
											@else
												<option value="{{$o->id}}">{{$o->name}}</option>
											@endif
										@endforeach
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6 col-lg-offset-3">
					<div class="form-group">
						<button class="btn btn-block btn-success"><i class="fa fa-check"></i> SUBMIT</button>
					</div>
				</div>
			</div>
		</form>
	</div>
@stop

@section('js')
	<script type="text/javascript">
		$(document).ready(function(){
			if($("#role option:selected").text() == 'Admin'){
				$("#element--cobrand").fadeOut();
			}
		});

		$("#role").change(function(){
			if($("#role option:selected").text() == 'Admin'){
				$("#element--cobrand").fadeOut();
			}else{
				$("#element--cobrand").fadeIn();
			}
		})
	</script>
@stop
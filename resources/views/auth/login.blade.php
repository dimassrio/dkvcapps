@extends('_layout.single')

@section('body')
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-lg-offset-3">
				<img src="{{asset('/img/logo.jpg')}}" class="img-responsive">
				<form id="form" method="POST" action="{{url('/auth/login')}}" class="form--login">
					<div class="form-group">
						<label for="email">EMAIL</label>
						<input type="text" class="form-control" id="email" name="email">
					</div>
					<div class="form-group">
						<label for="password">PASSWORD</label>
						<input type="password" class="form-control" id="password" name="password">
					</div>
					<div class="form-group">
						<button class="btn btn-warning btn-block" id="submit">Login</button>
					</div>
				</form>

			</div>
		</div>
	</div>
@stop
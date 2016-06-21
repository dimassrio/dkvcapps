@extends('_layout.dashboard')

@section('body')
	@foreach($errors->all() as $e)
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{$e}}
		</div>
	
	@endforeach
	<div class="container">
		<form action="{{url('/dashboard/video')}}/{{$video->id}}" method="POST">
			<div class="row">
				<div class="col-lg-6 col-lg-offset-3">
					<div class="form--container">
						<div class="box">
							<div class="box-body">
								<div class="form-group">
									<label for="title">Video Title</label>
									<input type="text" class="form-control" name="title" value="{{$video->title}}">
								</div>
								<div class="form-group">
									<label for="url">Video URL</label>
									<input type="text" class="form-control" name="url" value="{{$video->url}}">
								</div>
								<div class="form-group">
									<label for="cobrand_id">Video CoBrand</label>
									<select class="form-control" name="cobrand_id">
										@foreach($options as $key => $o)
											@if($o->id == $video->cobrand_id)
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
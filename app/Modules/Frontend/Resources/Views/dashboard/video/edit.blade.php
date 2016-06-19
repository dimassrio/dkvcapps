@layout('_layout.dashboard')

@section('body')
	<div class="container">
		<form action="{{url('/dashboard/video/{{$video->id}}')}}" method="POST">
			<div class="row">
				<div class="col-lg-6 col-lg-offset-3">
					<div class="form--container">
						<div class="form-group">
						<label for="title">Video Title</label>
						<input class="form-control" type="text" name="title[]" id="title" value="{{$video->title}}"></input>
					</div>
					<div class="form-group">
						<label for="url">Video URL</label>
						<input class="form-control" type="text" name="url[]" id="url" value="{{$video->url}}"></input>
					</div>
					<div class="form-group">
						<label for="cobrand">Co Brand</label>
						<select name="cobrand[]" id="cobrand" class="form-control">
							@foreach($option as $o)
								<option value="{{$o->id}}">{{$o->name}}</option>
							@endforeach
						</select>
					</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6 col-lg-offset-3">
					<div class="form-group">
						<button class="btn btn-block btn-info" type="button" id="button--add"><i class="fa fa-plus"></i> TAMBAH</button>
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
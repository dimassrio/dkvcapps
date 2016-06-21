@extends('_layout.dashboard')

@section('body')
	@foreach($errors->all() as $e)
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{$e}}
		</div>
	
	@endforeach
	<div class="container">
		<form action="{{url('/dashboard/cobrands')}}/{{$cobrand_container->id}}" method="POST">
			<div class="row">
				<div class="col-lg-6 col-lg-offset-3">
					<div class="form--container">
						<div class="box">
							<div class="box-body">
								<div class="form-group">
									<label for="name">CoBrand Name</label>
									<input type="text" class="form-control" name="name" value="{{$cobrand_container->name}}">
								</div>
								<div class="form-group">
									<label for="ref_id">Ref Id</label>
									<input type="text" class="form-control" name="ref_id" value="{{$cobrand_container->ref_id}}">
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
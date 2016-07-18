@extends('_layout.dashboard')

@section('body')
	<div class="box">
		<div class="box-header">
			@if(\Sentinel::inRole('admin'))
				<h3 class="box-title">Data Users <a href="{{url('/api/users')}}"><i class="fa fa-link"></i></a></h3>
			@else
				<h3 class="box-title">Data Users</h3>
			@endif
			<div class="box-tools">
				<a href="{{url('/dashboard/create/users')}}" class="btn btn-info btn-tiny"><i class="fa fa-plus"></i> Add users</a>
			</div>
		</div>
		<div class="box-body table-responsive no-padding">
			<table class="table table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th>Email</th>
							<th>Name</th>
							<th>Co Brand</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
			@foreach($users_container as $key => $v)
				<tr>
					<td>{{$key + 1}}</td>
					<td>{{$v->email}}</td>
					<td>{{$v->first_name}} {{$v->last_name}}</td>
					<td>
						@if($v->cobrand_id>0)
						{{$v->cobrand->name}}
						@else
						<span class="label label-danger">Admin</span>
						@endif
					</td>
					<td>
						<a href="{{url('/dashboard/users/')}}/{{$v->id}}/edit" class="btn btn-warning btn-tiny btn--edit"><i class="fa fa-pencil"></i></a>
						<button class="btn btn-danger btn-tiny btn--delete" id="btn--delete__{{$v->id}}" data-id="{{$v->id}}"><i class="fa fa-times"></i></button>
					</td>
				</tr>
			@endforeach
			</tbody>
				</table>
		</div>
		<div class="box-footer">
			<div class="box-tools">
				{!!$users_container->render()!!}
			</div>
		</div>
	</div>

	<div id="modal--delete" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	      	<h4 class="modal-title">
	      		DELETE USER?
	      	</h4>
	      </div>
	      <div class="modal-body">
        	<p>Remember, you can't undo this action. Once deleted the users registry can't be recovered at all.</p>
      	  </div>
	      <div class="modal-footer">
        <a href="#" class="btn btn-default" id="url--delete">DELETE</a>
        <button data-dismiss="modal"type="button" class="btn btn-primary">CANCEL</button>
      </div>
	    </div>
	  </div>
	</div>
@stop

@section('js')
	<script type="text/javascript">
		$(".btn--delete").click(function(){
			$("#url--delete").attr("href", "{{url('dashboard/users')}}/"+$(this).attr("data-id")+"/delete");
			$("#modal--delete").modal();
		});
	</script>
@stop

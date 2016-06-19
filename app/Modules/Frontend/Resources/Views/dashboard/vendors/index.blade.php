@extends('_layout.dashboard')

@section('body')
	<a href="{{url('/dashboard/create/vendors')}}" class="btn btn-info btn-tiny"><i class="fa fa-plus"></i> Add vendors</a>
	<table class="table table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Ref Id</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
	@foreach($vendor_container as $key => $v)
		<tr>
			<td>{{$key + 1}}</td>
			<td>{{$v->name}}</td>
			<td>{{$v->ref_id}}</td>
			<td>
				<button class="btn btn-danger btn-tiny btn--delete" id="btn--delete__{{$v->id}}" data-id="{{$v->id}}"><i class="fa fa-times"></i></button>
			</td>
		</tr>	
	@endforeach
	</tbody>
		</table>
	{!!$vendor_container->render()!!}

	<div id="modal--delete" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	      	<h4 class="modal-title">
	      		DELETE VENDOR?
	      	</h4>
	      </div>
	      <div class="modal-body">
        	<p>Remember, you can't undo this action, all vendor registry will be deleted and cant be recovered. If you delete this vendor, all users and video that associated with this vendor is also getting deleted.</p>	
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
			$("#url--delete").attr("href", "{{url('dashboard/vendors')}}/"+$(this).attr("data-id")+"/delete");
			$("#modal--delete").modal();
		});
	</script>
@stop
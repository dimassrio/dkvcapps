@extends('_layout.dashboard')

@section('body')
@if(session()->has('info'))
	<div class="alert alert-success">
			{{session('info')}}
	</div>
@endif
	<div class="box">
		<div class="box-header">
			@if(\Sentinel::inRole('admin'))
				<h3 class="box-title">Data Vendor <a href="{{url('/api/company')}}"><i class="fa fa-link"></i></a></h3>
			@else
				<h3 class="box-title">Data Vendor</h3>
			@endif
			<div class="box-tools">
				<a href="{{url('/dashboard/create/cobrands')}}" class="btn btn-info btn-tiny"><i class="fa fa-plus"></i> Add Cobrands</a>
			</div>
		</div>
		<div class="box-body table-responsive no-padding">
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
						<a href="{{url('/dashboard/cobrands')}}/{{$v->id}}/edit" class="btn btn-warning btn-tiny btn--edit"><i class="fa fa-pencil"></i></a>
						<button class="btn btn-danger btn-tiny btn--delete" id="btn--delete__{{$v->id}}" data-id="{{$v->id}}"><i class="fa fa-times"></i></button>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		</div>
		<div class="box-footer">
			<div class="box-tools">
				{!!$vendor_container->render()!!}
			</div>
		</div>
	</div>

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
			$("#url--delete").attr("href", "{{url('dashboard/cobrands')}}/"+$(this).attr("data-id")+"/delete");
			$("#modal--delete").modal();
		});
	</script>
@stop

@extends('_layout.dashboard')

@section('body')
	<div class="embed-responsive embed-responsive-16by9">
		<iframe src="https://www.youtube.com/embed/{{$embed['v']}}" frameborder="0" allowfullscreen></iframe>
	</div>
	<table class="table table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Ref_Id</th>
					<th>Comments</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
	@foreach($comments_container as $key => $v)
		<tr>
			<td>{{$key + 1}}</td>
			<td>{{$v->ref_id}}</td>
			<td>{{$v->comments}}</td>
			<td>
				<button class="btn btn-danger btn-tiny btn--delete" id="btn--delete__{{$v->id}}" data-id="{{$v->id}}"><i class="fa fa-times"></i></button>
			</td>
		</tr>	
	@endforeach
	</tbody>
	</table>

	{!!$comments_container->render()!!}

	<div id="modal--delete" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	      	<h4 class="modal-title">
	      		DELETE COMMENTS?
	      	</h4>
	      </div>
	      <div class="modal-body">
        	<p>Remember, you can't undo this action. Once deleted the comments registry can't be recovered at all.</p>	
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
			$("#url--delete").attr("href", "{{url('dashboard/comments')}}/delete/"+$(this).attr("data-id"));
			$("#modal--delete").modal();
		});
	</script>
@stop
@extends('_layout.dashboard')

@section('body')
	
	<div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Video</h3>
	            <!-- /.box-header -->
	            <div class="box-tools">
	            	<a href="{{url('/dashboard/create/video')}}" class="btn btn-info btn-tiny"><i class="fa fa-plus"></i> Add Video</a>
	            </div>
            </div>
            <div class="box-body table-responsive no-padding">
              <table class="table table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th>Title</th>
						<th>URL</th>
						<th>Co Brand</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
		@foreach($video as $key => $v)
			<tr>
				<td>{{$key + 1}}</td>
				<td>{{$v->title}}</td>
				<td><a href="{{$v->url}}">{{$v->url}}</a></td>
				<td><a href="{{url('/dashboard/video?search='.$v->company->id)}}">{{$v->company->name}}</a></td>
				<td>
					<a href="{{url('/dashboard/comments')}}/{{$v->id}}" class="btn btn-warning btn-tiny"><i class="fa fa-comments"></i></a>
					<button class="btn btn-danger btn-tiny btn--delete" id="btn--delete__{{$v->id}}" data-id="{{$v->id}}"><i class="fa fa-times"></i></button>
				</td>
			</tr>	
		@endforeach
		</tbody>
			</table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
            	<div class="box-tools">
                {!!$video->render()!!}
              </div>
            </div>
            </div>
	
	

	<div id="modal--delete" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	      	<h4 class="modal-title">
	      		DELETE VIDEO?
	      	</h4>
	      </div>
	      <div class="modal-body">
        	<p>Remember, you can't undo this action. Once deleted the video registry can't be recovered at all.</p>	
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
			$("#url--delete").attr("href", "{{url('dashboard/video')}}/"+$(this).attr("data-id")+"/delete");
			$("#modal--delete").modal();
		});
	</script>
@stop
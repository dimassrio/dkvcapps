@extends('_layout.dashboard')

@section('body')
@foreach($errors->all() as $e)
	<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		{{$e}}
	</div>

@endforeach
	<div class="container">
		<form action="{{url('/dashboard/cobrands')}}" method="POST">
			<div class="row">
				<div class="col-lg-6 col-lg-offset-3">
					<div class="form--container">

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

@section('js')
	<script type="text/javascript">
		var counter = 0;
		var form = function(id){
			// title
			var html = $("<div/>").attr("id", "element_"+id)
			.append(
				$("<div/>").attr("class", "form-group")
				.append($("<label/>").attr({for:"name_"+id}).text("Cobrand Name "+(id+1)), $("<input/>").attr({id:"name_"+id, class:"form-control", name:"name[]"})))
			.append(
				$("<div/>").attr("class", "form-group")
				.append($("<label/>").attr({for:"ref_id_"+id}).text("Cobrand Ref Id "+(id+1)), $("<input/>").attr({id:"ref_id_"+id, class:"form-control", name:"ref_id[]"})))
			.append($("<hr/>"));
			//url
			return html;
		}

		$(document).ready(function(){
			$(".form--container").html(form(counter));
			counter++;
		})

		$("#button--add").click(function(){
			$(".form--container").append(form(counter));
			counter++;
		})
	</script>
@stop

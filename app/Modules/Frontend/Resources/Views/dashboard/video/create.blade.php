@extends('_layout.dashboard')

@section('body')
	@foreach($errors->all() as $e)
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{$e}}
		</div>

	@endforeach
	<div class="container">
		<form action="{{url('/dashboard/video')}}" method="POST">
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
			var select = $("<select/>").attr({id:"cobrand_"+id, name:"cobrand_id[]", class:"form-control"});

			var options = JSON.parse(JSON.stringify(<?php echo $options?>));
			if(!Array.isArray(options)){
				options = [options];
			}

			for(var i=0; i<options.length; i++){
				var o = options[i];
					$("<option/>", {value:o.id, text:o.name}).appendTo(select);
				}

			var html = $("<div/>").attr("id", "element_"+id)
			.append(
				$("<div/>").attr("class", "form-group")
				.append($("<label/>").attr({for:"title_"+id}).text("Video Title "+(id+1)), $("<input/>").attr({id:"title_"+id, class:"form-control", name:"title[]"})))
			.append(
				$("<div/>").attr("class", "form-group")
				.append($("<label/>").attr({for:"url_"+id}).text("Video URL "+(id+1)), $("<input/>").attr({id:"url_"+id, class:"form-control", name:"url[]"})))
			.append(
				$("<div/>").attr("class", "form-group")
				.append($("<label/>").attr({for:"description_"+id}).text("Video Description "+(id+1)), $("<input/>").attr({id:"description_"+id, class:"form-control", name:"description[]"})))
			.append(
				$("<div/>").attr("class", "form-group")
				.append(
					$("<label/>").attr({for:"cobrand_"+id}).text("Co Brand "+(id+1)),
					select)
			.append($("<hr/>")));
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

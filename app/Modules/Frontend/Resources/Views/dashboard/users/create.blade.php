@extends('_layout.dashboard')

@section('body')
	@foreach($errors->all() as $e)
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{$e}}
		</div>
	@endforeach
	<div class="container">
		<form action="{{url('/dashboard/users')}}" method="POST">
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
			var select_cobrand = $("<select/>").attr({id:"cobrand_"+id, name:"cobrand_id[]", class:"form-control"});
			var select_roles = $("<select/>").attr({id:"roles_"+id, name:"roles_id[]", class:"form-control", data_id:id});

			var options = JSON.parse(JSON.stringify(<?php echo $options?>));
			var roles = JSON.parse(JSON.stringify(<?php echo $roles?>));

			if(!Array.isArray(options)){
				options = [options];
			}
			if(!Array.isArray(roles)){
				roles = [roles];
			}
			for(var i=0; i<options.length; i++){
				var o = options[i];
				$("<option/>", {value:o.id, text:o.name}).appendTo(select_cobrand);
			}
			for(var i=0; i<roles.length; i++){
				var o = roles[i];
				$("<option/>", {value:o.id, text:o.name}).appendTo(select_roles);
			}

			var html = $("<div/>").attr("id", "element_"+id)
			.append(
				$("<div/>").attr("class", "form-group")
				.append($("<label/>").attr({for:"email_"+id}).text("Email "+(id+1)), $("<input/>").attr({id:"email_"+id, class:"form-control", name:"email[]"})))
			.append(
				$("<div/>").attr("class", "form-group")
				.append($("<label/>").attr({for:"password_"+id}).text("Password "+(id+1)), $("<input/>").attr({id:"password_"+id, class:"form-control", name:"password[]", type:"password"})))
			.append(
				$("<div/>").attr("class", "form-group")
				.append($("<label/>").attr({for:"first_name_"+id}).text("First Name "+(id+1)), $("<input/>").attr({id:"first_name_"+id, class:"form-control", name:"first_name[]"})))
			.append(
				$("<div/>").attr("class", "form-group")
				.append($("<label/>").attr({for:"last_name_"+id}).text("Last Name "+(id+1)), $("<input/>").attr({id:"last_name_"+id, class:"form-control", name:"last_name[]"})))
			.append(
				$("<div/>").attr("class", "form-group")
				.append($("<label/>").attr({for:"role_"+id}).text("Role "+(id+1)), select_roles))
			.append(
				$("<div/>").attr({class:"form-group", id:"cobrand_element_"+id})
				.append(
					$("<label/>").attr({for:"cobrand_"+id}).text("Co Brand "+(id+1)),
					select_cobrand))
			.append($("<hr/>"));
			//url

			return html;
		}

		$(document).ready(function(){
			$(".form--container").html(form(counter));
			counter++;

			if($("#roles_"+0+" option:selected").text() == 'Admin'){
				$("#cobrand_element_0").fadeOut();
			}
			$("[id^=roles_]").on("change", function(){
				var id = $(this).attr("data_id");
				var roles = JSON.parse(JSON.stringify(<?php echo $roles?>));
				var results = $.grep(roles, function(e){
					return e.slug == 'cobrand'
				})

				 if($(this).val()==results[0].id){
				 	$("#cobrand_element_"+id).fadeIn();
				 }else{
				 	$("#cobrand_element_"+id).fadeOut();
				 }
			});
		})

		$("#button--add").click(function(){
			$(".form--container").append(form(counter));

			if($("#roles_"+counter+" option:selected").text() == 'Admin'){
				$("#cobrand_element_"+counter).fadeOut();
			}
			$("[id^=roles_]").on("change", function(){
				var id = $(this).attr("data_id");
				var roles = JSON.parse(JSON.stringify(<?php echo $roles?>));
				var results = $.grep(roles, function(e){
					return e.slug == 'cobrand'
				})
				console.log(results.length);
				if(results.length == 0){
					alert("Cobrand tidak ditemukan.");
					window.location = "{{url('/dashboard/cobrands')}}";
				}
				if($(this).val()==results[0].id){
					$("#cobrand_element_"+id).fadeIn();
				}else{
					$("#cobrand_element_"+id).fadeOut();
				}
			});


			counter++;
		})
	</script>
@stop

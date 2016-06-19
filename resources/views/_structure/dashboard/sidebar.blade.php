<div class="main-sidebar">
	<!-- Inner sidebar -->
	<div class="sidebar">
		<!-- user panel (Optional) -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="http://placehold.it/160x160?text=A" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p>{{ucfirst($users->name)}}</p>

				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div><!-- /.user-panel -->

		<!-- Sidebar Menu -->
		<ul class="sidebar-menu">
			<li class="header">HEADER</li>
			<!-- Optionally, you can add icons to the links -->
			@foreach($menus as $m)
				<li @if($active == $m->slug)class="active"@endif><a href="{{url('/dashboard')}}/{{$m->slug}}"><i class="fa fa-setting"></i> <span>{{$m->name}}</span></a></li>
			@endforeach
			<!-- <li><a href="#"><span>Another Link</span></a></li>
			<li class="treeview">
				<a href="#"><span>Multilevel</span> <i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<li><a href="#">Link in level 2</a></li>
					<li><a href="#">Link in level 2</a></li>
				</ul>
			</li> -->
		</ul><!-- /.sidebar-menu -->

	</div><!-- /.sidebar -->
</div><!-- /.main-sidebar -->
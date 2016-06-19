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
			<li @if($active == 'video')class="active"@endif><a href="{{url('/dashboard/video')}}"><i class="fa fa-video-camera"></i> <span>Video</span></a></li>
			<li @if($active == 'comments')class="active"@endif><a href="{{url('/dashboard/comments')}}"><i class="fa fa-comments"></i> <span>Comments</span></a></li>
			<li @if($active == 'users')class="active"@endif><a href="{{url('/dashboard/users')}}"><i class="fa fa-users"></i> <span>Users</span></a></li>
		
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
<header class="main-header">
	<a href="{{url('/dashboard/video')}}" class="logo">
		<!-- LOGO -->
		DOKU
	</a>
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top" role="navigation">
		<!-- Navbar Right Menu -->
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<!-- Messages: style can be found in dropdown.less-->
				
				<!-- User Account: style can be found in dropdown.less -->
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="http://placehold.it/160x160?text=A" class="user-image" alt="User Image">
						<span class="hidden-xs">{{ucfirst($users->first_name)}} {{ucfirst($users->last_name)}}</span>
					</a>
					<ul class="dropdown-menu">
						<!-- User image -->
						<li class="user-header">
							<img src="http://placehold.it/160x160?text=A" class="img-circle" alt="User Image">
							<p>
								{{ucfirst($users->name)}}
								<small>Admin since {{date('d F Y', strtotime($users->created_at))}}</small>
							</p>
						</li>
						<!-- Menu Body -->
						<!-- Menu Footer-->
						<li class="user-footer">
							<div class="pull-right">
								<a href="{{url('/auth/logout')}}" class="btn btn-default btn-flat">Sign out</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</header>

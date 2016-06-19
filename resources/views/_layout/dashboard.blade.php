<!doctype html>
<html class="no-js" lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title>{{$title or ""}}</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="apple-touch-icon" href="apple-touch-icon.png">
		<!-- Place favicon.ico in the root directory -->
		<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/dist/css/bootstrap.min.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">
		<link rel="stylesheet" href="{{asset('assets/vendor/AdminLTE/dist/css/AdminLTE.min.css')}}">
		<link rel="stylesheet" href="{{asset('assets/vendor/AdminLTE/dist/css/skins/skin-red.min.css')}}">
		@yield('css')
	</head>
	<body class="skin-red sidebar-mini">
		<div class="wrapper">
			@include('_structure.dashboard.header')
			@include('_structure.dashboard.sidebar')
			<div class="content-wrapper" style="min-height: 298px;">
			<!-- Content Header (Page header) -->
			<section class="content-header">
			  <h1>
				{{$title}}
				<small>{{$description}}</small>
			  </h1>
			</section>

			<!-- Main content -->
			<section class="content">
				@yield('body')
			  <!-- Your Page Content Here -->
			</section>
			<!-- /.content -->
		  </div>
		</div>

		<script type="text/javascript" src="{{asset('assets/vendor/jquery/dist/jquery.min.js')}}"></script>
		<script src="{{asset('assets/vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
		<script type="text/javascript" src="{{asset('assets/vendor/AdminLTE/dist/js/app.min.js')}}"></script>
		@yield('js')
		<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
		<script>
			(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
			function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
			e=o.createElement(i);r=o.getElementsByTagName(i)[0];
			e.src='https://www.google-analytics.com/analytics.js';
			r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
			ga('create','UA-XXXXX-X','auto');ga('send','pageview');
		</script>
	</body>
</html>

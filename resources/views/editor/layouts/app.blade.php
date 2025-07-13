<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Editor Panel</title>

		<!-- Google Font: Source Sans Pro -->
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" rel="stylesheet">

		<!-- Font Awesome -->
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

		<!-- Ionicons -->
		<link href="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/css/ionicons.min.css" rel="stylesheet">

		<!-- AdminLTE CSS -->
		<link href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" rel="stylesheet">

		<!-- Summernote -->
		<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.css" rel="stylesheet">

		<!-- Dropzone -->
		<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" rel="stylesheet">

		<!-- Custom CSS (only local, since it's project specific) -->
		<link href="{{ asset('admin-assets/css/custom.css') }}" rel="stylesheet">

		<meta name="csrf-token" content="{{ csrf_token() }}">
	</head>
	<body class="hold-transition sidebar-mini">
		<div class="wrapper">
			<!-- Navbar -->
			<nav class="main-header navbar navbar-expand navbar-white navbar-light">
				<ul class="navbar-nav">
					<li class="nav-item">
					  	<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
					</li>					
				</ul>
				<div class="navbar-nav pl-2"></div>
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link" data-widget="fullscreen" href="#" role="button">
							<i class="fas fa-expand-arrows-alt"></i>
						</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link p-0 pr-3" data-toggle="dropdown" href="#">
							@if (!empty(Auth::guard('editor')->user()->image))
								<img src="{{ asset('uploads/profile-pic/' . Auth::guard('editor')->user()->image) }}" class="img-circle elevation-2" width="40" height="40" alt="">
							@else
								<img src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/img/user2-160x160.jpg" class='img-circle elevation-2' width="40" height="40" alt="">
							@endif
						</a>
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
							<h4 class="h4 mb-0 text-capitalize"><strong>{{ Auth::guard('editor')->user()->name }}</strong></h4>
							<div class="mb-3">{{ Auth::guard('editor')->user()->email }}</div>
							<div class="dropdown-divider"></div>
							<a href="{{ route('editor.edit', Auth::guard('editor')->user()->id) }}" class="dropdown-item">
								<i class="fas fa-user-cog mr-2"></i> My Account								
							</a>
							<div class="dropdown-divider"></div>
							<a href="{{ route('editor.changePassword') }}" class="dropdown-item">
								<i class="fas fa-lock mr-2"></i> Change Password
							</a>
							<div class="dropdown-divider"></div>
							<a href="{{ route('editor.logout') }}" class="dropdown-item text-danger">
								<i class="fas fa-sign-out-alt mr-2"></i> Logout							
							</a>							
						</div>
					</li>
				</ul>
			</nav>

			<!-- Sidebar -->
			@include('editor.layouts.sidebar')

			<!-- Main Content -->
			<div class="content-wrapper">
				@yield('content')
			</div>

			<!-- Footer -->
			<footer class="main-footer">
				<strong>Copyright &copy; 2024 All rights reserved.
			</footer>
		</div>

		<!-- Scripts -->
		<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

		<!-- Ionicons -->
		<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
		<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

		<!-- Custom JS (keep local) -->
		<script src="{{ asset('admin-assets/js/main.js') }}"></script>

		<script>
			jQuery(document).ready(function() {
				$('.summernote').summernote({
					height: 300
				});
			});

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
		</script>

		@yield('customJS')
	</body>
</html>
s
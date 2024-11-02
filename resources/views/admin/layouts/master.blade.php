<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title> @yield('title') </title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{ asset('global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('global_assets/css/icons/material/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/all.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('custom_assets/css/style.css') }}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	@livewireStyles
    @stack('styles')

	<!-- Core JS files -->
	<script src="{{ asset('global_assets/js/main/jquery.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{ asset('global_assets/js/plugins/visualization/d3/d3.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/visualization/d3/d3_tooltip.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/visualization/echarts/echarts.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/notifications/noty.min.js') }}"></script>

	<script src="{{ asset('assets/js/app.js') }}"></script>
	<!-- /theme JS files -->

</head>

<body>

	<!-- Main navbar -->
    @include('admin.layouts.navbar')
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
        @include('admin.layouts.sidebar')
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">

				<!-- Page header -->
                @include('admin.layouts.header')
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
                @yield('contents')
				</div>
				<!-- /content area -->


				<!-- Footer -->
				@include('admin.layouts.footer')
				<!-- /footer -->

			</div>
			<!-- /inner content -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

    @livewireScripts
    @stack('scripts')

	<script src="{{ asset('custom_assets/js/script.js') }}"></script>

</body>
</html>

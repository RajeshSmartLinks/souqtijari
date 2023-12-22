<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
          content="Smartlinks CMS - Kuwait">
    <meta name="keywords"
          content="admin template, Smartlinks admin cms, dashboard, web app">
    <meta name="author" content="Smartlinks">
    <title>{{env('APP_NAME')}} - {{ !empty($title) ? $title : $titles['title']}}</title>
	<!--DI CODE - Start-->
    <?php /*?><link rel="apple-touch-icon" href="{{asset('images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/ico/favicon.ico')}}"><?php */?>	
	<link rel="icon" href="{{ asset('adminlayout/images/ico/SouqTijari-Favicon.png') }}" type="image/png"/>
	<link rel="shortcut icon" type="image/png" href="{{ asset('adminlayout/images/ico/SouqTijari-Favicon.png') }}" />
	<!--DI CODE - End-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('adminlayout/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('adminlayout/vendors/css/charts/apexcharts.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('adminlayout/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('adminlayout/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('adminlayout/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('adminlayout/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('adminlayout/css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('adminlayout/css/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('adminlayout/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('adminlayout/css/core/colors/palette-gradient.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('adminlayout/css/pages/dashboard-ecommerce.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('adminlayout/css/pages/card-analytics.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('adminlayout/css/plugins/extensions/toastr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('adminlayout/vendors/css/extensions/toastr.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('adminlayout/css/mudheer-style.css')}}">
    <!-- END: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('adminlayout/vendors/css/tables/datatable/datatables.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('adminlayout/vendors/css/forms/select/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('adminlayout/css/plugins/forms/validation/form-validation.css')}}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('extrastyle')

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns  navbar-floating footer-static  "
      data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">

<!-- BEGIN: Header-->
@include('layouts.admin-header')
<!-- END: Header-->


<!-- BEGIN: Main Menu-->
@include('layouts.admin-sidemenu')
<!-- END: Main Menu-->

<!-- BEGIN: Content-->
@yield('content')
<!-- END: Content-->

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light">
    <p class="clearfix blue-grey lighten-2 mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2020<a
                class="text-bold-800 grey darken-2" href="http://smartlinks.tech/" target="_blank">Smartlinks,</a>All rights Reserved</span><span
            class="float-md-right d-none d-md-block"></span>
        <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="feather icon-arrow-up"></i></button>
    </p>
</footer>
<!-- END: Footer-->


<!-- BEGIN: Vendor JS-->
<script src="{{asset('adminlayout/vendors/js/vendors.min.js')}}"></script>
<script src="{{asset('adminlayout/vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{asset('adminlayout/vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{asset('adminlayout/js/core/app-menu.js')}}"></script>
<script src="{{asset('adminlayout/js/core/app.js')}}"></script>
<script src="{{asset('adminlayout/js/scripts/components.js')}}"></script>
<!-- END: Theme JS-->

<!-- Data Tables -->
<script src="{{asset('adminlayout/vendors/js/tables/datatable/pdfmake.min.js')}}"></script>
<script src="{{asset('adminlayout/vendors/js/tables/datatable/vfs_fonts.js')}}"></script>
<script src="{{asset('adminlayout/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('adminlayout/vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
<script src="{{asset('adminlayout/vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
<script src="{{asset('adminlayout/vendors/js/tables/datatable/buttons.print.min.js')}}"></script>
<script src="{{asset('adminlayout/vendors/js/tables/datatable/buttons.bootstrap.min.js')}}"></script>
<script src="{{asset('adminlayout/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
<script src="{{asset('adminlayout/js/scripts/datatables/datatable.js')}}"></script>

<script src="{{asset('adminlayout/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('adminlayout/js/scripts/forms/select/form-select2.js')}}"></script>

<script src="{{asset('adminlayout/js/scripts/forms/validation/form-validation.js')}}"></script>

@yield('scripts')
</body>
<!-- END: Body-->

</html>

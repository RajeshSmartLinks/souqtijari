<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Smartlinks CMS - Kuwait">
    <meta name="keywords" content="admin template, Smartlinks admin cms, dashboard, web app">
    <meta name="author" content="Smartlinks">
    <title>{{env('APP_NAME')}} - Login Page</title>
	<!--DI CODE - Start-->
    <?php /*?><link rel="apple-touch-icon" href="{{asset('adminlayout/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('adminlayout/images/ico/favicon.ico')}}"><?php */?>	
	<link rel="icon" href="{{ asset('adminlayout/images/ico/SouqTijari-Favicon.png') }}" type="image/png"/>
	<link rel="shortcut icon" type="image/png" href="{{ asset('adminlayout/images/ico/SouqTijari-Favicon.png') }}" />
	<!--DI CODE - End-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('adminlayout/vendors/css/vendors.min.css')}}">
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
    <link rel="stylesheet" type="text/css" href="{{asset('adminlayout/css/pages/authentication.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('adminlayout/assets/css/style.css')}}">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern semi-dark-layout 1-column  navbar-floating footer-static bg-full-screen-image  blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column" data-layout="semi-dark-layout">
<!-- BEGIN: Content-->
@yield('content')
<!-- END: Content-->


<!-- BEGIN: Vendor JS-->
<script src="{{asset('adminlayout/vendors/js/vendors.min.js')}}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{asset('adminlayout/js/core/app-menu.js')}}"></script>
<script src="{{asset('adminlayout/js/core/app.js')}}"></script>
<script src="{{asset('adminlayout/js/scripts/components.js')}}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>

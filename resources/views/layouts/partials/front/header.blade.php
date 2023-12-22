<?php /*?>DI CODE - Start<?php */?>
<meta charset="UTF-8">
<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Favicon  -->
<?php /*?><link rel="icon" href="favicon.ico" type="image/x-icon"/>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" /><?php */?>
<link rel="icon" href="{{ asset('images/SouqTijari-Favicon.png') }}" type="image/png"/>
<link rel="shortcut icon" type="image/png" href="{{ asset('images/SouqTijari-Favicon.png') }}" />

@section('social-meta')
<!-- OG Meta Tags to improve the way the post looks when you share the page on LinkedIn, Facebook, Google+ -->
<meta property="og:site_name" content="{{getenv('APP_NAME')}}"/> <!-- website name -->
<meta property="og:site" content="{{route('home', app()->getLocale())}}"/> <!-- website link -->
<meta property="og:title" content="{{!empty($titles['title']) ? $titles['title'] : __('app.home')}}"/> <!-- title shown in the actual shared post -->
<meta property="og:description" content="{{!empty($titles['description']) ? strip_tags($titles['description']) : __('app.home')}}"/> <!-- description shown in the actual shared post -->
<meta property="og:image" content=""/> <!-- image link, make sure it's jpg -->
<meta property="og:url" content="" /> <!-- where do you want your post to link to -->
<meta property="og:type" content="article"/>

<!-- SEO Meta Tags -->
<meta name="description" content="{{!empty($titles['description']) ? strip_tags($titles['description']) : __('app.home')}}">
<meta name="author" content="SmartLinks">
<meta name="keywords" content="">

@show
<meta name="csrf-token" content="{{csrf_token()}}">
<!-- Website Title -->
<title>{{env('APP_NAME')}} - {{!empty($titles['title']) ? $titles['title'] : __('app.home')}}</title>

<!-- Bootstrap Css -->
<link href="{{ asset('plugins/bootstrap-4.3.1-dist/css/bootstrap.min.css') }}" rel="stylesheet" />
@if(app()->getLocale() == 'en')
<!-- Dashboard Css -->
<link href="{{ asset('css/en/style.css') }}" rel="stylesheet" />
<!-- Font-awesome  Css -->
<link href="{{ asset('css/en/icons.css') }}" rel="stylesheet"/>
@endif

@if(app()->getLocale() == 'ar')
<!-- Dashboard Css -->
<link href="{{ asset('css/ar/style.css') }}" rel="stylesheet" />
<!-- RTL Css -->
<link href="{{ asset('css/ar/rtl.css') }}" rel="stylesheet" />
<!-- Font-awesome  Css -->
<link href="{{ asset('css/ar/icons.css') }}" rel="stylesheet"/>
@endif

<link href="{{ asset('plugins/Horizontal2/Horizontal-menu/color-skins/color.css') }}" rel="stylesheet" />
<!--Select2 Plugin -->
<link href="{{ asset('plugins/select2/select2.min.css') }}" rel="stylesheet" />
<!-- Cookie css -->
<link href="{{ asset('/plugins/cookie/cookie.css') }}" rel="stylesheet">
<!-- Owl Theme css-->
<link href="{{ asset('plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
<!-- Custom scroll bar css-->
<link href="{{ asset('plugins/scroll-bar/jquery.mCustomScrollbar.css') }}" rel="stylesheet" />
<!-- jquery ui RangeSlider -->
<link href="{{ asset('plugins/jquery-uislider/jquery-ui.css') }}" rel="stylesheet">
<!-- COLOR-SKINS -->
<link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('webslidemenu/color-skins/color10.css') }}" />
<?php /*?>DI CODE - End<?php */?>
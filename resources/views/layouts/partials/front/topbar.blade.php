<?php /*?>DI CODE - Start<?php */?>
<!--Topbar-->
<div class="header-main">
  <div class="top-bar">
    <div class="container">
      <div class="row">
        <div class="col-xl-8 col-lg-8 col-sm-4 col-7">
          <div class="top-bar-left d-flex">
            <div class="clearfix">
              <ul class="socials">
				  @if($settingsDetail->facebook_url)
                <li> <a class="social-icon text-dark" href="{{$settingsDetail->facebook_url}}"><i class="fa fa-facebook"></i></a> </li>
				  @endif
				  @if($settingsDetail->twitter_url)
                <li> <a class="social-icon text-dark" href="{{$settingsDetail->twitter_url}}"><i class="fa fa-twitter"></i></a> </li>
				  @endif
				  @if($settingsDetail->instagram_url)
                <li> <a class="social-icon text-dark" href="{{$settingsDetail->instagram_url}}"><i class="fa fa-instagram"></i></a> </li>
				  @endif
                <!--<li> <a class="social-icon text-dark" href="#"><i class="fa fa-linkedin"></i></a> </li>
                <li> <a class="social-icon text-dark" href="#"><i class="fa fa-google-plus"></i></a> </li>-->
				  @foreach(request()->route()->parameters as $key=>$value)				  
				  @endforeach
				  @if(app()->getLocale() == 'en')
				  <li><a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), ['ar', request()->$key]) }}" ><i class="fa fa-flag"></i> عربى </a></li>
				 @else
				  <li><a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), ['en', request()->$key]) }}" ><i class="fa fa-flag"></i> English </a></li>
				 @endif
              </ul>
            </div>
            <div class="clearfix">
              <ul class="contact border-{{app()->getLocale() == 'en' ? 'left' : 'right'}}">
                <!--<li class="mr-5 d-lg-none"> <a href="#" class="callnumber text-dark"><span><i class="fa fa-phone mr-1"></i>: +425 345 8765</span></a> </li>-->
                
				  
				 <?php /*?> {{ __('app.home') }} <br> {{ __('app.aboutus') }} <br> @lang('app.home') <br> @lang('app.aboutus') <br><?php */?>
				  
				  <?php /*?>
				  @php
				  $name = Route::currentRouteName();
				  echo 'name = '.$name;
				  @endphp
				  @if($name != '')
				  @php
				  $link_en = route(\Illuminate\Support\Facades\Route::currentRouteName(), 'en');
				  $link_ar = route(\Illuminate\Support\Facades\Route::currentRouteName(), 'ar');
				  @endphp
				  @else
				  $link_en = 'home';
				  $link_ar = 'home';
				  @endif
                <li class="dropdown {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-5"> <a href="#" class="text-dark" data-toggle="dropdown"><span> Language <i class="fa fa-caret-down text-muted"></i></span> </a>
                  <div class="dropdown-menu dropdown-menu-{{app()->getLocale() == 'en' ? 'right' : 'left'}} dropdown-menu-arrow">
					  <a href="@php($link_en)" class="dropdown-item" > English </a>
					  <a href="@php($link_ar)" class="dropdown-item" > Arabic </a>
				  </div>
                </li><?php */?>
				  
				 
				  
               <?php /*?> <li class="dropdown {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-5"> <a href="#" class="text-dark" data-toggle="dropdown"><span> Language <i class="fa fa-caret-down text-muted"></i></span> </a>
                  <div class="dropdown-menu dropdown-menu-{{app()->getLocale() == 'en' ? 'right' : 'left'}} dropdown-menu-arrow">
					  <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), 'en') }}" class="dropdown-item" > English </a>
					  <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), 'ar') }}" class="dropdown-item" > Arabic </a>
				  </div>
                </li><?php */?>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-sm-8 col-5">
          <div class="top-bar-right">
            <ul class="custom">
				@guest
              <li> <a href="{{ route('userlogin', app()->getLocale()) }}#profile" class="text-dark"><i class="fa fa-user {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> <span>@lang('app.register')</span></a> </li>
              <li> <a href="{{ route('userlogin', app()->getLocale()) }}" class="text-dark"><i class="fa fa-sign-in {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> <span>@lang('app.login')</span></a> </li>
				@else
              <li class="dropdown"> <a href="#" class="text-dark" data-toggle="dropdown"><i class="fa fa-home {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i><span> @lang('app.my_dashboard')</span></a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
					<a href="{{ route('user.dashboard', app()->getLocale()) }}" class="{{ \Request::route()->getName() == 'user.dashboard' ? 'active' : ''  }} dropdown-item" > <i class="dropdown-icon icon icon-user"></i> @lang('app.my_profile') </a>
					<a class="{{ \Request::route()->getName() == 'user.ads' ? 'active' : ''  }} dropdown-item" href="{{ route('user.ads', app()->getLocale()) }}"> <i class="dropdown-icon icon icon-speech"></i> @lang('app.myads') </a>
					<a class="{{ \Request::route()->getName() == 'user.favourites' ? 'active' : ''  }} dropdown-item" href="{{ route('user.favourites', app()->getLocale()) }}"> <i class="dropdown-icon icon icon-heart"></i> @lang('app.myfavourites') </a>
					<!--<a class="dropdown-item" href="#"> <i class="dropdown-icon icon icon-bell"></i> Notifications </a>
					<a href="mydash.html" class="dropdown-item" > <i class="dropdown-icon  icon icon-settings"></i> Account Settings </a>-->
					<form id="logout-form" action="{{ route('logout', app()->getLocale()) }}" method="POST" >
					@csrf
					<a class="dropdown-item" href="javascript:void(0)" onclick="$('#logout-form').submit()"> <i class="dropdown-icon icon icon-power"></i> @lang('app.log_out') </a>	
				    </form>
				  </div>				  
              </li>
				@endguest
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  
	@if(app()->getLocale() == 'en')
	<?php
	$logo = asset('images/brand/souqtijari_logo_Eng.png');
	$logo1 = asset('images/brand/souqtijari_logo_Sticky_Eng.png');
	?>
	@else
	<?php
	$logo = asset('images/brand/souqtijari_logo-ar.png');
	$logo1 = asset('images/brand/souqtijari_logo_sticky_ar.png');
	?>
	@endif
	
  <!-- Mobile Header -->
  <div class="horizontal-header clearfix ">
    <div class="container"> <a id="horizontal-navtoggle" class="animated-arrow"><span></span></a> <a href="{{ route('home', app()->getLocale()) }}"><span class="smllogo"><img src="{{ $logo1 }}" width="120" alt=""/></span></a>
		@if($settingsDetail->contact_mobile)
		<a href="tel:{{ $settingsDetail->contact_mobile }}" class="callusbtn"><i class="fa fa-phone" aria-hidden="true"></i></a>
		@endif
	  </div>
  </div>
  <!-- /Mobile Header -->
  
  <div class="horizontal-main bg-dark-transparent clearfix">
    <div class="horizontal-mainwrapper container clearfix">
      <div class="desktoplogo"> <a href="{{ route('home', app()->getLocale()) }}"><img src="{{ $logo }}" alt=""></a> </div>
      <div class="desktoplogo-1"> <a href="{{ route('home', app()->getLocale()) }}"><img src="{{ $logo1 }}" alt=""></a> </div>
      <!--Nav-->
      <nav class="horizontalMenu clearfix d-md-flex">
        <ul class="horizontalMenu-list">
          <li aria-haspopup="true"><a href="{{ route('home', app()->getLocale()) }}">@lang('app.home')</a></li>
          <li aria-haspopup="true"><a href="{{ route('content.about', app()->getLocale()) }}">@lang('app.aboutus') </a></li>
			<?php /*?>@foreach(menucatads() as $catname)
          <li aria-haspopup="true"><a href="#">{{ $catname['name_en'] }}</a></li> 
			@endforeach  <?php */?>        
          <li aria-haspopup="true"><a href="{{ route('categories', app()->getLocale()) }}">@lang('app.categories') </span></a> </li>
          <li aria-haspopup="true"><a href="{{ route('news', app()->getLocale()) }}">@lang('app.news')</a></li>
          <li aria-haspopup="true"><a href="{{ route('faq', app()->getLocale()) }}">@lang('app.faq')</a></li>
          <li aria-haspopup="true"><a href="{{ route('contact', app()->getLocale()) }}"> @lang('app.contact_us') <span class="wsarrow"></span></a></li>
          <li aria-haspopup="true" class="d-lg-none mt-5 pb-5 mt-lg-0"> <span><a class="btn btn-orange" href="{{ route('createad', app()->getLocale()) }}"> @lang('app.post_free_ad')</a></span> </li>
        </ul>
        <ul class="mb-0">
          <li aria-haspopup="true" class="mt-5 d-none d-lg-block "> <span><a class="btn btn-orange ad-post " href="{{ route('createad', app()->getLocale()) }}">@lang('app.post_free_ad')</a></span> </li>
        </ul>
      </nav>
      <!--Nav--> 
    </div>
  </div>
</div>
<?php /*?>DI CODE - End<?php */?>
<!--DI CODE - Start-->
<!--Breadcrumb-->

<section>
  <div class="bannerimg cover-image bg-background3" data-image-src="{{ asset('images/banners/banner2.jpg') }}">
    <div class="header-text mb-0">
      <div class="container">
        <div class="text-center text-white">
          <h1 class="" id="breadcrumb_title">{{ $titles['title'] }}</h1>
          <ol class="breadcrumb text-center">
            <li class="breadcrumb-item"><a href="{{ route('home', app()->getLocale()) }}">@lang('app.home')</a></li>
			  @if( isset($titles['breadcrumbs']))
            <li class="breadcrumb-item">{!! $titles['breadcrumbs'] !!}</li>
			  @endif
            <li class="breadcrumb-item active text-white" id="breadcrumb_title" aria-current="page">{{ $titles['title'] }}</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Breadcrumb--> 
<!--DI CODE - End-->
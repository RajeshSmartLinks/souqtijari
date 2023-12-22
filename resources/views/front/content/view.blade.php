<!--DI CODE - Start-->
@extends('layouts.app')

@section('content') 

@include('layouts.partials.front.breadcrumbs') 

@if($data['slug'] == 'about-us')
<!--section-->
<section class="sptb">
  <div class="container">
    <div class="text-justify">
		{!! $data['description'] !!}
    </div>
  </div>
</section>
<!--/section--> 

<!--How it work's-->
<section class="sptb bg-white">
  <div class="container">
    <div class="section-title center-block text-center">
      <h2>@lang('app.how_it_works')</h2>
    </div>
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="">
          <div class="mb-lg-0 mb-4">
            <div class="service-card text-center">
              <div class="bg-purple-transparent icon-bg box-shadow icon-service  about"> <!--<img src="{{ asset('images/products/about/employees.png') }}" alt="img">--><i class="fa fa-address-book" aria-hidden="true"></i></div>
              <div class="servic-data mt-3">
                <h4 class="font-weight-semibold mb-2">@lang('app.register')</h4>
                <p class="text-muted mb-0">@lang('app.about_register')</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="">
          <div class="mb-lg-0 mb-4">
            <div class="service-card text-center">
              <div class="bg-purple-transparent icon-bg box-shadow icon-service  about"><!-- <img src="{{ asset('images/products/about/megaphone.png') }}" alt="img">--> <i class="fa fa-search" aria-hidden="true"></i></div>
              <div class="servic-data mt-3">
                <h4 class="font-weight-semibold mb-2">@lang('app.search_ads')</h4>
                <p class="text-muted mb-0">@lang('app.about_search_ads')</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="">
          <div class="mb-sm-0 mb-4">
            <div class="service-card text-center">
              <div class="bg-purple-transparent icon-bg box-shadow icon-service  about"> <!--<img src="{{ asset('images/products/about/pencil.png') }}" alt="img">--><i class="fa fa-list-alt" aria-hidden="true"></i> </div>
              <div class="servic-data mt-3">
                <h4 class="font-weight-semibold mb-2">@lang('app.create_ads')</h4>
                <p class="text-muted mb-0">@lang('app.about_create_ads')</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="">
          <div class="">
            <div class="service-card text-center">
              <div class="bg-purple-transparent icon-bg box-shadow icon-service  about"> <!--<img src="{{ asset('images/products/about/coins.png') }}" alt="img">--> <i class="fa fa-money" aria-hidden="true"></i> </div>
              <div class="servic-data mt-3">
                <h4 class="font-weight-semibold mb-2">@lang('app.get_earnings')</h4>
                <p class="text-muted mb-0">@lang('app.about_get_earnings')</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/How it work's--> 
@endif

@if($data['slug'] != 'about-us')
<!--Add listing-->
<section class="sptb">
  <div class="container">
    <div class="row">
      <div class="d-block mx-auto col-lg-8 col-md-12">
        <div class="card">
          <div class="card-body">
			  @if(!empty($data['image']))
            <div class="item7-card-img"> <img src="{{$data['image']}}" alt="img" class="w-100"><!--<img src="{{ asset('images/photos/18.jpg') }}" alt="img" class="w-100">-->
              <!--<div class="item7-card-text"> <span class="badge badge-info">Jobs</span> </div>-->
            </div>
			  @endif
			  @if($data['created'])
            <div class="item7-card-desc d-flex mb-2 mt-3"> <a href="#"><i class="fa fa-calendar-o text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2"></i>{{$data['created']}}</a> <!--<a href="#"><i class="fa fa-user text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2"></i>Nissy Sten</a>-->
              <!--<div class="ml-auto"> <a href="#"><i class="fa fa-comment-o text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2"></i>2 Comments</a> </div>-->
            </div>
			  @endif
            <a href="#" class="text-dark">
            <h2 class="font-weight-semibold">{{$data['title']}}</h2>
            </a>
            {!! $data['description'] !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/Add listing-->



@endif

@endsection 
<!--DI CODE - End-->
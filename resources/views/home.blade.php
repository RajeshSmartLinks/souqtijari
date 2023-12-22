<!--DI CODE - Start-->
@extends('layouts.app')

@section('content')

<!--Banner-->
<section>
<?php /*?><div class="bannerimg cover-image"data-image-src="{{ asset('images/banners/banner2.jpg') }}"><?php */?>
<?php /*?><div class="bannerimg cover-image"data-image-src="{{ asset('images/banners/Kuwait-City-at-night-panorama.jpg') }}"><?php */?>
<div class="bannerimg cover-image"data-image-src="{{ asset('images/banners/Kuwait-City-1.jpg') }}">
<?php /*?><div class="bannerimg cover-image"data-image-src="{{ asset('images/banners/Kuwait-City-2.jpg') }}"><?php */?>
<div class="header-text mb-0">
  <div class="container">
    <div class="row mt-5">
      <div class="col-12 col-md-12 col-lg-12 col-xl-12">
        <div class="row">
			
			<div id="myCarousel2" class="owl-carousel owl-carousel-icons6"> 
			  <!-- Wrapper for carousel items -->
			  @foreach($data['sliders'] as $sliders)
			  <div class="item">
				<div class="card mb-0">
					<div class="item7-card-img "> <a href="{{ $sliders['detail_url'] }}"></a><img src="{{ $sliders['image'] }}" alt="img" class="cover-image"> </div>
				</div>
			  </div>
			  @endforeach
			</div>
			
          <?php /*?><div class="col-sm-12 col-lg-4 col-md-4 ">
            <div class="item-card overflow-hidden"> <a href="#">
              <div class="item-card-desc-banner">
                <div class="card text-center overflow-hidden">
                  <div class="card-img"> <img src="{{ asset('images/placeholder/420x150-1.png') }}" alt="img" class="cover-image"> </div>
                  <div class="item-card-text"> </div>
                </div>
              </div>
              </a> </div>
          </div>
          <div class="col-sm-12 col-lg-4 col-md-4 ">
            <div class="item-card overflow-hidden"> <a href="#">
              <div class="item-card-desc-banner">
                <div class="card text-center overflow-hidden">
                  <div class="card-img"> <img src="{{ asset('images/placeholder/420x150-2.png') }}" alt="img" class="cover-image"> </div>
                  <div class="item-card-text"> </div>
                </div>
              </div>
              </a> </div>
          </div>
          <div class="col-sm-12 col-lg-4 col-md-4 ">
            <div class="item-card overflow-hidden"> <a href="#">
              <div class="item-card-desc-banner">
                <div class="card text-center overflow-hidden">
                  <div class="card-img"> <img src="{{ asset('images/placeholder/420x150-3.png') }}" alt="img" class="cover-image"> </div>
                  <div class="item-card-text"> </div>
                </div>
              </div>
              </a> </div>
          </div><?php */?>
			
        </div>
      </div>
    </div>	  
	
    <div class="row">
      <div class="col-xl-8 col-lg-12 col-md-12 d-block mx-auto">
        <div class="item-search-tabs">
			<div class="text-center text-white ">
				<h2 class="">@lang('app.home_desired_ads')</h2>
			</div>
          <div class="tab-content index-search-select">
            <div class="tab-pane active" id="index1">
              <div class=" search-background">
				  <form name="home_search" id="home_search">
                <div class="form row no-gutters">
                  <div class="form-group col-xl-6 col-lg-5 col-md-12 mb-0">
                    <input type="text" name="search_text" id="search_text" class="form-control border"  placeholder="@lang('app.search')">
                  </div>
                  <div class="form-group col-xl-6 col-lg-7  col-md-12 mb-0 location">
                    <div class="row no-gutters bg-white br-2">
                      <div class="form-group  col-xl-8 col-lg-7 col-md-12 mb-0">
                        <select class="form-control border-bottom-0 w-100" name="catname" id="job" data-placeholder="@lang('app.select')">
						  <optgroup label="Categories">
						  <option value="">@lang('app.select')</option>
							  @foreach($data['categories'] as $categories)
						  <option value="{{$categories['slug']}}">{{$categories['name']}}</option>
							  @endforeach
						  </optgroup>
						</select>
                      </div>
                      <div class="col-xl-4 col-lg-5 col-md-12 mb-0"> <a href="#" onClick="onclicksearch()" class="btn btn-block btn-primary fs-14"><i class="fa fa-search"></i> @lang('app.search')</a> </div>
                    </div>
                  </div>
                </div>
					</form>
              </div>
            </div>            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
<!--/Banner-->
	
@if(count($data['categories']) > 0)
<!--Categories-->
<section class="sptb">
  <div class="container">
    <div class="section-title center-block text-center">
      <h2>@lang('app.categories')</h2>
      <!--<p>Mauris ut cursus nunc. Morbi eleifend, ligula at consectetur vehicula</p>-->
    </div>
    <div id="small-categories" class="owl-carousel owl-carousel-icons2">
		@foreach($data['categories'] as $category)
      <div class="item">
        <div class="card mb-0">
          <div class="card-body">
            <div class="cat-item text-center"> <a href="{{ route('ad.category.list', [app()->getLocale(),$category['slug']]) }}"></a>
              <div class="cat-img"> <img src="{{$category['image']}}" alt="{{$category['image']}}"> </div>
              <div class="cat-desc">
                <h5 class="mb-1">{{$category['name']}}</h5>
                <small class="badge badge-pill badge-primary {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2">{{$category['adsCountCategory']}}</small><span class="text-muted">@lang('app.ads_are_posted')</span> </div>
            </div>
          </div>
        </div>
      </div>
		@endforeach      
    </div>
  </div>
</section>
<!--/Categories--> 
@endif

@if(count($data['featureAds']) > 0)
<!--Featured Ads-->
<section class="sptb bg-white">
  <div class="container">
    <div class="section-title center-block text-center">
      <h2>@lang('app.featuredads')</h2>
      <!--<p>Mauris ut cursus nunc. Morbi eleifend, ligula at consectetur vehicula</p>-->
    </div>
    <div id="myCarousel2" class="owl-carousel owl-carousel-icons2"> 
      <!-- Wrapper for carousel items -->
      @foreach($data['featureAds'] as $featuread)
      <div class="item">
        <div class="card mb-0">
          <!--<div class="arrow-ribbon bg-danger">sale</div>			
          <div class="arrow-ribbon bg-primary">sale</div>
          <div class="arrow-ribbon bg-purple">sale</div>
          <div class="arrow-ribbon bg-success">Open</div>
          <div class="arrow-ribbon bg-secondary">sale</div>-->
          <div class="item-card7-imgs"> <a href="{{ $featuread['detail_url'] }}"></a>
			  <!--<img src="{{ asset('images/products/products/b3.jpg') }}" alt="img" class="cover-image">-->
			  <img src="{{ $featuread['image'] }}" alt="img" class="cover-image"> </div>
          <div class="item-card7-overlaytext"> <!--<a href="classified.html" class="text-white"> Beauty & Spa </a>-->
            <h4  class="mb-0">@lang('app.kd') {{$featuread['price']}}</h4>
          </div>
          <div class="card-body">
            <div class="item-card7-desc">
              <div class="item-card7-text"> <a href="{{ $featuread['detail_url'] }}" class="text-dark">
                <h4 class="" title="{{$featuread['name']}}">{{ Str::limit($featuread['name'], 20) }}</h4>
                </a> </div>
              <ul class="item-cards7-ic mb-0">
                <li><a href="#"><span class="text-muted"><i class="icon icon-eye {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{$featuread['views']}} @lang('app.views')</span></a></li>
                <li>
					@if($featuread['location'])
					<a href="#" class="icons"><i class="icon icon-location-pin text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{ $featuread['location'] }}</a>
					@else
					&nbsp;
					@endif
				</li>
				
                <li><a href="#" class="icons"><i class="icon icon-event text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{$featuread['createddate']}}</a></li>
                <li><a href="#" class="icons"><i class="icon icon-phone text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{ $featuread['user_mobile'] }}</a></li>
              </ul>
				@if($featuread['description'])
              <p class="mb-0">{{ $featuread['description'] }}</p>
				@endif
            </div>
          </div>
          <div class="card-footer">
            <div class="footerimg d-flex mt-0 mb-0">
              <div class="d-flex footerimg-l mb-0"> 
				  <!--<img src="{{ asset('images/faces/female/17.jpg') }}" alt="image" class="avatar brround  {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2">-->
				  <img src="{{ $featuread['user_avatar'] }}" alt="image" class="avatar brround  {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2">
                <h5 class="time-title text-muted p-0 leading-normal mt-2 mb-0">{{ $featuread['user_name'] }}<i class="icon icon-check text-success fs-12 ml-1" data-toggle="tooltip" data-placement="top" title="verified"></i></h5>
              </div>
              <!--<div class="mt-2 footerimg-r {{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-auto"> <a href="#" class="text-pink" data-toggle="tooltip" data-placement="top" title="Remove from Wishlist"><i class="fa fa-heart"></i></a> </div>-->
            </div>
          </div>
        </div>
      </div>
	  @endforeach
    </div>
	  <div class="row">
		  <a href="{{ route('ad.category.list', app()->getLocale()) }}" class="btn btn-primary  center-block text-center mt-5">@lang('app.view_all')</a> 
	  </div>
  </div>
</section>
<!--/Featured Ads--> 
@endif
	
<?php /*?>@if(count($data['latestAds']) > 0)
<!--Latest Ads-->
<section class="sptb bg-white">
  <div class="container">
    <div class="section-title center-block text-center">
      <h2>@lang('app.latestads')</h2>
      <!--<p>Mauris ut cursus nunc. Morbi eleifend, ligula at consectetur vehicula</p>-->
    </div>
    <div id="myCarousel1" class="owl-carousel owl-carousel-icons2">		
		@foreach($data['latestAds'] as $latestad)
      <div class="item">
        <div class="card mb-0">
          <!--<div class="power-ribbon power-ribbon-top-left text-warning"><span class="bg-warning"><i class="fa fa-bolt"></i></span> </div>-->
			@if($latestad['featured'])
          <div class="ribbon ribbon-top-left text-primary"><span class="bg-primary">Featured</span></div>
			@endif
          <div class="item-card2-img"> <a href="{{ $latestad['detail_url'] }}"></a> 
			  <!--<img src="{{ asset('images/products/products/f1.jpg') }}" alt="img" class="cover-image">-->
			  <img src="{{ $latestad['image'] }}" alt="img" class="cover-image">
		  </div>
          <div class="item-card2-icons"> <!--<a href="classified.html" class="item-card2-icons-l bg-primary"> <i class="fa fa-cutlery"></i></a>--> 
			  @guest
			  <a href="#" class="item-card2-icons-r bg-secondary"><i class="fa fa fa-heart-o"></i></a>
			  @endguest
			  @auth
			  <a href="javascript:" onClick="onclickfavourite({{ $latestad['id'] }})" id="classfavourite_{{ $latestad['id'] }}" class="{{ $latestad['favourite'] == 'Favourite' ? 'item-card2-icons-r bg-primary' : 'item-card2-icons-r bg-secondary' }}"><i class="fa fa fa-heart-o"></i></a>
			  @endauth			
		  </div>
          <div class="card-body pb-0">
            <div class="item-card2">
              <div class="item-card2-desc">
                <div class="item-card2-text"> <a href="{{ $latestad['detail_url'] }}" class="text-dark">
                  <h4 class="mb-0">{{$latestad['name']}}</h4>
                  </a> </div>
                <div class="d-flex"> 
					@if($latestad['location'])
					<a href="#"><p class="pb-0 pt-0 mb-2 mt-2"><i class="fa fa-map-marker text-danger {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2"></i>{{$latestad['location']}}</p></a>
					@endif
					<span class="{{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-3 pb-0 pt-0 mb-2 mt-2">@lang('app.kd') {{$latestad['price']}}</span>
				</div>
				  @if($latestad['description'])
                <p class="">{{$latestad['description']}}</p>
				  @endif
              </div>
            </div>
          </div>
         
        </div>
      </div>
		@endforeach 
    </div>
	  <div class="row">
		  <a href="{{ route('ad.category.list', app()->getLocale()) }}" class="btn btn-primary  center-block text-center mt-5">@lang('app.view_all')</a> 
	  </div>
  </div>
</section>
<!--Latest Ads--> 
@endif<?php */?>
	
@if(count($data['latestAds']) > 0)
<!--Latest Ads-->
<section class="sptb bg-patterns">
  <div class="container">
    <div class="section-title center-block text-center">
      <h2>@lang('app.latestads')</h2>
      <!--<p>Mauris ut cursus nunc. Morbi eleifend, ligula at consectetur vehicula</p>-->
    </div>
    <div id="myCarousel2" class="owl-carousel owl-carousel-icons2"> 
      <!-- Wrapper for carousel items -->
      @foreach($data['latestAds'] as $latestad)
      <div class="item">
        <div class="card mb-0">
          <!--<div class="arrow-ribbon bg-danger">sale</div>			
          <div class="arrow-ribbon bg-primary">sale</div>
          <div class="arrow-ribbon bg-purple">sale</div>
          <div class="arrow-ribbon bg-success">Open</div>
          <div class="arrow-ribbon bg-secondary">sale</div>-->
          <div class="item-card7-imgs"> <a href="{{ $latestad['detail_url'] }}"></a>
			  <!--<img src="{{ asset('images/products/products/b3.jpg') }}" alt="img" class="cover-image">-->
			  <img src="{{ $latestad['image'] }}" alt="img" class="cover-image"> </div>
          <div class="item-card7-overlaytext"> <!--<a href="classified.html" class="text-white"> Beauty & Spa </a>-->
            <h4  class="mb-0">@lang('app.kd') {{$latestad['price']}}</h4>
          </div>
          <div class="card-body">
            <div class="item-card7-desc">
              <div class="item-card7-text"> <a href="{{ $latestad['detail_url'] }}" class="text-dark">
                <h4 class="" title="{{$latestad['name']}} ">{{ Str::limit($latestad['name'], 20) }}</h4>
                </a> </div>
              <ul class="item-cards7-ic mb-0">
                <li><a href="#"><span class="text-muted"><i class="icon icon-eye {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{$latestad['views']}} @lang('app.views')</span></a></li>
                <li>
					@if($latestad['location'])
					<a href="#" class="icons"><i class="icon icon-location-pin text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{ $latestad['location'] }}</a>
					@else
					&nbsp;
					@endif
				</li>
				
                <li><a href="#" class="icons"><i class="icon icon-event text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{$latestad['createddate']}}</a></li>
                <li><a href="#" class="icons"><i class="icon icon-phone text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{ $latestad['user_mobile'] }}</a></li>
              </ul>
				@if($latestad['description'])
              <p class="mb-0">{{ $latestad['description'] }}</p>
				@endif
            </div>
          </div>
          <div class="card-footer">
            <div class="footerimg d-flex mt-0 mb-0">
              <div class="d-flex footerimg-l mb-0"> 
				  <!--<img src="{{ asset('images/faces/female/17.jpg') }}" alt="image" class="avatar brround  {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2">-->
				  <img src="{{ $latestad['user_avatar'] }}" alt="image" class="avatar brround  {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2">
                <h5 class="time-title text-muted p-0 leading-normal mt-2 mb-0">{{ $latestad['user_name'] }}<i class="icon icon-check text-success fs-12 ml-1" data-toggle="tooltip" data-placement="top" title="verified"></i></h5>
              </div>
              <!--<div class="mt-2 footerimg-r {{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-auto"> <a href="#" class="text-pink" data-toggle="tooltip" data-placement="top" title="Remove from Wishlist"><i class="fa fa-heart"></i></a> </div>-->
            </div>
          </div>
        </div>
      </div>
	  @endforeach
    </div>
	  <div class="row">
		  <a href="{{ route('ad.category.list', app()->getLocale()) }}" class="btn btn-primary  center-block text-center mt-5">@lang('app.view_all')</a> 
	  </div>
  </div>
</section>
<!--/Latest Ads--> 
@endif	

@if(count($data['priorityAds']) > 0)
<!--Recommended/Priority Ads-->
<section class="sptb bg-white">
  <div class="container">
    <div class="section-title center-block text-center">
      <h2>@lang('app.recommendedads')</h2>
      <!--<p>Mauris ut cursus nunc. Morbi eleifend, ligula at consectetur vehicula</p>-->
    </div>
    <div id="myCarousel2" class="owl-carousel owl-carousel-icons2"> 
      <!-- Wrapper for carousel items -->
      @foreach($data['priorityAds'] as $priorityAd)
      <div class="item">
        <div class="card mb-0">
          <!--<div class="arrow-ribbon bg-danger">sale</div>			
          <div class="arrow-ribbon bg-primary">sale</div>
          <div class="arrow-ribbon bg-purple">sale</div>
          <div class="arrow-ribbon bg-success">Open</div>
          <div class="arrow-ribbon bg-secondary">sale</div>-->
          <div class="item-card7-imgs"> <a href="{{ $priorityAd['detail_url'] }}"></a>
			  <!--<img src="{{ asset('images/products/products/b3.jpg') }}" alt="img" class="cover-image">-->
			  <img src="{{ $priorityAd['image'] }}" alt="img" class="cover-image"> </div>
          <div class="item-card7-overlaytext"> <!--<a href="classified.html" class="text-white"> Beauty & Spa </a>-->
            <h4  class="mb-0">@lang('app.kd') {{$priorityAd['price']}}</h4>
          </div>
          <div class="card-body">
            <div class="item-card7-desc">
              <div class="item-card7-text"> <a href="{{ $priorityAd['detail_url'] }}" class="text-dark">
                <h4 class="" title="{{$priorityAd['name']}}">{{ Str::limit($priorityAd['name'], 20) }}</h4>
                </a> </div>
              <ul class="item-cards7-ic mb-0">
                <li><a href="#"><span class="text-muted"><i class="icon icon-eye {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{$priorityAd['views']}} @lang('app.views')</span></a></li>
                <li>
					@if($priorityAd['location'])
					<a href="#" class="icons"><i class="icon icon-location-pin text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{ $priorityAd['location'] }}</a>
					@else
					&nbsp;
					@endif
				</li>
				
                <li><a href="#" class="icons"><i class="icon icon-event text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{$priorityAd['createddate']}}</a></li>
                <li><a href="#" class="icons"><i class="icon icon-phone text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{ $priorityAd['user_mobile'] }}</a></li>
              </ul>
				@if($priorityAd['description'])
              <p class="mb-0">{{ $priorityAd['description'] }}</p>
				@endif
            </div>
          </div>
          <div class="card-footer">
            <div class="footerimg d-flex mt-0 mb-0">
              <div class="d-flex footerimg-l mb-0"> 
				  <!--<img src="{{ asset('images/faces/female/17.jpg') }}" alt="image" class="avatar brround  {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2">-->
				  <img src="{{ $priorityAd['user_avatar'] }}" alt="image" class="avatar brround  {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2">
                <h5 class="time-title text-muted p-0 leading-normal mt-2 mb-0">{{ $priorityAd['user_name'] }}<i class="icon icon-check text-success fs-12 ml-1" data-toggle="tooltip" data-placement="top" title="verified"></i></h5>
              </div>
              <!--<div class="mt-2 footerimg-r {{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-auto"> <a href="#" class="text-pink" data-toggle="tooltip" data-placement="top" title="Remove from Wishlist"><i class="fa fa-heart"></i></a> </div>-->
            </div>
          </div>
        </div>
      </div>
	  @endforeach
    </div>
	  <div class="row">
		  <a href="{{ route('ad.category.list', app()->getLocale()) }}" class="btn btn-primary  center-block text-center mt-5">@lang('app.view_all')</a> 
	  </div>
  </div>
</section>
<!--/Recommended/Priority Ads--> 
@endif
	
@if(count($data['locations']) > 0)
<!--Ads by Location-->
<section class="sptb bg-patterns">
  <div class="container">
    <div class="section-title center-block text-center">
      <h2>@lang('app.ads_by_location')</h2>
      <!--<p>Mauris ut cursus nunc. Morbi eleifend, ligula at consectetur vehicula</p>-->
    </div>
    <div class="row">
      <div class="col-12 col-md-12 col-lg-12 col-xl-12">
        <div class="row">
			@foreach($data['locations'] as $locations)			
          <div class="col-sm-12 col-lg-4 col-md-4 ">
            <div class="item-card overflow-hidden">
				<a href="{{ route('ad.location.list', [app()->getLocale(),$locations['slug']]) }}">
              <div class="item-card-desc">				  
                <div class="card text-center overflow-hidden">
                  <div class="card-img"> <img src="{{ $locations['image'] }}" alt="img" class="cover-image"> </div>
                  <div class="item-card-text">
                    <h4 class="mb-0">{{ $locations['countvalue'] }}<span><i class="fa fa-map-marker {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1 text-primary"></i>{{ $locations['name'] }}</span></h4>
                  </div>
                </div>			
              </div>
				</a>
            </div>
          </div>
			@endforeach
         <?php /*?> <div class="col-sm-12 col-lg-6 col-md-6 ">
            <div class="item-card overflow-hidden">
              <div class="item-card-desc">
                <div class="card text-center overflow-hidden">
                  <div class="card-img"> <img src="{{asset('images/locations/london.jpg') }}" alt="img" class="cover-image"> </div>
                  <div class="item-card-text">
                    <h4 class="mb-0">52,145<span><i class="fa fa-map-marker {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1 text-primary"></i> LONDON</span></h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-lg-6 col-md-6 ">
            <div class="item-card overflow-hidden">
              <div class="item-card-desc">
                <div class="card text-center overflow-hidden">
                  <div class="card-img"> <img src="{{asset('images/locations/austerlia.jpg') }}" alt="img" class="cover-image"> </div>
                  <div class="item-card-text">
                    <h4 class="mb-0">63,263<span><i class="fa fa-map-marker text-primary {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i>AUSTERLIA</span></h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-lg-6 col-md-6 ">
            <div class="item-card overflow-hidden">
              <div class="item-card-desc">
                <div class="card text-center overflow-hidden">
                  <div class="card-img"> <img src="{{asset('images/locations/chicago.jpg') }}" alt="img" class="cover-image"> </div>
                  <div class="item-card-text">
                    <h4 class="mb-0">36,485<span><i class="fa fa-map-marker text-primary {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i>CHICAGO</span></h4>
                  </div>
                </div>
              </div>
            </div>
          </div><?php */?>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Ads by Location-->
@endif

<?php /*?>@if(count($data['news']) > 0 )
<!--Latest News-->
<section class="sptb bg-white">
  <div class="container">
    <div class="col-md-12">
      <div class="items-gallery">
        <div class="items-blog-tab text-center">
          <h2 class="">Latest News</h2>
          <div class="tab-content">			  
            <div class="tab-pane active" id="tab-1">
              <div class="row">
				  @foreach($data['news'] as $news)
				  
                <div class="col-xl-4 col-lg-4 col-md-12">
                  <div class="card mb-xl-0"><!-- <span class="ribbon-1"> <span><i class="fa fa-cutlery"></i></span> </span>-->
					  <a href="{{route('news.detail', [app()->getLocale(), $news['slug']] ) }}">
                    <div class="item-card8-img  br-tr-7 br-tl-7"> <img src="{{$news['image']}}" alt="img" class="cover-image"> </div>
					  </a>
                    <!--<div class="item-card8-overlaytext">
                      <h6 class=" fs-20 mb-0">Restaurants</h6>
                    </div>-->
                    <div class="card-body">
                      <div class="item-card8-desc">
                        <p class="text-muted"><i class="fa fa-calendar-o text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2"></i>{{$news['date']}}</p>
						  <a href="{{route('news.detail', [app()->getLocale(), $news['slug']] ) }}">
                        <h4 class="font-weight-semibold">{{$news['name']}}</h4>
						  </a>
                        <p class="mb-0">{{$news['description']}}</p>
                      </div>
                    </div>
                  </div>
                </div>
				  @endforeach
				  <a href="{{ route('news', app()->getLocale()) }}" class="btn btn-primary  center-block text-center mt-5">Read More</a> 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/Latest News--> 
@endif<?php */?>
	
@if(count($data['news']) > 0)
<!--Latest News-->
<section class="sptb bg-white">
  <div class="container">
    <div class="section-title center-block text-center">
      <h2>@lang('app.latestnews')</h2>
      <!--<p>Mauris ut cursus nunc. Morbi eleifend, ligula at consectetur vehicula</p>-->
    </div>
    <div id="myCarousel2" class="owl-carousel owl-carousel-icons6"> 
      <!-- Wrapper for carousel items -->
      @foreach($data['news'] as $news)
      <div class="item">
        <div class="card mb-0">
			<?php /*?><div class="item-card8-imgs max_min_height250"> <a href="{{route('news.detail', [app()->getLocale(), $news['slug']] ) }}"></a><img src="{{ $news['image'] }}" alt="img" class="cover-image"></div><?php */?>
			<div class="item7-card-img max_min_height250"> <a href="{{ route('news.detail', [app()->getLocale(), $news['slug']] ) }}"></a><img src="{{ $news['image'] }}" alt="img" class="cover-image"> </div>
			<?php /*?><div class="item-card7-img br-tr-7 br-tl-7"><a href={{route('news.detail', [app()->getLocale(), $news['slug']] ) }}"></a> <img src="{{$news['image']}}" alt="img" class="cover-image"> </div><?php */?>
          <div class="card-body">
            <div class="item-card7-desc">
				<p class="text-muted"><i class="fa fa-calendar-o text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2"></i>{{$news['date']}}</p>
              <div class="item-card7-text"> <a href="{{route('news.detail', [app()->getLocale(), $news['slug']] ) }}" class="text-dark"><h4 title="{{ $news['name'] }}" class="">{{ Str::limit($news['name'], 30) }}</h4> </a> </div>              
				@if($news['description'])
              <p class="mb-0">{!! $news['description'] !!}</p>
				@endif
            </div>
          </div>
        </div>
      </div>
	  @endforeach
    </div>
	  <div class="row">
		  <a href="{{ route('news', app()->getLocale()) }}" class="btn btn-primary  center-block text-center mt-5">@lang('app.read_more')</a> 
	  </div>
  </div>
</section>
<!--/Latest News--> 
@endif	
	
<!--Statistics-->
<section>
  <div class="about-1 cover-image sptb bg-background-color" data-image-src="{{asset('images/banners/banner5.jpg') }}">
    <div class="content-text mb-0 text-white info">
      <div class="container">
        <div class="row text-center">
          <div class="col-lg-3 col-md-6">
            <div class="counter-status md-mb-0">
              <div class="counter-icon"> <i class="icon icon-people"></i> </div>
              <h5>@lang('app.visitors')</h5>
              <h2 class="counter mb-0">{{ $data['total_visitors'] }}</h2>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="counter-status status-1 md-mb-0">
              <div class="counter-icon text-warning"> <i class="icon icon-rocket"></i> </div>
              <h5>@lang('app.installs')</h5>
              <h2 class="counter mb-0">1765</h2>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="counter-status status md-mb-0">
              <div class="counter-icon text-primary"> <i class="icon icon-docs"></i> </div>
              <h5>@lang('app.users')</h5>
              <h2 class="counter mb-0">{{ $data['total_users'] }}</h2>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="counter-status status">
              <div class="counter-icon text-success"> <i class="icon icon-emotsmile"></i> </div>
              <h5>@lang('app.total_ads')</h5>
              <h2 class="counter">{{ $data['total_ads'] }}</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/Statistics--> 
	
@endsection 

@section('extra-scripts')
<script>
function onclickfavourite(id)
{
	//alert(id);
	$.ajax({
		//type: "POST",
		type: "GET",
		url: '{{ route("adfavourite", app()->getLocale()) }}',
		data: {'ad_id': id}
	}).done(function (result) {
		var classname;
		if(result==" Favourite")
		{
			classname = 'item-card2-icons-r bg-primary';
		}
		else if(result==" Not Favourite")
		{
			classname = 'item-card2-icons-r bg-secondary';
		}
		$('#classfavourite_'+id).removeClass();
		$('#classfavourite_'+id).addClass(classname);
	});
}
function onclicksearch()
{
	var catval = $('#job').val();
	var searchval = $('#search_text').val();
	$.ajax({
		type: "POST",
		url: "{{route('ad.dosearch', app()->getLocale())}}",
		data: {'catname':catval, 'search_text':searchval},
		success: function (msg) {
			if (msg.status == "200") {
				//var url = '{{ route("ad.category.list", [app()->getLocale()]) }}'+'/'+catval;
				var url = '{{ route("ad.category.list", [app()->getLocale(), ":id"]) }}';
				url = url.replace(':id', catval);
				window.location.href = url;
			} else {
				$("#apply_filter").html("{{__('app.applyfilter')}}");
			}
		},
		error: function (msg) {
		}
	});

	return false;
}
</script>
@endsection
<!--DI CODE - End-->
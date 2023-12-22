<!--DI CODE - Start-->
@extends('layouts.app')

@section('content') 

@include('layouts.partials.front.breadcrumbs') 

<!--Add listing-->
<section class="sptb">
  <div class="container">
    <div class="row">
      <div class="col-xl-8 col-lg-8 col-md-12"> 
        
        <!--Classified Description-->
        <div class="card overflow-hidden">
			@if($data['ad_is_negotiable'])
          <div class="ribbon ribbon-top-right text-danger"><span class="bg-danger">@lang('app.negotiable')</span></div>
			@endif
          <div class="card-body h-100">
            <div class="item-det mb-4"> <a href="#" class="text-dark">
              <h3 >{{ $data['ad_title'] }}</h3>
              </a>
              <div class=" d-flex">
                <ul class="d-flex mb-0">
                  <!--<li class="{{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-5"><a href="#" class="icons"><i class="icon icon-briefcase text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{ $data['ad_cat'] }} » {{ $data['ad_subcat'] }}</a></li>-->
					@if($data['ad_brand'])
                  <li class="{{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-5"><a href="#" class="icons"><i class="icon icon-tag text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{ $data['ad_brand'] }}</a></li>
					@endif
                  <li class="{{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-5"><a href="#" class="icons"><i class="icon icon-location-pin text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{ $data['ad_location'] }}</a></li>
                  <li class="{{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-5"><a href="#" class="icons"><i class="icon icon-calendar text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{ $data['ad_created'] }}</a></li>
                  <li class="{{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-5"><a href="#" class="icons"><i class="icon icon-eye text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{ $data['ad_views'] }}</a></li>					
                  <li class="{{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-5"><a href="#" class="btn btn-primary btn-sm">{{ $data['ad_condition'] }}</a></li>					
                </ul>
                <?php /*?><div class="rating-stars d-flex {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-5">
                  <input type="number" readonly="readonly" class="rating-value star" name="rating-stars-value" id="rating-stars-value" value="4">
                  <div class="rating-stars-container {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2">
                    <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                    <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                    <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                    <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                    <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                  </div>
                  4.0 </div>
                <div class="rating-stars d-flex">
                  <div class="rating-stars-container {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2">
                    <div class="rating-star sm"> <i class="fa fa-heart"></i> </div>
                  </div>
                  135 </div><?php */?>
              </div>
            </div>
            <div class="product-slider">
              <div id="carousel" class="carousel slide" data-ride="carousel">
                <div class="arrow-ribbon2 bg-primary">@lang('app.kd') {{ $data['ad_price'] }}</div>
                <div class="carousel-inner">
					@if($data['adsimages'])
					@foreach($data['adsimages'] as $k => $gallery)
                  <div class="carousel-item {{$k==0 ? 'active' : ''}}"> <img src="{{asset('uploads/ad/'.$gallery)}}" alt="img"> </div>
					@endforeach
					@else
				  <div class="carousel-item active"> <img src="{{asset('images\placeholder\noimage_single_ad.jpg')}}" alt="img"> </div>
					@endif
                </div>
				  @if($data['adsimages'])
                <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev"> <i class="fa fa-angle-left" aria-hidden="true"></i> </a> <a class="carousel-control-next" href="#carousel" role="button" data-slide="next"> <i class="fa fa-angle-right" aria-hidden="true"></i> </a>
				  @endif
			  </div>
				@if($data['adsimages'])
              <div class="clearfix">
                <div id="thumbcarousel" class="carousel slide" data-interval="false">
                  <div class="carousel-inner">
                    <div class="carousel-item active">
						@foreach($data['adsimages'] as $k => $gallery)
                      <div data-target="#carousel" data-slide-to="{{$k}}" class="thumb"><img src="{{asset('uploads/ad/medium/'.$gallery)}}" alt="img"></div>
						@endforeach
                    </div>
                    <div class="carousel-item ">
						@foreach($data['adsimages'] as $k => $gallery)
                      <div data-target="#carousel" data-slide-to="{{$k}}" class="thumb"><img src="{{asset('uploads/ad/medium/'.$gallery)}}" alt="img"></div>
						@endforeach
                    </div>
                  </div>
                  <a class="carousel-control-prev" href="#thumbcarousel" role="button" data-slide="prev"> <i class="fa fa-angle-left" aria-hidden="true"></i> </a> <a class="carousel-control-next" href="#thumbcarousel" role="button" data-slide="next"> <i class="fa fa-angle-right" aria-hidden="true"></i> </a> </div>
              </div>
				@endif
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">@lang('app.description')</h3>
          </div>
          <div class="card-body">
            <div class="mb-4">
              {!! nl2br(e($data['ad_description'])) !!}
            </div>
            <?php /*?><h4 class="mb-4">Specifications</h4>
            <div class="row">
              <div class="col-xl-12 col-md-12">
                <div class="table-responsive">
                  <table class="table row table-borderless w-100 m-0 text-nowrap ">
                    <tbody class="col-lg-12 col-xl-6 p-0">
                      <tr>
                        <td><span class="font-weight-bold">Fuel Type :</span> Diesel</td>
                      </tr>
                      <tr>
                        <td><span class="font-weight-bold">Breaks :</span> Front , Rear</td>
                      </tr>
                      <tr>
                        <td><span class="font-weight-bold">Seating :</span> 5 members</td>
                      </tr>
                      <tr>
                        <td><span class="font-weight-bold">Colors :</span> Red , pink, Gray</td>
                      </tr>
                    </tbody>
                    <tbody class="col-lg-12 col-xl-6 p-0">
                      <tr>
                        <td><span class="font-weight-bold">Air Bags :</span> Available</td>
                      </tr>
                      <tr>
                        <td><span class="font-weight-bold">Colors :</span> Red , pink, Gray</td>
                      </tr>
                      <tr>
                        <td><span class="font-weight-bold">Engine :</span> F8D </td>
                      </tr>
                      <tr>
                        <td><span class="font-weight-bold">Power Windows :</span> Available </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div><?php */?>
          </div>
          <?php /*?><div class="pt-4 pb-4 pl-5 pr-5 border-top border-top">
            <div class="list-id">
              <div class="row">
                <div class="col"> <a class="mb-0">Classified ID : #8256358</a> </div>
                <div class="col col-auto"> Posted By <a class="mb-0 font-weight-bold">Individual</a> / 21st Dec 2018 </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="icons"> <a href="#" class="btn btn-info icons"><i class="icon icon-share {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> Share Ad</a> <a href="#" class="btn btn-primary icons"><i class="icon icon-heart  {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> 678</a> <a href="#" class="btn btn-secondary icons"><i class="icon icon-printer  {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> Print</a> </div>
          </div><?php */?>
        </div>
        <!--/Classified Description-->
        
        <h3 class="mb-5 mt-4">@lang('app.related_ads')</h3>
        
        <!--Related Posts-->
		  @if(count($data['related_ads']))
        <div id="myCarousel5" class="owl-carousel owl-carousel-icons3"> 
          <!-- Wrapper for carousel items -->
          @foreach($data['related_ads'] as $related)
          <div class="item">
            <div class="card">
				@if($related['ad_is_featured'])
              <div class="ribbon ribbon-top-left text-primary"><span class="bg-primary">@lang('app.featured')</span></div>
				@endif
              <div class="item-card7-imgs max_min_height200"> <a href="{{ $related['detail_url'] }}"></a> <img src="{{ $related['ad_image'] }}" alt="img" class="cover-image"> </div>
              <div class="item-card7-overlaytext"> <!--<a href="classified.html" class="text-white"> Education</a>-->
                <h4  class="font-weight-semibold mb-0">@lang('app.kd') {{ $related['ad_price'] }}</h4>
              </div>
              <div class="card-body">
                <div class="item-card7-desc"> <a href="{{$related['detail_url']}}" class="text-dark">
                  <h4 class="font-weight-semibold">{{ $related['ad_title'] }}</h4>
                  </a> </div>
                <div class="item-card7-text">
                  <ul class="icon-card mb-0">
                    <li ><a href="#" class="icons"><i class="icon icon-location-pin text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{ $related['ad_location'] }}</a></li>
                    <li><a href="#" class="icons"><i class="icon icon-event text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{ $related['ad_created'] }}</a></li>
                    <li class="mb-0"><a href="#" class="icons"><i class="icon icon-user text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{ $related['ad_username'] }}</a></li>
                    <li class="mb-0"><a href="#" class="icons"><i class="icon icon-phone text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{ $related['ad_usermobile'] }}</a></li>
                  </ul>
                  <p class="mb-0">{{ $related['ad_description'] }}</p>
                </div>
              </div>
            </div>
          </div>
			@endforeach
        </div>
		  @endif
        <!--/Related Posts--> 
        
        <!--Comments-->
        <?php /*?><div class="card">
          <div class="card-header">
            <h3 class="card-title">Rating And Reviews</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="mb-4">
                  <p class="mb-2"> <span class="fs-14 {{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-2"><i class="fa fa-star text-yellow {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2"></i>5</span> </p>
                  <div class="progress progress-md mb-4 h-4">
                    <div class="progress-bar bg-success w-100">9,232</div>
                  </div>
                </div>
                <div class="mb-4">
                  <p class="mb-2"> <span class="fs-14 {{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-2"><i class="fa fa-star text-yellow {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2"></i>4</span> </p>
                  <div class="progress progress-md mb-4 h-4">
                    <div class="progress-bar bg-info w-80">8,125</div>
                  </div>
                </div>
                <div class="mb-4">
                  <p class="mb-2"> <span class="fs-14 {{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-2"><i class="fa fa-star text-yellow {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2"></i> 3</span> </p>
                  <div class="progress progress-md mb-4 h-4">
                    <div class="progress-bar bg-primary w-60">6,263</div>
                  </div>
                </div>
                <div class="mb-4">
                  <p class="mb-2"> <span class="fs-14 {{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-2"><i class="fa fa-star text-yellow {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2"></i> 2</span> </p>
                  <div class="progress progress-md mb-4 h-4">
                    <div class="progress-bar bg-secondary w-30">3,463</div>
                  </div>
                </div>
                <div class="mb-5">
                  <p class="mb-2"> <span class="fs-14 {{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-2"><i class="fa fa-star text-yellow {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2"></i> 1</span> </p>
                  <div class="progress progress-md mb-4 h-4">
                    <div class="progress-bar bg-orange w-20">1,456</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="media mt-0 p-5">
              <div class="d-flex {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-3"> <a href="#"><img class="media-object brround" alt="64x64" src="{{ asset('images/faces/male/1.jpg') }}"> </a> </div>
              <div class="media-body">
                <h5 class="mt-0 mb-1 font-weight-semibold">Joanne Scott <span class="fs-14 {{app()->getLocale() == 'en' ? 'ml-0' : 'mr-2'}}" data-toggle="tooltip" data-placement="top" title="verified"><i class="fa fa-check-circle-o text-success"></i></span> <span class="fs-14 {{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-2"> 4.5 <i class="fa fa-star text-yellow {{app()->getLocale() == 'en' ? '' : 'float-right ml-1'}}"></i></span> </h5>
                <small class="text-muted"><i class="fa fa-calendar {{app()->getLocale() == 'en' ? '' : 'mr-3 ml-1'}}"></i> Dec 21st <i class=" {{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-3 fa fa-clock-o"></i> 13.00 <i class=" {{app()->getLocale() == 'en' ? 'ml-3' : 'float-right mr-1 ml-1'}} fa fa-map-marker"></i> Brezil</small>
                <p class="font-13  mb-2 mt-2"> Ut enim ad minim veniam, quis Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et  nostrud exercitation ullamco laboris   commodo consequat. </p>
                <a href="#" class="{{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2"><span class="badge badge-primary">Helpful</span></a> <a href="" class="{{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2" data-toggle="modal" data-target="#Comment"><span >Comment</span></a> <a href="" class="{{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2" data-toggle="modal" data-target="#report"><span >Report</span></a>
                <div class="media mt-5">
                  <div class="d-flex mr-3"> <a href="#"> <img class="media-object brround" alt="64x64" src="{{ asset('images/faces/female/2.jpg') }}"> </a> </div>
                  <div class="media-body">
                    <h5 class="mt-0 mb-1 font-weight-semibold">Rose Slater <span class="fs-14 ml-0" data-toggle="tooltip" data-placement="top" title="verified"><i class="fa fa-check-circle-o text-success"></i></span></h5>
                    <small class="text-muted"><i class="fa fa-calendar"></i> Dec 22st <i class=" ml-3 fa fa-clock-o"></i> 6.00 <i class=" ml-3 fa fa-map-marker"></i> Brezil</small>
                    <p class="font-13  mb-2 mt-2"> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris   commodo Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur consequat. </p>
                    <a href="" data-toggle="modal" data-target="#Comment"><span class="badge badge-default">Comment</span></a> </div>
                </div>
              </div>
            </div>
            <div class="media p-5 border-top mt-0">
              <div class="d-flex mr-3"> <a href="#"> <img class="media-object brround" alt="64x64" src="{{ asset('images/faces/male/3.jpg') }}"> </a> </div>
              <div class="media-body">
                <h5 class="mt-0 mb-1 font-weight-semibold">Edward <span class="fs-14 ml-0" data-toggle="tooltip" data-placement="top" title="verified"><i class="fa fa-check-circle-o text-success"></i></span> <span class="fs-14 ml-2"> 4 <i class="fa fa-star text-yellow"></i></span> </h5>
                <small class="text-muted"><i class="fa fa-calendar"></i> Dec 21st <i class=" ml-3 fa fa-clock-o"></i> 16.35 <i class=" ml-3 fa fa-map-marker"></i> UK</small>
                <p class="font-13  mb-2 mt-2"> Ut enim ad minim veniam, quis Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et  nostrud exercitation ullamco laboris   commodo consequat. </p>
                <a href="#" class="mr-2"><span class="badge badge-primary">Helpful</span></a> <a href="" class="mr-2" data-toggle="modal" data-target="#Comment"><span >Comment</span></a> <a href="" class="mr-2" data-toggle="modal" data-target="#report"><span >Report</span></a> </div>
            </div>
          </div>
        </div><?php */?>
        <!--/Comments-->
        <?php /*?><div class="card mb-lg-0">
          <div class="card-header">
            <h3 class="card-title">Leave a reply</h3>
          </div>
          <div class="card-body">
            <div>
              <div class="form-group">
                <input type="text" class="form-control" id="name1" placeholder="Your Name">
              </div>
              <div class="form-group">
                <input type="email" class="form-control" id="email" placeholder="Email Address">
              </div>
              <div class="form-group">
                <textarea class="form-control" name="example-textarea-input" rows="6" placeholder="Comment"></textarea>
              </div>
              <a href="#" class="btn btn-primary">Send Reply</a> </div>
          </div>
        </div><?php */?>
      </div>
      
      <!--Right Side Content-->
      <div class="col-xl-4 col-lg-4 col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">@lang('app.contact_info')</h3>
          </div>
          <div class="card-body  item-user">
            <div class="profile-pic mb-0"> <!--<img src="{{ asset('images/faces/male/25.jpg') }}" class="brround avatar-xxl" alt="user">--><img src="{{ $data['ad_user_avatar'] }}" class="brround avatar-xxl" alt="user">
              <div > <a href="userprofile.html" class="text-dark">
                <h4 class="mt-3 mb-1 font-weight-semibold">{{ $data['ad_seller_name'] }}</h4>
                </a> <span class="text-muted">@lang('app.member_since') {{ $data['ad_userdate'] }}</span>
                <h6 class="mt-2 mb-0"><a href="{{ $data['user_url'] }}" class="btn btn-primary btn-sm">@lang('app.see_all_ads')</a></h6>
              </div>
            </div>
          </div>
          <div class="card-body item-user">
            <!--<h4 class="mb-4"></h4>-->
            <div>
              <h6><span class="font-weight-semibold"><i class="fa fa-envelope {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-3 mb-2"></i></span><a href="mailto:{{ $data['ad_seller_email'] }}" class="text-body"> {{ $data['ad_seller_email'] }}</a></h6>
              <h6><span class="font-weight-semibold"><i class="fa fa-phone {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-3  mb-2"></i></span><a href="tel:965{{$data['ad_seller_phone']}}" id="show_phone" class="text-primary"> <?PHP echo substr($data['ad_seller_phone'], 0, 2) . str_repeat("*", strlen($data['ad_seller_phone'])-2); ?></a> <a href="javascript:" id="hide_show" onClick="fun_showphone()">@lang('app.show_phone')</a></h6>
				@if($data['ad_seller_address'])
              <h6><span class="font-weight-semibold"><i class="fa fa-link {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-3 "></i></span>{{ $data['ad_seller_address'] }}</h6>
				@endif
            </div>
			  @if($data['ad_user_facebook'] || $data['ad_user_twitter'])
            <div class=" item-user-icons mt-4">
				@if($data['ad_user_facebook'])
				<a href="#" class="facebook-bg mt-0"><i class="fa fa-facebook"></i></a>
				@endif
				@if($data['ad_user_twitter'])
				<a href="#" class="twitter-bg"><i class="fa fa-twitter"></i></a>
				@endif
				<?php /*?><a href="#" class="google-bg"><i class="fa fa-google"></i></a> <a href="#" class="dribbble-bg"><i class="fa fa-dribbble"></i></a> <?php */?>
			</div>
			  @endif
          </div>			
          <div class="card-footer">
            <div class="text-{{app()->getLocale() == 'en' ? 'left' : 'right'}}">
				@guest
				<a href="#" class="btn btn-grey icons" data-toggle="modal" data-target="#exampleModal" data-original-title="Add to Favourites"><i class="icon icon-heart"></i></a>				
				@endguest
				@auth
				<a href="javascript:" onClick="onclickfavourite({{ $data['ad_id'] }})" id="classfavourite_{{ $data['ad_id'] }}" class="{{ $data['favourite'] == 'Favourite' ? 'btn btn-primary icons' : 'btn btn-grey icons' }}" data-toggle="tooltip" data-original-title="{{ $data['favourite'] == 'Favourite' ? 'Added to Favourites' : 'Add to Favourites' }}"><i class="icon icon-heart"></i></a>
				@endauth
				@if($data['ad_seller_whatsapp'])
				<a href="https://api.whatsapp.com/send?l=en&phone={{ $data['ad_seller_whatsapp'] }}&text=HI, This message regarding '{{ $data['ad_title'] }}' {{ $data['detail_url'] }}" class="btn  btn-info"><i class="fa fa-whatsapp fa-lg"></i> @lang('app.whatsapp')</a>
				@endif
				<?php /*?><a href="tel:965{{$data['ad_seller_phone']}}" class="btn btn-primary" data-toggle="modal" data-target="#contact"><i class="fa fa-user"></i> Contact Me</a><?php */?>				
			</div>
          </div>			
        </div>
        <?php /*?><div class="card">
          <div class="card-header">
            <h3 class="card-title">Keywords</h3>
          </div>
          <div class="card-body product-filter-desc">
            <div class="product-tags clearfix">
              <ul class="list-unstyled mb-0">
                <li><a href="#">Vehicle</a></li>
                <li><a href="#">Model Cars</a></li>
                <li><a href="#">Best Car</a></li>
              </ul>
            </div>
          </div>
        </div><?php */?>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">@lang('app.shares')</h3>
          </div>
          <div class="card-body product-filter-desc">
            <div class="product-filter-icons text-center">
				<a href="https://www.facebook.com/sharer/sharer.php?u={{urlencode($data['detail_url'])}}" class="facebook-bg"><i class="fa fa-facebook"></i></a>
				<a href="https://twitter.com/intent/tweet?url={{urlencode($data['detail_url'])}}" class="twitter-bg"><i class="fa fa-twitter"></i></a>
				<?php /*?><a href="#" class="google-bg"><i class="fa fa-google"></i></a> <a href="#" class="dribbble-bg"><i class="fa fa-dribbble"></i></a> <a href="#" class="pinterest-bg"><i class="fa fa-pinterest"></i></a><?php */?> </div>
          </div>
        </div>
		<div class="card mb-0">
          <div class="card-header">
            <h3 class="card-title">{{ $data['safety_title'] }}</h3>
          </div>
          <div class="card-body">
            <ul class="list-unstyled widget-spec  mb-0">
              @if($data['safety_slug'] == 'safety-tips-for-buyers')
			  @foreach($data['safety_description'] as $safetytips)
			<li class=""> <i class="fa fa-check text-success" aria-hidden="true"></i> {!! $safetytips !!} </li>
			  @endforeach
			  @endif
               <?php /*?><li class="{{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-5 mb-0"> <a href="tips.html"> View more..</a> </li><?php */?>
            </ul>
          </div>
        </div>
        <?php /*?><div class="card">
          <div class="card-header">
            <h3 class="card-title">Map location</h3>
          </div>
          <div class="card-body">
            <div class="map-header">
              <div class="map-header-layer" id="map2"></div>
            </div>
          </div>
        </div><?php */?>
        <?php /*?><div class="card">
          <div class="card-header">
            <h3 class="card-title">Search Ads</h3>
          </div>
          <div class="card-body">
            <div class="form-group">
              <input type="text" class="form-control" id="search-text" placeholder="What are you looking for?">
            </div>
            <div class="form-group">
              <select name="country" id="select-countries" class="form-control custom-select select2-show-search">
                <option value="1" selected>All Categories</option>
                <option value="2">RealEstate</option>
                <option value="3">Restaurant</option>
                <option value="4">Beauty</option>
                <option value="5">Jobs</option>
                <option value="6">Services</option>
                <option value="7">Vehicle</option>
                <option value="8">Education</option>
                <option value="9">Electronics</option>
                <option value="10">Pets & Animals</option>
                <option value="11">Computer</option>
                <option value="12">Mobile</option>
                <option value="13">Events</option>
                <option value="14">Travel</option>
                <option value="15">Clothing</option>
              </select>
            </div>
            <div > <a href="#" class="btn  btn-primary">Search</a> </div>
          </div>
        </div><?php */?>
        <?php /*?><div class="card">
          <div class="card-header">
            <h3 class="card-title">Latest Products</h3>
          </div>
          <div class="card-body ">
            <ul class="vertical-scroll">
              <li class="news-item">
                <table>
                  <tr>
                    <td><img src="{{ asset('images/products/1.png') }}" alt="image" class="w-8 border"/></td>
                    <td><h5 class="mb-1 ">Best New Model Watch</h5>
                      <a href="#" class="btn-link">View Details</a><span class="float-{{app()->getLocale() == 'en' ? 'right' : 'left'}} font-weight-bold">$17</span></td>
                  </tr>
                </table>
              </li>
              <li class="news-item">
                <table>
                  <tr>
                    <td><img src="{{ asset('images/products/2.png') }}" alt="image" class="w-8 border"/></td>
                    <td><h5 class="mb-1 ">Trending New Model Watches</h5>
                      <a href="#" class="btn-link">View Details</a><span class="float-{{app()->getLocale() == 'en' ? 'right' : 'left'}} font-weight-bold">$17</span></td>
                  </tr>
                </table>
              </li>
              <li class="news-item">
                <table>
                  <tr>
                    <td><img src="{{ asset('images/products/3.png') }}" alt="image" class="w-8 border" /></td>
                    <td><h5 class="mb-1 ">Best New Model Watch</h5>
                      <a href="#" class="btn-link">View Details</a><span class="float-{{app()->getLocale() == 'en' ? 'right' : 'left'}} font-weight-bold">$17</span></td>
                  </tr>
                </table>
              </li>
              <li class="news-item">
                <table>
                  <tr>
                    <td><img src="{{ asset('images/products/4.png') }}" alt="image" class="w-8 border" /></td>
                    <td><h5 class="mb-1 ">Trending New Model Watches</h5>
                      <a href="#" class="btn-link">View Details</a><span class="float-{{app()->getLocale() == 'en' ? 'right' : 'left'}} font-weight-bold">$17</span></td>
                  </tr>
                </table>
              </li>
              <li class="news-item">
                <table>
                  <tr>
                    <td><img src="{{ asset('images/products/5.png') }}" alt="image" class="w-8 border" /></td>
                    <td><h5 class="mb-1 ">Best New Model Watch</h5>
                      <a href="#" class="btn-link">View Details</a><span class="float-{{app()->getLocale() == 'en' ? 'right' : 'left'}} font-weight-bold">$17</span></td>
                  </tr>
                </table>
              </li>
              <li class="news-item">
                <table>
                  <tr>
                    <td><img src="{{ asset('images/products/6.png') }}" alt="image" class="w-8 border" /></td>
                    <td><h5 class="mb-1 ">Best New Model Shoes</h5>
                      <a href="#" class="btn-link">View Details</a><span class="float-{{app()->getLocale() == 'en' ? 'right' : 'left'}} font-weight-bold">$17</span></td>
                  </tr>
                </table>
              </li>
              <li class="news-item">
                <table>
                  <tr>
                    <td><img src="{{ asset('images/products/7.png') }}" alt="image" class="w-8 border" /></td>
                    <td><h5 class="mb-1 ">Trending New Model Shoes</h5>
                      <a href="#" class="btn-link">View Details</a><span class="float-{{app()->getLocale() == 'en' ? 'right' : 'left'}} font-weight-bold">$17</span></td>
                  </tr>
                </table>
              </li>
            </ul>
          </div>
        </div><?php */?>
        <?php /*?><div class="card mb-0">
          <div class="card-header">
            <h3 class="card-title">Latest Seller Ads</h3>
          </div>
          <div class="card-body">
            <div class="rated-products">
              <ul class="vertical-scroll">
                <li class="item">
                  <div class="media m-0 mt-0 p-5"> <img class="{{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-4" src="{{ asset('images/products/toys.png') }}" alt="img">
                    <div class="media-body">
                      <h4 class="mt-2 mb-1">Kids Toys</h4>
                      <span class="rated-products-ratings"> <i class="fa fa-star text-warning"> </i> <i class="fa fa-star text-warning"> </i> <i class="fa fa-star text-warning"> </i> <i class="fa fa-star text-warning"> </i> <i class="fa fa-star text-warning"> </i> </span>
                      <div class="h5 mb-0 font-weight-semibold mt-1">$17 - $29</div>
                    </div>
                  </div>
                </li>
                <li class="item">
                  <div class="media p-5 mt-0"> <img class="{{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-4" src="{{ asset('images/products/1.png') }}" alt="img">
                    <div class="media-body">
                      <h4 class="mt-2 mb-1">Leather Watch</h4>
                      <span class="rated-products-ratings"> <i class="fa fa-star text-warning"> </i> <i class="fa fa-star text-warning"> </i> <i class="fa fa-star text-warning"> </i> <i class="fa fa-star text-warning"> </i> <i class="fa fa-star-o text-warning"> </i> </span>
                      <div class="h5 mb-0 font-weight-semibold mt-1">$22 - $45</div>
                    </div>
                  </div>
                </li>
                <li class="item">
                  <div class="media p-5 mt-0"> <img class=" {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-4" src="{{ asset('images/products/4.png') }}" alt="img">
                    <div class="media-body">
                      <h4 class="mt-2 mb-1">Digital Watch</h4>
                      <span class="rated-products-ratings"> <i class="fa fa-star text-warning"> </i> <i class="fa fa-star text-warning"> </i> <i class="fa fa-star text-warning"> </i> <i class="fa fa-star text-warning"> </i> <i class="fa fa-star-half-o text-warning"> </i> </span>
                      <div class="h5 mb-0 font-weight-semibold mt-1">$35 - $72</div>
                    </div>
                  </div>
                </li>
                <li class="item">
                  <div class="media p-5 mt-0"> <img class=" {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-4" src="{{ asset('images/products/6.png') }}" alt="img">
                    <div class="media-body">
                      <h4 class="mt-2 mb-1">Sports Shoe</h4>
                      <span class="rated-products-ratings"> <i class="fa fa-star text-warning"> </i> <i class="fa fa-star text-warning"> </i> <i class="fa fa-star text-warning"> </i> <i class="fa fa-star-half-o text-warning"> </i> <i class="fa fa-star-o text-warning"> </i> </span>
                      <div class="h5 mb-0 font-weight-semibold mt-1">$12 - $21</div>
                    </div>
                  </div>
                </li>
                <li class="item">
                  <div class="media  mb-0 p-5 mt-0"> <img class=" {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-4" src="{{ asset('images/products/8.png') }}" alt="img">
                    <div class="media-body">
                      <h4 class="mt-2 mb-1">Ladies shoes</h4>
                      <span class="rated-products-ratings"> <i class="fa fa-star text-warning"> </i> <i class="fa fa-star text-warning"> </i> <i class="fa fa-star text-warning"> </i> <i class="fa fa-star-o text-warning"> </i> <i class="fa fa-star-o text-warning"> </i> </span>
                      <div class="h5 mb-0 font-weight-semibold mt-1">$89 - $97</div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div><?php */?>
      </div>
      <!--/Right Side Content--> 
    </div>
  </div>
</section>
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
		var tooltipval;
		if(result==" Favourite")
		{
			classname = 'btn btn-primary icons';
			tooltipval = "Added to Favourites";
		}
		else if(result==" Not Favourite")
		{
			classname = 'btn btn-grey icons';
			tooltipval = "Add to Favourites";
		}
		$('#classfavourite_'+id).removeClass();
		$('#classfavourite_'+id).addClass(classname);
		$('#classfavourite_'+id).attr('data-original-title', tooltipval).tooltip('show');
	});
}

function fun_showphone()
{
	$('#show_phone').html({{ $data['ad_seller_phone'] }});
	$('#hide_show').hide();
}
</script>
@endsection
<!--DI CODE - End-->
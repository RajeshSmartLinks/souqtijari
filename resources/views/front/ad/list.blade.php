<!--DI CODE - Start-->
@extends('layouts.app')

@section('content') 

@include('layouts.partials.front.breadcrumbs') 

<!--Add listing-->
<section class="sptb">
  <div class="container">
    <div class="row">
      <div class="col-xl-9 col-lg-8 col-md-12"> 
        <!--Add lists-->
        <div class=" mb-lg-0">
          <div class="">
            <div class="item2-gl ">
              <?php /*?><div class=" mb-0">
                <div class="">
                  <div class="p-5 bg-white item2-gl-nav d-flex">
                    <h6 class="mb-0 mt-2">Showing 1 to 10 of 30 entries</h6>
                    <ul class="nav item2-gl-menu {{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-auto">
                      <li class=""><a href="#tab-11" class="active show" data-toggle="tab" title="List style"><i class="fa fa-list"></i></a></li>
                      <li><a href="#tab-12" data-toggle="tab" class="" title="Grid"><i class="fa fa-th"></i></a></li>
                    </ul>
                    <div class="d-flex">
                      <label class="{{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2 mt-1 mb-sm-1">Sort By:</label>
                      <select name="item" class="form-control select2 select-sm w-70">
                        <option value="1">Latest</option>
                        <option value="2">Oldest</option>
                        <option value="3">Price:Low-to-High</option>
                        <option value="5">Price:Hight-to-Low</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div><?php */?>
              <div class="tab-content">
                <div class="tab-pane active" id="tab-11">					
					
					@if(count($data['allads'])>0)
					@foreach($data['allads'] as $adDetail)
                  <div class="card overflow-hidden">
					  @if($adDetail['ad_is_featured']==1)
					  <div class="ribbon ribbon-top-left text-danger"><span class="bg-primary">@lang('app.featured')</span></div>
					  @endif
                    <div class="d-md-flex">
                      <div class="item-card9-img">
                        <!--<div class="arrow-ribbon bg-primary">Rent</div>-->
                        <div class="item-card9-imgs"> <a href="{{ $adDetail['detail_url'] }}"></a> <img src="{{ $adDetail['ad_image'] }}" alt="img" class="cover-image"><!--<img src="{{ asset('images/products/h4.png') }}" alt="img" class="cover-image">--> </div>
						  <div class="item-card9-icons">
						  @guest
							  <a href="#" data-toggle="modal" data-target="#exampleModal" class="item-card9-icons1 wishlist"> <i class="fa fa fa-heart-o"></i></a> 
						  @endguest
						  @auth
							  <a href="javascript:" onClick="onclickfavourite({{ $adDetail['ad_id'] }})" id="classfavourite_{{ $adDetail['ad_id'] }}" class="{{ $adDetail['favourite'] == 'Favourite' ? 'item-card9-icons1 wishlist active' : 'item-card9-icons1 wishlist' }}"> <i class="fa fa fa-heart-o"></i></a> 						
						  @endauth
						  </div>
                      </div>
                      <div class="card border-0 mb-0">
                        <div class="card-body ">
                          <div class="item-card9"> <a href="#">{{ $adDetail['ad_cat_name'] }}</a> <a href="{{ $adDetail['detail_url'] }}" class="text-dark">
                            <h4 class="font-weight-semibold mt-1">{{ $adDetail['ad_title'] }}</h4>
                            </a>
                            <p class="mb-0 leading-tight">{{ $adDetail['ad_description'] }}</p>
                          </div>
                        </div>
                        <div class="card-footer pt-4 pb-4">
                          <div class="item-card9-footer d-flex">
                            <div class="item-card9-cost">
                              <h4 class="text-dark font-weight-semibold mb-0 mt-0">@lang('app.kd') {{ $adDetail['ad_price'] }}</h4>
                            </div>
                            <div class="{{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-auto"> <a href="#" class="location"><i class="fa fa-map-marker text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{ $adDetail['ad_location'] }}</a> </div>
							  <?PHP 
							  if($adDetail['ad_condition']=='New'){$ad_condition_value = trans('app.new');}
							  elseif($adDetail['ad_condition']=='Used'){$ad_condition_value = trans('app.used');}
							  ?>
                            <div class="{{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-auto"> <a href="#" class="btn btn-primary btn-sm">{{ $ad_condition_value }}</a> </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
					@endforeach
					@else
					<div class="card overflow-hidden">
					  <div class="d-md-flex">
						<p>@lang('app.no_results')</p>
					  </div>
					</div>
					@endif		
                  
                </div>
                <?php /*?><div class="tab-pane" id="tab-12">
                  <div class="row">
                    <div class="col-lg-6 col-md-12 col-xl-4">
                      <div class="card overflow-hidden">
                        <div class="item-card9-img">
                          <div class="arrow-ribbon bg-primary">Rent</div>
                          <div class="item-card9-imgs"> <a href="classified.html"></a> <img src="{{ asset('images/products/h4.png') }}" alt="img" class="cover-image"> </div>
                          <div class="item-card9-icons"> <a href="#" class="item-card9-icons1 wishlist"> <i class="fa fa fa-heart-o"></i></a> </div>
                        </div>
                        <div class="card-body">
                          <div class="item-card9"> <a href="classified.html">RealEstate</a> <a href="classified.html" class="text-dark mt-2">
                            <h4 class="font-weight-semibold mt-1">2BK flat </h4>
                            </a>
                            <p>Ut enim ad minima veniamq nostrum exerci ullam orisin suscipit laboriosam</p>
                            <div class="item-card9-desc">								
								@if(app()->getLocale() == 'en')								
								<a href="#" class="mr-4"><span class=""><i class="fa fa-map-marker text-muted mr-1"></i> USA</span></a>
								<a href="#" class=""><span class=""><i class="fa fa-calendar-o text-muted mr-1"></i> Nov-15-2019</span></a>
								@elseif(app()->getLocale() == 'ar')
								<a href="#" class="mr-4"><span class="">USA <i class="fa fa-map-marker text-muted ml-1"></i> </span></a>
								<a href="#" class=""><span class=""> Nov-15-2019<i class="fa fa-calendar-o text-muted ml-1 float-right"></i></span></a>
								@endif
							  </div>
                          </div>
                        </div>
                        <div class="card-footer">
                          <div class="item-card9-footer d-flex">
                            <div class="item-card9-cost">
                              <h4 class="text-dark font-weight-semibold mb-0 mt-0">$263.99</h4>
                            </div>
                            <div class="{{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-auto">
                              <div class="rating-stars block">
                                <input type="number" readonly="readonly" class="rating-value star" name="rating-stars-value"  value="3">
                                <div class="rating-stars-container">
                                  <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                  <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                  <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                  <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                  <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-xl-4">
                      <div class="card overflow-hidden">
                        <div class="ribbon ribbon-top-left text-danger"><span class="bg-danger">featured</span></div>
                        <div class="item-card9-img">
                          <div class="item-card9-imgs"> <a href="classified.html"></a> <img src="{{ asset('images/products/j2.png') }}" alt="img" class="cover-image"> </div>
                          <div class="item-card9-icons"> <a href="#" class="item-card9-icons1 wishlist active"> <i class="fa fa fa-heart-o"></i></a> </div>
                        </div>
                        <div class="card-body">
                          <div class="item-card9"> <a href="classified.html">Jobs</a> <a href="classified.html" class="text-dark mt-2">
                            <h4 class="font-weight-semibold mt-1">Horbica Consulting</h4>
                            </a>
                            <p>Ut enim ad minima veniamq nostrum exerci ullam orisin suscipit laboriosam</p>
                            <div class="item-card9-desc">
								@if(app()->getLocale() == 'en')								
								<a href="#" class="mr-4"><span class=""><i class="fa fa-map-marker text-muted mr-1"></i> UK</span></a>
								<a href="#" class=""><span class=""><i class="fa fa-calendar-o text-muted mr-1"></i> Dec-05-2018</span></a>
								@elseif(app()->getLocale() == 'ar')
								<a href="#" class="mr-4"><span class="">UK<i class="fa fa-map-marker text-muted ml-1"></i> </span></a>
								<a href="#" class=""><span class=""> Dec-05-2018<i class="fa fa-calendar-o text-muted ml-1 float-right"></i></span></a>
								@endif
							</div>
                          </div>
                        </div>
                        <div class="card-footer">
                          <div class="item-card9-footer d-flex">
                            <div class="item-card9-cost">
                              <h4 class="text-dark font-weight-semibold mb-0 mt-0">$745.00</h4>
                            </div>
                            <div class="{{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-auto">
                              <div class="rating-stars block">
                                <input type="number" readonly="readonly" class="rating-value star" name="rating-stars-value"  value="2">
                                <div class="rating-stars-container">
                                  <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                  <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                  <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                  <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                  <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-xl-4">
                      <div class="card overflow-hidden">
                        <div class="ribbon ribbon-top-left text-primary"><span class="bg-primary">featured</span></div>
                        <div class="item-card9-img">
                          <div class="item-card9-imgs"> <a href="classified.html"></a> <img src="{{ asset('images/products/pe1.png') }}" alt="img" class="cover-image"> </div>
                          <div class="item-card9-icons"> <a href="#" class="item-card9-icons1 wishlist"> <i class="fa fa fa-heart-o"></i></a> </div>
                        </div>
                        <div class="card-body">
                          <div class="item-card9"> <a href="classified.html">Animals</a> <a href="classified.html" class="text-dark mt-2">
                            <h4 class="font-weight-semibold mt-1">kenco petcenter</h4>
                            </a>
                            <p>Ut enim ad minima veniamq nostrum exerci ullam orisin suscipit laboriosam</p>
                            <div class="item-card9-desc">
								@if(app()->getLocale() == 'en')								
								<a href="#" class="mr-4"><span class=""><i class="fa fa-map-marker text-muted mr-1"></i> UK</span></a>
								<a href="#" class=""><span class=""><i class="fa fa-calendar-o text-muted mr-1"></i> Nov-25-2018</span></a>
								@elseif(app()->getLocale() == 'ar')
								<a href="#" class="mr-4"><span class="">UK<i class="fa fa-map-marker text-muted ml-1"></i> </span></a>
								<a href="#" class=""><span class=""> Nov-25-2018<i class="fa fa-calendar-o text-muted ml-1 float-right"></i></span></a>
								@endif
							</div>
                          </div>
                        </div>
                        <div class="card-footer">
                          <div class="item-card9-footer d-flex">
                            <div class="item-card9-cost">
                              <h4 class="text-dark font-weight-semibold mb-0 mt-0">$149.00</h4>
                            </div>
                            <div class="{{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-auto">
                              <div class="rating-stars block">
                                <input type="number" readonly="readonly" class="rating-value star" name="rating-stars-value"  value="3">
                                <div class="rating-stars-container">
                                  <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                  <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                  <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                  <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                  <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-xl-4">
                      <div class="card overflow-hidden">
                        <div class="item-card2-img">
                          <div class="arrow-ribbon bg-primary">$185</div>
                          <a href="classified.html"></a> <img src="{{ asset('images/products/b3.png') }}" alt="img" class="cover-image"> </div>
                        <div class="item-card9-icons"> <a href="#" class="item-card9-icons1 wishlist active"> <i class="fa fa fa-heart-o"></i></a> </div>
                        <div class="card-body">
                          <div class="item-card2">
                            <div class="item-card2-desc"> <a href="classified.html">Beauty & Spa</a> <a href="classified.html" class="text-dark mt-2">
                              <h4 class="font-weight-semibold mt-1">Gozer Beauty & Spa</h4>
                              </a>
                              <p class="mb-0">Ut enim ad minima veniamq nostrum exerci ullam orisin suscipit laboriosam</p>
                            </div>
                          </div>
                        </div>
                        <div class="card-footer">
                          <div class="item-card2-footer"> <a href="#" class="location"><i class="fa fa-map-marker text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> Los Angles</a>
                            <div class="rating-stars item-card2-rating d-inline-flex">
                              <input type="number" readonly="readonly" class="rating-value star" name="rating-stars-value"  value="3">
                              <div class="rating-stars-container">
                                <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                              </div>
                              (145 reviews) </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-xl-4">
                      <div class="card overflow-hidden">
                        <div class="item-card2-img">
                          <div class="arrow-ribbon bg-primary">$158</div>
                          <a href="classified.html"></a> <img src="{{ asset('images/products/f4.png') }}" alt="img" class="cover-image"> </div>
                        <div class="item-card9-icons"> <a href="#" class="item-card9-icons1 wishlist"> <i class="fa fa fa-heart-o"></i></a> </div>
                        <div class="card-body">
                          <div class="item-card2">
                            <div class="item-card2-desc"> <a href="classified.html">Restaurant</a> <a href="classified.html" class="text-dark mt-2">
                              <h4 class="font-weight-semibold mt-1">GilkonStar Hotel</h4>
                              </a>
                              <p class="mb-0">Ut enim ad minima veniamq nostrum exerci ullam orisin suscipit laboriosam</p>
                            </div>
                          </div>
                        </div>
                        <div class="card-footer">
                          <div class="item-card2-footer"> <a href="#" class="location"><i class="fa fa-map-marker text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> Los Angles</a>
                            <div class="rating-stars item-card2-rating d-inline-flex">
                              <input type="number" readonly="readonly" class="rating-value star" name="rating-stars-value"  value="3">
                              <div class="rating-stars-container">
                                <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                              </div>
                              (145 reviews) </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-xl-4">
                      <div class="card overflow-hidden">
                        <div class="item-card2-img">
                          <div class="arrow-ribbon bg-primary">$172</div>
                          <a href="classified.html"></a> <img src="{{ asset('images/products/v1.png') }}" alt="img" class="cover-image"> </div>
                        <div class="item-card9-icons"> <a href="#" class="item-card9-icons1 wishlist"> <i class="fa fa fa-heart-o"></i></a> </div>
                        <div class="card-body">
                          <div class="item-card2">
                            <div class="item-card2-desc"> <a href="classified.html">Vehicles</a> <a href="classified.html" class="text-dark mt-2">
                              <h4 class="font-weight-semibold mt-1">Seep Automobiles</h4>
                              </a>
                              <p class="mb-0">Ut enim ad minima veniamq nostrum exerci ullam orisin suscipit laboriosam</p>
                            </div>
                          </div>
                        </div>
                        <div class="card-footer">
                          <div class="item-card2-footer"> <a href="#" class="location"><i class="fa fa-map-marker text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> San Francisco</a>
                            <div class="rating-stars item-card2-rating d-inline-flex">
                              <input type="number" readonly="readonly" class="rating-value star" name="rating-stars-value"  value="3">
                              <div class="rating-stars-container">
                                <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                                <div class="rating-star sm"> <i class="fa fa-star"></i> </div>
                              </div>
                              (46 reviews) </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div><?php */?>
              </div>
            </div>
            <div class="center-block text-center">
				{!! $data['alladspagination']->links() !!}
				<?php /*?>{{ $data['alladspagination']->onEachSide(2)->links() }}<?php */?>
              <?php /*?><ul class="pagination mb-5">
                <li class="page-item page-prev disabled"> <a class="page-link" href="#" tabindex="-1">Prev</a> </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item page-next"> <a class="page-link" href="#">Next</a> </li>
              </ul><?php */?>
            </div>
          </div>
        </div>
        <!--/Add lists--> 
      </div>
      
      <!--Right Side Content-->		
      <div class="col-xl-3 col-lg-4 col-md-12">
		  <?php /*?><form method="post" name="filter_form" id="filter_form" action="{{ route('ad.search', app()->getLocale()) }}"><?php */?>
		  <form method="post" name="filter_form" id="filter_form" action="#">
			  @csrf
			  <input type="hidden" name="in_page" id="in_page" value="{{ $data['inpage'] }}">
			  <input type="hidden" name="catname" id="catname" value="{{ $data['catname'] }}">
			  <input type="hidden" name="user" id="user" value="{{ $data['user'] }}">
			  <input type="hidden" name="location" id="location" value="{{ $data['location'] }}">
        <div class="card">
          <div class="card-body">
            <div class="input-group">
              <input type="text" class="form-control br-tl-3 br-bl-3" name="search_text" id="search_text" value="{{ $data['searchtext'] }}" placeholder="@lang('app.search')">
              <!--<div class="input-group-append ">
                <button type="button" class="btn btn-primary br-tr-3 br-br-3"> Search </button>
              </div>-->
            </div>
          </div>
        </div>
        <div class="card">
			<?php /*?>@if($data['inpage']!='catslug')<?php */?>
          <div class="card-header">
            <h3 class="card-title">@lang('app.categories')</h3>
          </div>
          <div class="card-body">
            <div class="" id="container">
              <div class="filter-product-checkboxs">
				  @foreach($data['categories'] as $categories)				  
                <label class="custom-control custom-checkbox mb-3">
                  <?php /*?><input type="checkbox" class="custom-control-input" name="categoryval[]" id="categoryval" {{ ($data['catname']==$categories['slug']) ? 'checked' : '' }} value="{{ $categories['slug'] }}"><?php */?>					
					
				  <?php /*?><input type="checkbox" class="custom-control-input" name="categoryval[]" id="categoryval" {{ ($data['catname']==$categories['slug']) ? 'checked' : (($data['categoryval']['$i']==$categories['slug']) ? 'checked' : '') }} value="{{ $categories['slug'] }}"><?php */?>					
					
                  <input type="checkbox" class="custom-control-input" name="categoryval[]" id="categoryval" 
						  @php				  
						  if(!empty($data['categoryval'])){
							  foreach($data['categoryval'] as $arraycatval)
							  {
								  if($categories['slug']==$arraycatval){
								  echo $checked ='checked';
								  }
								  else{
								  echo $checked = '';
								  }
							  }
						  }
						  else if($data['catname']==$categories['slug']){
						 	if(Route::currentRouteName()!='ad.search'){						 
								echo $checked = 'checked';
						 	}
						  }
						  @endphp
						 value="{{ $categories['slug'] }}">
					
                  <span class="custom-control-label"> <a href="#" class="text-dark">{{ $categories['name'] }}<span class="label label-secondary {{app()->getLocale() == 'en' ? 'float-right' : 'float-left'}}">{{ $categories['adsCountCategory'] }}</span></a> </span>
				</label>				  
				  @endforeach				 
              </div>
            </div>
          </div>
			<?php /*?>@endif<?php */?>
          <div class="card-header border-top">
            <h3 class="card-title">@lang('app.price_range')</h3>
          </div>
          <div class="card-body">
            <h6>
              <label for="price">@lang('app.price_range_kd')</label>
              <input type="text" name="price" id="price">
				<input type="hidden" name="minprice" id="minprice">
				<input type="hidden" name="maxprice" id="maxprice">
            </h6>
            <div id="mySlider"></div>
          </div>
          <div class="card-header border-top">
            <h3 class="card-title">@lang('app.condition')</h3>
          </div>
          <div class="card-body">
            <div class="filter-product-checkboxs">
              <label class="custom-control custom-checkbox mb-2">
                <input type="checkbox" class="custom-control-input" name="ad_condition_new" id="ad_condition_new" {{ ($data['ad_condition_value']=='new') ? 'checked' : '' }} value="new">
                <span class="custom-control-label"> @lang('app.new') </span> </label>
              <label class="custom-control custom-checkbox mb-0">
                <input type="checkbox" class="custom-control-input" name="ad_condition_used" id="ad_condition_used" {{ ($data['ad_condition_value']=='used') ? 'checked' : '' }} value="used">
                <span class="custom-control-label"> @lang('app.used') </span> </label>
            </div>
          </div>
          <div class="card-footer"> <button type="submit" name="apply_filter" id="apply_filter" class="btn btn-secondary btn-block">@lang('app.applyfilter')</button> </div>
        </div>
		</form>
      </div>
      <!--/Right Side Content--> 
    </div>
  </div>
</section>
<!--/Add Listings--> 
@endsection 

@section('extra-scripts')
<script>
$( "#mySlider" ).slider({
	range: true,
	//min: 10,
	//max: 999,	
	//values: [ 200, 500 ],
	min: {{$data['minpricevalue']}},
	max: {{$data['maxpricevalue']}},
	values: [ {{$data['minprice']}}, {{$data['maxprice']}} ],
	slide: function( event, ui ) {
		//$( "#price" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
		$( "#price" ).val( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ] );		
		$( "#minprice" ).val( ui.values[ 0 ] );
		$( "#maxprice" ).val( ui.values[ 1 ] );
	}
});
$( "#price" ).val( "" + $( "#mySlider" ).slider( "values", 0 ) +  " - " + $( "#mySlider" ).slider( "values", 1 ) );	
	
	
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
			classname = 'item-card9-icons1 wishlist active';
		}
		else if(result==" Not Favourite")
		{
			classname = 'item-card9-icons1 wishlist';
		}
		$('#classfavourite_'+id).removeClass();
		$('#classfavourite_'+id).addClass(classname);
	});
}
$("#filter_form").submit(function () {
	$("#apply_filter").html("{{__('app.loading')}}");

	$.ajax({
		type: "POST",
		url: "{{route('ad.dosearch', app()->getLocale())}}",
		data: new FormData(this),
		dataType: "json",
		contentType: false,
		cache: false,
		processData: false,
		success: function (msg) {
			if (msg.status == "200") {
				// $(".searchBtn").html("{{__('app.search')}}");
				location.reload();
			} else {
				$("#apply_filter").html("{{__('app.applyfilter')}}");
			}
		},
		error: function (msg) {
		}
	});

	return false;
});
</script>
@endsection
<!--DI CODE - End-->
<!--DI CODE - Start-->
@extends('layouts.app')

@section('content') 

@include('layouts.partials.front.breadcrumbs') 

<!--Add posts-section-->
<section class="sptb">
  <div class="container">
    <div class="row ">
      <div class="col-lg-8 col-md-12 col-md-12">
        <div class="card ">
			<div class=""><a href="{{ route('user.ads', app()->getLocale()) }}" class="btn btn-primary float-{{app()->getLocale() == 'en' ? 'right' : 'left'}} mt-2 {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2">@lang('app.back')</a> </div>
          <div class="card-header ">
            <h3 class="card-title">{{ $titles['title'] }}</h3>
          </div>
		  <form action="{{route('doedit', app()->getLocale())}}" method="post" name="adform" id="adform" enctype="multipart/form-data">
			  @csrf
			  <input type="hidden" name="ad_id" id="ad_id" value="{{ $editAd->id }}">
          <div class="card-body">
		  @if ($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>    
				<strong>{{ $message }}</strong>
			</div>
		  @endif
			<div class="form-group">
              <label class="form-label text-dark">@lang('app.category')</label>
              <select class="form-control custom-select" name="ad_category_id" id="ad_category_id" required>
                <option value="">@lang('app.select_category')</option>
				@foreach($data['categories'] as $category)
				  @if($category->child->count() > 0)
					<option value="{{ $category->id }}" {{ $editAd->ad_category_id == $category->id ? 'selected="selected"' : '' }}>{{ $category->name_en }}</option>
				  @endif
				@endforeach
              </select>
            </div>
			<div class="form-group">
              <label class="form-label text-dark">@lang('app.sub_category')</label>
              <select class="form-control custom-select" name="ad_sub_category_id" id="ad_sub_category_id" required>
                <option value="">@lang('app.select_sub_category')</option>	
				@foreach($data['subcategories'] as $sub_category)
					<option value="{{ $sub_category->id }}" {{ $editAd->ad_sub_category_id == $sub_category->id ? 'selected="selected"' : '' }}>{{ $sub_category->name_en }}</option>				  
				@endforeach			
              </select>
            </div>
			<div class="form-group">
              <label class="form-label text-dark">@lang('app.brand')</label>
              <select class="form-control custom-select"  name="ad_brand_id" id="ad_brand_id" >
                <option value="">@lang('app.select_brand')</option>
				@foreach($data['brands'] as $brand)
					<option value="{{ $brand->id }}" {{ $editAd->ad_brand_id == $brand->id ? 'selected="selected"' : '' }}>{{ $brand->name_en }}</option>				  
				@endforeach	
              </select>
            </div>
            <div class="form-group">
              <label class="form-label text-dark">@lang('app.ad_title')</label>
              <input type="text" class="form-control" name="ad_title" id="ad_title" placeholder="@lang('app.ad_title')" maxlength="40" value="{{$editAd->ad_title}}" required>
				<span>@lang('app.max_allowed_40')</span>
            </div>
            <div class="form-group">
              <label class="form-label text-dark">@lang('app.ad_description')</label>
              <textarea class="form-control" name="ad_description" id="ad_description" rows="6" placeholder="@lang('app.ad_description_here')" required>{{$editAd->ad_description}}</textarea>
            </div>
            <div class="form-group">
              <label class="form-label text-dark">@lang('app.country')</label>
              <select class="form-control custom-select" name="ad_location_country" id="ad_location_country" required>
                <option value="">@lang('app.select_country')</option>
                @foreach($data['countries'] as $country)
                <option value="{{ $country->id }}" {{ $editAd->country_id == $country->id ? 'selected="selected"' : '' }}>{{ $country->name_en }}</option>  
                @endforeach
              </select>
            </div>
			      <div class="form-group">
              <label class="form-label text-dark">@lang('app.location')</label>
              <select class="form-control custom-select" name="ad_location_area" id="ad_location_area" required>
                <option value="">@lang('app.select_location')</option>
                  @foreach($data['areas'] as $area)
                    @if($area->child->count() > 0)                                    
                    <optgroup label="{{ $area->name_en }}">
                      @foreach($area->child as $location_area)                                        
                      <option value="{{ $location_area->id }}" {{ $editAd->ad_location_area == $location_area->id ? 'selected="selected"' : '' }}>{{ $location_area->name_en }}</option>   
                      @endforeach
                    </optgroup>
                    @endif
                  @endforeach
              </select>
            </div>
            <div class="form-group">
              <label class="form-label text-dark">@lang('app.condition')</label>
              <div class="d-md-flex ad-post-details">
                <label class="custom-control custom-radio mb-2 {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-4">
                  <input type="radio" class="custom-control-input" name="ad_condition" id="ad_condition" value="new" {{ $editAd->ad_condition == 'new' ? 'checked=""' : '' }} >
                  <span class="custom-control-label"><a href="#" class="text-muted">@lang('app.new') </a></span> </label>
                <label class="custom-control custom-radio  mb-2">
                  <input type="radio" class="custom-control-input" name="ad_condition" id="ad_condition" value="used" {{ $editAd->ad_condition == 'used' ? 'checked=""' : '' }} >
                  <span class="custom-control-label"><a href="#" class="text-muted">@lang('app.used')</a></span> </label>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label text-dark">@lang('app.price')</label>
              <input type="text" class="form-control" placeholder="@lang('app.price_value')" name="ad_price" id="ad_price" value="{{$editAd->ad_price}}" required>
            </div>
            <div class="form-group">
              <label class="form-label text-dark">@lang('app.negotiable')</label>
              <label class="custom-control custom-checkbox mb-3">
				<input type="checkbox" class="custom-control-input" value="1" name="ad_is_negotiable" id="ad_is_negotiable" {{ $editAd->ad_is_negotiable == '1' ? 'checked=""' : '' }}>
				<span class="custom-control-label">@lang('app.price_negotiable')</span>
			  </label>
            </div>
            <div class="form-group">
              <label class="form-label text-dark">@lang('app.seller_name')</label>
              <input type="text" class="form-control" name="ad_seller_name" id="ad_seller_name" placeholder="@lang('app.seller_name')" value="{{$editAd->ad_seller_name}}" required>
            </div>
            <div class="form-group">
              <label class="form-label text-dark">@lang('app.seller_email')</label>
              <input type="text" class="form-control" name="ad_seller_email" id="ad_seller_email" placeholder="@lang('app.seller_email')" value="{{$editAd->ad_seller_email}}">
            </div>
            <div class="form-group">
              <label class="form-label text-dark">@lang('app.seller_phone')</label>
              <input type="text" class="form-control" name="ad_seller_phone" id="ad_seller_phone" placeholder="@lang('app.seller_phone')" value="{{$editAd->ad_seller_phone}}" required>
            </div>
            <div class="form-group">
              <label class="form-label text-dark"></label>
              <label class="custom-control custom-checkbox mb-3">				
              <input type="checkbox" class="custom-control-input" name="ad_phone_whatsapp" id="ad_phone_whatsapp" {{ $editAd->ad_seller_phone == $editAd->ad_seller_whatsapp ? 'checked=""' : '' }}>
				<span class="custom-control-label">@lang('app.seller_whatsapp_phone')</span>
			  </label>
            </div>
            <div class="form-group">
              <label class="form-label text-dark">@lang('app.seller_whatsapp')</label>
              <input type="text" class="form-control" name="ad_seller_whatsapp" id="ad_seller_whatsapp" placeholder="@lang('app.seller_whatsapp')" value="{{$editAd->ad_seller_whatsapp}}">
            </div>
            <div class="form-group">
              <label class="form-label text-dark">@lang('app.seller_address')</label>
              <textarea class="form-control" name="ad_seller_address" id="ad_seller_address" rows="6" placeholder="@lang('app.seller_address')">{{$editAd->ad_seller_address}}</textarea>
            </div>
            <div class="form-group">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="ad_image[]" id="ad_image" multiple>
                <label class="custom-file-label">@lang('app.upload_images')</label>
              </div>
            </div>
			@if($data['adsimages']->count() > 0)
			  @foreach($data['adsimages'] as $adsimage)
            <div class="p-2 border mb-4" id="media{{$adsimage->id}}">
              <div class="upload-images d-flex">
                <div> <!--<img src="{{ asset('images/products/h1.jpg') }}" alt="img" class="w73 h73 border p-0">--><img src="{{asset('uploads/ad/'.$adsimage->ads_image)}}" alt="{{$adsimage->ads_image}}" class="w73 h73 border p-0"> </div>
                <div class="{{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-3 mt-2">
                  <h6 class="mb-0 mt-3 font-weight-bold">{{$adsimage->ads_image}}</h6>
                  <!--<small>4.5kb</small>--> </div>
                <div class="float-{{app()->getLocale() == 'en' ? 'right' : 'left'}} {{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-auto img-action-wrap" id="{{ $adsimage->id }}"> 
					<a href="javascript:" data-id="{{ $adsimage->id }}" class=" btn btn-icon btn-primary btn-sm mt-5 mr-2 imgFeatureBtn" ><i class="fa fa-star{{ $adsimage->is_feature ==1 ? '':'-o' }}"></i></a>
					<a href="javascript:" data-id="{{$adsimage->id}}" class="float-right btn btn-icon btn-danger btn-sm mt-5 deleteMedia" ><i class="fa fa-trash-o"></i></a>
				  </div>
              </div>
            </div>
			  @endforeach
			@endif
			  <div class="form-group {{ $errors->has('images')? 'has-error':'' }}">
				  <div class="col-sm-12">
					  <div id="uploaded-ads-image-wrap">
					  @if(count($data['ads_images']) > 0)
					  @foreach($data['ads_images'] as $img)						  
						<div class="p-2 border mb-4" id="media{{ $img['id'] }}">
						  <div class="upload-images d-flex">
							<div> <!--<img src="{{ asset('images/products/h1.jpg') }}" alt="img" class="w73 h73 border p-0">--><img src="{{ $img['adimage_url'] }}" alt="{{ $img['adimage'] }}" class="w73 h73 border p-0"> </div>
							<div class="{{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-3 mt-2">
							  <h6 class="mb-0 mt-3 font-weight-bold">{{ $img['adimage'] }}</h6>
							  <!--<small>4.5kb</small>--> </div>
							<div class="float-{{app()->getLocale() == 'en' ? 'right' : 'left'}} {{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-auto img-action-wrap" id="{{ $img['id'] }}">
								<a href="javascript:" data-id="{{ $img['id'] }}" class=" btn btn-icon btn-primary btn-sm mt-5 mr-2 imgFeatureBtn" ><i class="fa fa-star{{ $img['is_feature'] ==1 ? '':'-o' }}"></i></a>
								<a href="javascript:" data-id="{{ $img['id'] }}" class="float-right btn btn-icon btn-danger btn-sm mt-5 deleteMedia" ><i class="fa fa-trash-o"></i></a>
							</div>
						  </div>
						</div>
					  @endforeach
					  @endif
					  </div>
					  <?php /*?><div class="file-upload-wrap">
						  <label><input type="file" name="ad_image[]" id="ad_image" style="display: none;" multiple /><i class="fa fa-cloud-upload"></i><p>@lang('app.upload_image')</p><div class="progress" style="display: none;"></div></label>
					  </div><?php */?>
					  {!! $errors->has('images')? '<p class="help-block">'.$errors->first('images').'</p>':'' !!}
				  </div>
			  </div>
			  
          </div>
          <div class="card-footer ">
			  <input type="submit" name="submit" value="@lang('app.save')" class="btn btn-success">
			  <a href="{{ route('user.ads', app()->getLocale()) }}" class="btn btn-primary {{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-2">@lang('app.cancel')</a>
		  </div>
		  </form>
        </div>
      </div>
      <div class="col-lg-4 col-md-12">
        <?php /*?><div class="card">
          <div class="card-header">
            <h3 class="card-title">Terms And Conditions</h3>
          </div>
          <div class="card-body">
            <ul class="list-unstyled widget-spec  mb-0">
              <li> <i class="fa fa-check text-success" aria-hidden="true"></i>Money Not Refundable </li>
              <li> <i class="fa fa-check text-success" aria-hidden="true"></i>You can renew your Premium ad after experted. </li>
              <li> <i class="fa fa-check text-success" aria-hidden="true"></i>Premium ads are active for depend on package. </li>
              <li class="{{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-5 mb-0"> <a href="tips.html"> View more..</a> </li>
            </ul>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Benefits Of Premium Ad</h3>
          </div>
          <div class="card-body pb-2">
            <ul class="list-unstyled widget-spec vertical-scroll mb-0">
              <li> <i class="fa fa-check text-success" aria-hidden="true"></i>Premium Ads Active </li>
              <li> <i class="fa fa-check text-success" aria-hidden="true"></i>Premium ads are displayed on top </li>
              <li> <i class="fa fa-check text-success" aria-hidden="true"></i>Premium ads will be Show in Google results </li>
              <li> <i class="fa fa-check text-success" aria-hidden="true"></i>Premium Ads Active </li>
              <li> <i class="fa fa-check text-success" aria-hidden="true"></i>Premium ads are displayed on top </li>
              <li> <i class="fa fa-check text-success" aria-hidden="true"></i>Premium ads will be Show in Google results </li>
              <li> <i class="fa fa-check text-success" aria-hidden="true"></i>Premium Ads Active </li>
              <li> <i class="fa fa-check text-success" aria-hidden="true"></i>Premium ads are displayed on top </li>
              <li> <i class="fa fa-check text-success" aria-hidden="true"></i>Premium ads will be Show in Google results </li>
              <li> <i class="fa fa-check text-success" aria-hidden="true"></i>Premium Ads Active </li>
              <li> <i class="fa fa-check text-success" aria-hidden="true"></i>Premium ads are displayed on top </li>
              <li> <i class="fa fa-check text-success" aria-hidden="true"></i>Premium ads will be Show in Google results </li>
              <li> <i class="fa fa-check text-success" aria-hidden="true"></i>Premium Ads Active </li>
              <li> <i class="fa fa-check text-success" aria-hidden="true"></i>Premium ads are displayed on top </li>
              <li> <i class="fa fa-check text-success" aria-hidden="true"></i>Premium ads will be Show in Google results </li>
            </ul>
          </div>
        </div><?php */?>
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
      </div>
      <?php /*?><div class="col-xl-8">
        <div class="card mb-xl-0">
          <div class="card-header">
            <h3 class="card-title">Payments</h3>
          </div>
          <div class="card-body">
            <div class="tab-content card-body border mb-0 b-0">
              <div class="panel panel-primary">
                <div class=" tab-menu-heading border-0 pl-0 pr-0 pt-0">
                  <div class="tabs-menu1 "> 
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">
                      <li><a href="#tab5" class="active" data-toggle="tab">Credit/ Debit Card</a></li>
                      <li><a href="#tab6" data-toggle="tab">Pay-pal</a></li>
                      <li><a href="#tab7" data-toggle="tab">Net Banking</a></li>
                      <li><a href="#tab8" data-toggle="tab">Gift Voucher</a></li>
                    </ul>
                  </div>
                </div>
                <div class="panel-body tabs-menu-body pl-0 pr-0 border-0">
                  <div class="tab-content">
                    <div class="tab-pane active " id="tab5">
                      <div class="form-group">
                        <label class="form-label" >CardHolder Name</label>
                        <input type="text" class="form-control" id="name1" placeholder="First Name">
                      </div>
                      <div class="form-group">
                        <label class="form-label">Card number</label>
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Search for...">
                          <span class="input-group-append">
                          <button class="btn btn-info" type="button"><i class="fa fa-cc-visa"></i> &nbsp; <i class="fa fa-cc-amex"></i> &nbsp; <i class="fa fa-cc-mastercard"></i></button>
                          </span> </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-8">
                          <div class="form-group mb-sm-0">
                            <label class="form-label">Expiration</label>
                            <div class="input-group">
                              <input type="number" class="form-control" placeholder="MM" name="expiremonth">
                              <input type="number" class="form-control" placeholder="YY" name="expireyear">
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-4 ">
                          <div class="form-group mb-0">
                            <label class="form-label">CVV <i class="fa fa-question-circle"></i></label>
                            <input type="number" class="form-control" required="">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane " id="tab6">
                      <h6 class="font-weight-semibold">Paypal is easiest way to pay online</h6>
                      <p><a href="#" class="btn btn-primary"><i class="fa fa-paypal"></i> Log in my Paypal</a></p>
                      <p class="mb-0"><strong>Note:</strong> Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. </p>
                    </div>
                    <div class="tab-pane " id="tab7">
                      <div class="control-group form-group">
                        <div class="form-group">
                          <label class="form-label text-dark">All Banks</label>
                          <select class="form-control custom-select required category">
                            <option value="0">Select Bank</option>
                            <option value="1">Credit Agricole Group</option>
                            <option value="2">Bank of America</option>
                            <option value="3">Mitsubishi UFJ Financial Group</option>
                            <option value="4">BNP Paribas</option>
                            <option value="5">JPMorgan Chase & Co.</option>
                            <option value="6">HSBC Holdings</option>
                            <option value="7">Bank of China</option>
                            <option value="8">Agricultural Bank of China</option>
                            <option value="9">China Construction Bank Corp.</option>
                            <option value="10">Industrial & Commercial Bank of China, or ICBC</option>
                          </select>
                        </div>
                      </div>
                      <p><a href="#" class="btn btn-primary">Log in Bank</a></p>
                    </div>
                    <div class="tab-pane " id="tab8">
                      <div class="form-group">
                        <label class="form-label">Gift Voucher</label>
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Enter Your Gv Number">
                          <span class="input-group-append">
                          <button class="btn btn-info" type="button"> Apply</button>
                          </span> </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group row clearfix">
                <div class="col-lg-12">
                  <div class="checkbox checkbox-info">
                    <label class="custom-control mt-4 custom-checkbox">
                      <input type="checkbox" class="custom-control-input" />
                      <span class="custom-control-label text-dark {{app()->getLocale() == 'en' ? 'pl' : 'pr'}}-2">I agree with the Terms and Conditions.</span> </label>
                  </div>
                </div>
                <ul class=" mb-b-4 ">
                  <li class="float-{{app()->getLocale() == 'en' ? 'right' : 'left'}}"><a href="#" class="btn btn-primary  mb-0 {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2">Continue</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div><?php */?>
    </div>
  </div>
</section>
<!--/Add posts-section--> 

@endsection 

@section('extra-scripts')
<script>
$(document).ready(function(){
	// Category -> Sub Category
	$('#ad_category_id').on("change", function(){
		var cat_id = $(this).val();
		$.ajax({
			type: "GET",
			url: '{{ route("getsubcategory", app()->getLocale()) }}',
			data: {'cat_id': cat_id}
		}).done(function (result) {
			if(result.length>0 || result == undefined || result == null){
				var new_res = $.parseJSON(result);
				$('#ad_sub_category_id').empty();
				$("#ad_sub_category_id").append($("<option value=''>@lang('app.select_sub_category')</option>")); 
				$.each(new_res, function(key, value) {
					$("#ad_sub_category_id").append($("<option></option>").val(key).html(value)); 
				});					
			}
			else{
				$("#ad_sub_category_id").empty();
				$("#ad_sub_category_id").append($("<option value=''>@lang('app.select_sub_category')</option>")); 
			}
		});
	});
	
	// Sub Category -> Brand
	$('#ad_sub_category_id').on("change", function(){
		var cat_id = $(this).val();
		$.ajax({
			type: "GET",
			url: '{{ route("getbrandname", app()->getLocale()) }}',
			data: {'cat_id': cat_id}
		}).done(function (result) {
			if(result.length>0 || result == undefined || result == null){
				var new_res = $.parseJSON(result);
				$('#ad_brand_id').empty();
				$("#ad_brand_id").append($("<option value=''>@lang('app.select_brand')</option>")); 
				$.each(new_res, function(key, value) {
					$("#ad_brand_id").append($("<option></option>").val(key).html(value)); 
				});					
			}
			else{
				$("#ad_brand_id").empty();
				$("#ad_brand_id").append($("<option value=''>@lang('app.select_brand')</option>")); 
			}
		});
	});

  //country
  $('#ad_location_country').on("change", function(){
		var country_id = $(this).val();
    alert(country_id);
		$.ajax({
			type: "GET",
			url: '{{ route("getcountryAreas", app()->getLocale()) }}',
			data: {'country_id': country_id}
		}).done(function (result) {
			if(result.length>0 || result == undefined || result == null){
				var new_res = $.parseJSON(result);
        console.log(new_res);
				$('#ad_location_area').empty();
				$("#ad_location_area").append($("<option value=''>@lang('app.select_location')</option>")); 
				$.each(new_res, function(key, value) {
          console.log(value);
          $Html = `<optgroup label="`+value.name_en+`">`;
            $.each(value.city, function(k,v){
              $Html += `<option value="`+v.id+`">`+v.name_en+`</option>  `;
            });
            $Html +=`<optgroup>`;
          $("#ad_location_area").append($Html); 

          
					
				});					
			}
			else{
				$("#ad_location_area").empty();
				$("#ad_location_area").append($("<option value=''>@lang('app.select_area')</option>")); 
			}
		});
	});
	
	$("#ad_image").change(function() {
		var fd = new FormData(document.querySelector("form#adform"));
		$('#loadingOverlay').show();

		$.ajax({
			url : '{{ route("upload_ads_image", app()->getLocale()) }}',
			type: "POST",
			data: fd,
			processData: false,  // tell jQuery not to process the data
			contentType: false,   // tell jQuery not to set contentType
			success : function (data) {
				//$('#loadingOverlay').hide();
				if (data.success == 1){
					$('#uploaded-ads-image-wrap').load('{{ route("append_media_image", app()->getLocale()) }}');
				} else{
					toastr.error(data.msg, '<?php echo trans('app.error') ?>', toastr_options);
				}
			}
		});
	});
	
	$('body').on('click', '.imgFeatureBtn', function(){
		var img_id = $(this).closest('.img-action-wrap').attr('id');
		var current_selector = $(this);

		$.ajax({
			url : '{{ route("feature_media_creating_ads", app()->getLocale()) }}',
			type: "POST",
			data: { media_id : img_id, ad_id:{{ $editAd->id }}, 	 _token : '{{ csrf_token() }}' },
			success : function (data) {
				if (data.success == 1){
					$('.imgFeatureBtn').html('<i class="fa fa-star-o"></i>');
					current_selector.html('<i class="fa fa-star"></i>');
					toastr.success(data.msg, '@lang("app.success")', toastr_options);
				}
			}
		});
	});
	
	$('.deleteMedia').on("click", function () {
		var delId = $(this).data('id');
		 //alert(delId);
		 if (confirm('{{ trans("app.are_you_sure") }}')) {
			$.ajax({
				url: '{{ route("deleteMediAd", app()->getLocale()) }}',
				type: "GET",
				data: {'delId': delId},
				dataType: "json",
				success: function (data) {
					$('#media' + delId).fadeOut();
				},
			});
		} 
	});
	
	$('#ad_phone_whatsapp').change( function(){
		if ($('#ad_phone_whatsapp').is(':checked'))
		{
			$('#ad_seller_whatsapp').val($('#ad_seller_phone').val());
		}
		else
		{
			$('#ad_seller_whatsapp').val("");
		}
	});
});	
</script>
@endsection
<!--DI CODE - End-->
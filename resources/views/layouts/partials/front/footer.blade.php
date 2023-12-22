<?php /*?>DI CODE - Start<?php */?>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <?php /*?><div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div><?php */?>
      <div class="modal-body">
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php /*?><form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form><?php */?>
		  <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="single-page  w-100  p-0">
                  <div class="wrapper wrapper2">
                    <form method="post" id="login_popup" class="card-body" tabindex="500">
                      <h3 class="pb-2">@lang('app.login')</h3>
						<div class="alert alert-danger" id="error_show" style="display: none;"></div>
						@if ($errors->any())
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						@endif
						@if ($message = Session::get('error'))
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  {{ $message }}
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						  </button>
						</div>
						@endif				
						@if ($message = Session::get('message'))
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						  {{ $message }}
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						  </button>
						</div>
						@endif
                      <div class="mail">
                        <input type="text" name="email" id="email" value="{{ old('email') }}">
                        <label>@lang('app.login_mail_mobile')</label>
                      </div>
                      <div class="passwd">
                        <input type="password" name="password" id="password">
                        <label>@lang('app.password')</label>
                      </div>
                      <!--<div class="submit"> <a class="btn btn-primary btn-block" href="index.html">Login</a> </div>-->
						<input type="submit" name="submit" id="popup_submit" value="@lang('app.login')" class="btn btn-primary btn-block">
						
						
						
                      <p class="mb-2"><a href="{{ route('userforgot', app()->getLocale()) }}" >@lang('app.forgot')</a></p>
                      <p class="text-dark mb-0">@lang('app.dont_have_account')<a href="{{ route('userlogin', app()->getLocale()) }}#profile" class="text-primary {{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-1">@lang('app.sign_up')</a></p>
                    </form>
                    <?php /*?><hr class="divider">
                    <div class="pt-3 pb-3">
                      <div class="text-center">
                        <div class="btn-group mt-2 mb-2"> <a href="https://www.facebook.com/" class="btn btn-icon brround"> <span class="fa fa-facebook"></span> </a> </div>
                        <div class="btn-group mt-2 mb-2"> <a href="https://www.google.com/gmail/" class="btn btn-icon brround"> <span class="fa fa-google"></span> </a> </div>
                        <div class="btn-group mt-2 mb-2"> <a href="https://twitter.com/" class="btn  btn-icon brround"> <span class="fa fa-twitter"></span> </a> </div>
                      </div>
                    </div><?php */?>
                  </div>
                </div>
              </div>
            </div>
      </div>
      <?php /*?><div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
      </div><?php */?>
    </div>
  </div>
</div>


<!-- Newsletter-->
<section class="sptb bg-white border-top">
  <div class="container">
    <div class="row">
      <div class="col-lg-7 col-xl-6 col-md-12">
        <div class="sub-newsletter">
          <h3 class="mb-2"><i class="fa fa-paper-plane-o {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2"></i> @lang('app.subscribe_newsletter')</h3>
          <!--<p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>--> 
        </div>
      </div>
      <div class="col-lg-5 col-xl-6 col-md-12">
        <form method="post" id="newsletter_form">
          <div class="input-group sub-input mt-1">
            <input type="text" class="form-control input-lg " id="newsletter_email" name="newsletter_email" placeholder="@lang('app.enter_your_email')">
            <div class="input-group-append ">
              <button type="submit" id="newsletter_button" class="btn btn-primary btn-lg br-tr-3  br-br-3"> @lang('app.subscribe') </button>
              <!--<input type="submit" id="newsletter_button" class="btn btn-primary btn-lg br-tr-3  br-br-3" value="Subscribe">--> 
            </div>
          </div>
        </form>
        <div class="alert alert-success" id="success_newsletter" style="display: none;"></div>
        <div class="alert alert-danger" id="error_newsletter" style="display: none;"></div>
        <div id="response" ></div>
      </div>
    </div>
  </div>
</section>
<!-- Newsletter-->

<!--Footer Section-->
<section class="main-footer">
  <footer class="bg-dark-purple text-white">
    <div class="footer-main">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-12">
            <h6>@lang('app.about')</h6>
            <hr class="deep-purple  accent-2 mb-4 mt-0 d-inline-block mx-auto">
			  <p>@lang('app.about_footer')</p>
            <?php /*?><p>{{showAboutUs()}}</p> <a href="{{ route('content.about', app()->getLocale()) }}">Read More</a><?php */?>
          </div>
          <div class="col-lg-2 col-md-12">
            <h6>@lang('app.useful_links')</h6>
            <hr class="deep-purple text-primary accent-2 mb-4 mt-0 d-inline-block mx-auto">
            <ul class="list-unstyled mb-0">
              <li><a href="{{ route('content.about', app()->getLocale()) }}">@lang('app.about')</a></li>
              <li><a href="{{ route('news', app()->getLocale()) }}">@lang('app.news')</a></li>
              <li><a href="{{ route('faq', app()->getLocale()) }}">@lang('app.faq')</a></li>
              <li><a href="{{route('contact', app()->getLocale())}}">@lang('app.contact_us')</a></li>
              <li><a href="{{ route('content.privacy', app()->getLocale()) }}">@lang('app.privacy_policy')</a></li>
              <li><a href="{{ route('content.terms', app()->getLocale()) }}">@lang('app.terms_condition')</a></li>
            </ul>
          </div>
          <div class="col-lg-2 col-md-12">
			  <h6>@lang('app.top_categories')</h6>
            <hr class="deep-purple text-primary accent-2 mb-4 mt-0 d-inline-block mx-auto">
            <ul class="list-unstyled mb-0">
				@foreach(menucatads() as $catname)
				<li><a href="{{ route('ad.category.list', [app()->getLocale(),$catname['slug']]) }}">{{ $catname[app()->getLocale() == 'en' ? 'name_en' : 'name_ar'] }} </a></li>
				@endforeach  
            </ul>            
          </div>
          <div class="col-lg-3 col-md-12">
			  <h6>@lang('app.contact')</h6>
            <hr class="deep-purple  text-primary accent-2 mb-4 mt-0 d-inline-block mx-auto">
            <ul class="list-unstyled mb-0">
				@if($settingsDetail['contact_address'])
              <li> <a href="#"><i class="fa fa-home {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-3 text-primary"></i> {{ $settingsDetail['contact_address'] }} </a> </li>
				@endif
				@if($settingsDetail['contact_email'])
              <li> <a href="mailto:{{ $settingsDetail['contact_email'] }}"><i class="fa fa-envelope {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-3 text-primary"></i> {{ $settingsDetail['contact_email'] }}</a></li>
				@endif
				@if($settingsDetail['contact_mobile'])
              <li> <a href="tel:{{ $settingsDetail['contact_mobile'] }}"><i class="fa fa-phone {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-3 text-primary"></i> {{ $settingsDetail['contact_mobile'] }}</a> </li>
				@endif
				@if($settingsDetail['contact_whatsapp'])
              <li> <a href="https://api.whatsapp.com/send?l=en&phone={{ $settingsDetail['contact_whatsapp'] }}&text=Hi"><i class="fa fa-whatsapp {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-3 text-primary"></i> {{ $settingsDetail['contact_whatsapp'] }}</a> </li>
				@endif
            </ul>
            <ul class="list-unstyled list-inline mt-3">
				@if($settingsDetail->facebook_url)
              <li class="list-inline-item"> <a href="{{$settingsDetail->facebook_url}}" class="btn-floating btn-sm rgba-white-slight {{app()->getLocale() == 'en' ? 'mx-1' : ''}} waves-effect waves-light"> <i class="fa fa-facebook bg-facebook"></i> </a> </li>
				@endif
				@if($settingsDetail->twitter_url)
              <li class="list-inline-item"> <a href="{{$settingsDetail->twitter_url}}" class="btn-floating btn-sm rgba-white-slight {{app()->getLocale() == 'en' ? 'mx-1' : ''}} waves-effect waves-light"> <i class="fa fa-twitter bg-info"></i> </a> </li>
				@endif
				@if($settingsDetail->instagram_url)
              <li class="list-inline-item"> <a href="{{$settingsDetail->instagram_url}}" class="btn-floating btn-sm rgba-white-slight {{app()->getLocale() == 'en' ? 'mx-1' : ''}} waves-effect waves-light"> <i class="fa fa-instagram bg-primary"></i> </a> </li>
				@endif
            </ul>			  
            <?php /*?><h6>Subscribe</h6>
            <hr class="deep-purple  text-primary accent-2 mb-4 mt-0 d-inline-block mx-auto">
            <div class="clearfix"></div>
			<form method="post" id="newsletter_form">
            <div class="input-group w-70">
              <input type="text" id="newsletter_email" name="newsletter_email" class="form-control br-tl-3  br-bl-3 " placeholder="Email">
              <div class="input-group-append ">
                <!--<button type="button" id="newsletter_button" class="btn btn-primary br-tr-3  br-br-3"> Subscribe </button>-->
				  <input type="submit" id="newsletter_button" class="btn btn-primary br-tr-3  br-br-3" value="Subscribe">
              </div>
				<div class="alert alert-success" id="success_show" style="display: none;"></div>
				<div class="alert alert-danger" id="error_show" style="display: none;"></div>
            </div>   
			</form> <?php */?>        
          </div>
		  <div class="col-lg-2 col-md-12">
			  <h6>@lang('app.our_apps')</h6>
			  <hr class="deep-purple text-primary accent-2 mb-4 mt-0 d-inline-block mx-auto">
			  <p><a href="https://play.google.com/store/apps/details?id=com.app.souqtijari"><img src="{{ asset('images/playtore_icon.png') }}" title="@lang('app.android_app')"></a></p>
			  <p><a href="https://apps.apple.com/kw/app/souq-tijari-سوق-تجاري/id1443472346"><img src="{{ asset('images/app_store_icon.png') }}" title="@lang('app.ios_app')"></a></p>
		  </div>
        </div>
      </div>
    </div>
    <div class="bg-dark-purple text-white p-0">
      <div class="container">
        <div class="row d-flex">
          <div class="col-lg-12 col-sm-12 mt-3 mb-3 text-center "> @lang('app.copyright') © {{date('Y')}} <a href="#" class="fs-14 text-primary">{{env('APP_NAME')}}</a>. @lang('app.designed_by') <a href="https://smartlinks.tech/" class="fs-14 text-primary">@lang('app.smartlinks')</a> @lang('app.all_rights_reserved') </div>
        </div>
      </div>
    </div>
  </footer>
</section>
<!--Footer Section--> 

<!-- Back to top --> 
<a href="#top" id="back-to-top" ><i class="fa fa-rocket"></i></a>
<!-- JQuery js--> 
<script src="{{ asset('js/vendors/jquery-3.2.1.min.js') }}"></script> 
<!-- Bootstrap js --> 
<script src="{{ asset('plugins/bootstrap-4.3.1-dist/js/popper.min.js') }}"></script> 
@if(app()->getLocale() == 'en') 
<script src="{{ asset('plugins/bootstrap-4.3.1-dist/js/bootstrap.min.js') }}"></script> 
@endif
@if(app()->getLocale() == 'ar') 
<script src="{{ asset('plugins/bootstrap-4.3.1-dist/js/bootstrap-rtl.js') }}"></script> 
@endif 
<!--JQuery Sparkline Js--> 
<script src="{{ asset('js/vendors/jquery.sparkline.min.js') }}"></script> 
<!-- Circle Progress Js--> 
<script src="{{ asset('js/vendors/circle-progress.min.js') }}"></script> 
<!-- Star Rating Js--> 
<script src="{{ asset('plugins/rating/jquery.rating-stars.js') }}"></script> 
<!--Owl Carousel js --> 
<script src="{{ asset('plugins/owl-carousel/owl.carousel.js') }}"></script> 
<script src="{{ asset('plugins/Horizontal2/Horizontal-menu/horizontal.js') }}"></script> 
<!--Counters --> 
<script src="{{ asset('plugins/counters/counterup.min.js') }}"></script> 
<script src="{{ asset('plugins/counters/waypoints.min.js') }}"></script> 
<script src="{{ asset('plugins/counters/numeric-counter.js') }}"></script> 
<!--JQuery TouchSwipe js--> 
<script src="{{ asset('js/jquery.touchSwipe.min.js') }}"></script> 
<!--Select2 js --> 
<script src="{{ asset('plugins/select2/select2.full.min.js') }}"></script> 
<script src="{{ asset('js/select2.js') }}"></script> 
<!-- Cookie js --> 
<script src="{{ asset('plugins/cookie/jquery.ihavecookies.js') }}"></script> 
<script src="{{ asset('plugins/cookie/cookie.js') }}"></script> 
<!-- Ion.RangeSlider -->
<script src="{{ asset('plugins/jquery-uislider/jquery-ui.js') }}"></script>
<!-- Custom scroll bar Js--> 
<script src="{{ asset('plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js') }}"></script> 
<!--Showmore Js-->
<script src="{{ asset('js/jquery.showmore.js') }}"></script>
<script src="{{ asset('js/showmore.js') }}"></script>
<!-- sticky Js--> 
<script src="{{ asset('js/sticky.js') }}"></script> 
<!-- video --> 
<script src="{{ asset('plugins/video/jquery.vide.js') }}"></script> 
<!-- Swipe Js--> 
<script src="{{ asset('js/swipe.js') }}"></script> 
<!-- Scripts Js--> 
@if(app()->getLocale() == 'en') 
<script src="{{ asset('js/scripts2.js') }}"></script> 
@endif
@if(app()->getLocale() == 'ar') 
<script src="{{ asset('js/scripts2-rtl.js') }}"></script> 
@endif 
<!-- Custom Js--> 
<script src="{{ asset('js/custom.js') }}"></script>

<script>
$("#newsletter_form").on("submit", function (e) {
	var dataString = $(this).serialize();
	
	$.ajax({
		type: "POST",
		url: '{{ route("newsletter.submit", app()->getLocale()) }}',
		data: dataString,
		success: function (msg) {
			if(msg)			
			{
				$('#success_newsletter').show().html("@lang('app.subscription_done_successfully')");
				$('#error_newsletter').hide();
				$('#newsletter_email').val('');
			}		
		},
		error: function(xhr, status, error) 
		{
			$('#success_newsletter').hide();
			$('#error_newsletter').show();
			$("#error_newsletter").empty();
			$.each(xhr.responseJSON.errors, function (key, item)
			{
				$("#error_newsletter").append("<li class=''>"+item+"</li>")
			});
		}		
		/*error :function( data ) {
        if( data.status === 422 ) {
            var errors = $.parseJSON(data.responseText);
            $.each(errors, function (key, value) {
                // console.log(key+ " " +value);
            //$('#response').addClass("alert alert-danger");
				$('#error_show').show();

                if($.isPlainObject(value)) {
                    $.each(value, function (key, value) {                       
                        console.log(key+ " " +value);
                   // $('#response').show().append(value+"<br/>");
						$("#error_show").append("<li class=''>"+value+"</li>");

                    });
                }else{
                $('#response').show().append(value+"<br/>"); //this is my div with messages
                }
            });
          }
		}*/
	});
	e.preventDefault();
});
	
$("#login_popup").on("submit", function (e) {
var dataString = $(this).serialize();

$.ajax({
	type: "POST",
	url: '{{ route("user.login.popup", app()->getLocale()) }}',
	data: dataString,
	success: function (msg) {
		if(msg)			
		{
			$('#exampleModal').modal('hide');
			location.reload();
		}
		else
		{
			$('#error_show').html('@lang("app.check_your_login_details")');
			$('#error_show').show();
		}
	},
	error: function(xhr, status, error) 
	{
		//console.log(xhr.responseJSON.errors);
		$('#error_show').show();
		$("#error_show").empty();
		$.each(xhr.responseJSON.errors, function (key, item)
		{
			$("#error_show").append("<li class=''>"+item+"</li>")
		});
	}
});
e.preventDefault();
});
</script>
<?php /*?>DI CODE - End<?php */?>
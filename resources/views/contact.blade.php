<!--DI CODE - Start-->
@extends('layouts.app')

@section('content') 

@include('layouts.partials.front.breadcrumbs') 

<!--Contact-->
<div class="sptb bg-white mb-0 pb-0">
  <div class="container">
    <div class="row">
      <div class="col-lg-5 col-xl-4  col-md-12  d-block mb-7">
        <div class="section-title center-block text-center">
          <h2>@lang('app.contact_info')</h2>
        </div>
        <div class="row text-white">
			@if($settingsDetail->contact_mobile)
          <div class="col-12 mb-5">
            <div class="support-service bg-primary br-2 mb-4 mb-xl-0"> <i class="fa fa-phone"></i>
              <h6>{{ $settingsDetail->contact_mobile }}</h6>
              <P>@lang('app.free_support')</P>
            </div>
          </div>
			@endif
			@if($settingsDetail->contact_email)
          <div class="col-12 mb-5">
            <div class="support-service bg-warning br-2"> <i class="fa fa-envelope-o"></i>
              <h6>{{ $settingsDetail->contact_email }}</h6>
              <p>@lang('app.support_us')</p>
            </div>
          </div>
			@endif
			@if($settingsDetail->contact_address)
          <div class="col-12">
            <div class="support-service bg-secondary br-2 mb-4 mb-xl-0"> <i class="fa fa-map-marker"></i>
              <h6>{{ $settingsDetail->contact_address }}</h6>
              <p>@lang('app.our_address')</p>
            </div>
          </div>
			@endif
        </div>
      </div>
      <div class="col-lg-7 col-xl-8 col-md-12 d-block ">
        <div class="single-page" >
          <div class="col-lg-12  col-md-12 mx-auto d-block">
            <div class="section-title center-block text-center">
              <h2>@lang('app.contact_form')</h2>
            </div>
            <div class="wrapper wrapper2">
              <div class="card mb-0">
                <div class="card-body">
					<form method="post" action="{{ route('contact.submit', app()->getLocale()) }}" name="contactFrm" id="contactFrm" method="post" action="">
						@csrf
				    @if ($errors->any())
					<div class="alert alert-danger alert-dismissible fade show">
					  <ul>
						@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					  </ul>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
					</div>
					@endif
					@if ($message = Session::get('success'))
					<div class="alert alert-success alert-dismissible fade show"> <strong>{{ $message }}</strong>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
					</div>
					@endif
                  <div class="form-group">
                    <input type="text" class="form-control" name="name" id="name" placeholder="@lang('app.your_name')">
                  </div>
                  <div class="form-group">
                    <input type="email" class="form-control" name="email" id="emailas" placeholder="@lang('app.email_address')">
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" name="subject" id="subject" placeholder="@lang('app.subject')">
                  </div>
                  <div class="form-group">
                    <textarea class="form-control" name="message" id="message" rows="6" placeholder="@lang('app.message')"></textarea>
                  </div>
						<div id="html_element"></div>
      					<br>
                  <button type="submit" class="btn btn-primary center-block text-center" name="submit" id="submit">@lang('app.send_message')</button>
					</form>
					 <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
    </script>
				</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Contact--> 
@endsection 

@section('extra-scripts')
<!--<script src="https://www.google.com/recaptcha/api.js" async defer></script>
 <script>
   function onSubmit(token) {
	 document.getElementById("contactFrm").submit();
   }
 </script>-->
<script>
	var onloadCallback = function() {
        grecaptcha.render('html_element', {
          'sitekey' : '6LcV_mIaAAAAAP88YwozryoTGEYBdGTYUnGK8jYh'
        });
      };
</script>
@endsection
<!--DI CODE - End-->
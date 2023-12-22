<!--DI CODE - Start-->
@extends('layouts.app')

@section('content') 

@include('layouts.partials.front.breadcrumbs')

<!--Login-Section-->
<section class="sptb">
  <div class="container customerpage">
    <div class="row">
      <div class="col-lg-5 col-xl-4 col-md-6 d-block mx-auto">
        <div class="row">
          <div class="col-xl-12 col-md-12 col-md-12 register-right">
            <ul class="nav nav-tabs nav-justified mb-5 p-2 border" id="myTab" role="tablist">
              <li class="nav-item"> <a class="nav-link active m-1" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">@lang('app.login')</a> </li>
              <li class="nav-item"> <a class="nav-link m-1" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">@lang('app.register')</a> </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="single-page  w-100  p-0">
                  <div class="wrapper wrapper2">
                    <form method="post" action="{{ route('user.login.submit', app()->getLocale()) }}" id="login" class="card-body" tabindex="500">
						@csrf
                      <h3 class="pb-2">@lang('app.login')</h3>
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
						<input type="submit" name="submit" id="submit" value="@lang('app.login')" class="btn btn-primary btn-block">
						
						
						
                      <p class="mb-2"><a href="{{ route('userforgot', app()->getLocale()) }}" >@lang('app.forgot')</a></p>
                      <p class="text-dark mb-0">@lang('app.dont_have_account')<a id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" class="text-primary {{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-1">@lang('app.sign_up')</a></p>
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
              <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="single-page w-100  p-0">
                  <div class="wrapper wrapper2">					  
					<div class="alert alert-success" id="success_show" style="display: none;"></div>
                    <form method="post"  id="register_form" class="card-body" tabindex="500">						
                      <h3 class="pb-1">@lang('app.register')</h3>
						<div class="alert alert-danger" id="error_show" style="display: none;"></div>
                      <div class="name">
                        <input type="text" name="name" id="name" required>
                        <label>@lang('app.name')</label>
                      </div>
                      <div class="mobile">
                        <input type="text" name="mobile" id="mobile" required>
                        <label>@lang('app.mobile')</label>
                      </div>
                      <div class="email">
                        <input type="text" name="email" id="email">
                        <label>@lang('app.email')</label>
                      </div>
                      <div class="password">
                        <input type="password" name="regpassword" id="regpassword">
                        <label>@lang('app.password')</label>
                      </div>
                      <!--<div class="submit"> <a class="btn btn-primary btn-block" href="index.html">Register</a> </div>-->
						<input type="submit" name="registersubmit" id="registersubmit" value="@lang('app.register')" class="btn btn-primary btn-block">
                      <p class="text-dark mb-0">@lang('app.already_have_account')<a href="{{ route('userlogin', app()->getLocale()) }}" class="text-primary ml-1">@lang('app.sign_in')</a></p>
                    </form>
                    <?php /*?><hr class="divider">
                    <div class="pt-3 pb-3">
                      <div class="text-center">
                        <div class="btn-group mt-2 mb-2"> <a href="https://www.facebook.com/" class="btn btn-icon  brround"> <span class="fa fa-facebook"></span> </a> </div>
                        <div class="btn-group mt-2 mb-2"> <a href="https://www.google.com/gmail/" class="btn btn-icon brround"> <span class="fa fa-google"></span> </a> </div>
                        <div class="btn-group mt-2 mb-2"> <a href="https://twitter.com/" class="btn btn-icon brround"> <span class="fa fa-twitter"></span> </a> </div>
                      </div>
                    </div><?php */?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/Login-Section--> 

@endsection 
@section('extra-scripts')
<script>
$(document).ready(function() {
	// Obtain hash value from the url
	var hash = window.location.hash;
	// Try to find a nav-link with the hash
	var hashNavLink = $('.nav-link[href="'+hash+'"]');
	// If there is no link with the hash, take default link
	if (hashNavLink.length === 0) {	
		hashNavLink = $('.nav-link[href="#home"]');
	}
	else
	{
		$('.nav-link,.tab-pane').removeClass('active');
		$('#profile').addClass('active');
		hashNavLink.addClass('active');
		//$('#breadcrumb_title').text("{{ $titles['title'] }}");
	}
});

$("#register_form").on("submit", function (e) {
var dataString = $(this).serialize();

$.ajax({
	type: "POST",
	url: '{{ route("user.register.submit", app()->getLocale()) }}',
	data: dataString,
	success: function (msg) {
		if(msg)			
		{
			$('#success_show').show().html("@lang('app.registration_success')");
			$('#register_form').hide();
			$(function () {
			  setTimeout(function() {
				  //window.location.replace("../index.php");
				  window.location.href = '{{ route("home", app()->getLocale()) }}';
			  }, 5000);
			});
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
@endsection
<!--DI CODE - End-->
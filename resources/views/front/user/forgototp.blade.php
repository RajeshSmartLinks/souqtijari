<!--DI CODE - Start-->
@extends('layouts.app')

@section('content') 

@include('layouts.partials.front.breadcrumbs') 

<!--Forgot password-->
<section class="sptb">
  <div class="container">
    <div class="row">
      <div class="col-lg-5 col-xl-4 col-md-6 d-block mx-auto">
        <div class="single-page w-100 p-0" >
          <div class="wrapper wrapper2">
            <form method="post" action="{{ route('user.forgototp.submit', app()->getLocale()) }}" id="forgotpsd" class="card-body">
				@csrf
              <h3 class="pb-2">@lang('app.forgot')</h3>
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
              <div class="otp">
                <input type="text" name="otp" id="otp">
                <label>@lang('app.otp')</label>
              </div>
              <div class="password">
                <input type="password" name="password" id="password">
                <label>@lang('app.new_password')</label>
              </div>
              <div class="confirm_password">
                <input type="password" name="confirm_password" id="confirm_password">
                <label>@lang('app.confirm_password')</label>
              </div>
              <div class="submit"><input type="submit" name="submit" id="submit" value="@lang('app.send')" class="btn btn-primary btn-block"> </div>
              <div class="text-center text-dark mb-0"> <a href="{{ route('userlogin', app()->getLocale()) }}">@lang('app.forget_it_send')</a> </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/Forgot password--> 

@endsection 
<!--DI CODE - End-->
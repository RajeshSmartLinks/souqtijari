@extends('layouts.app')

@section('content')
<!--DI CODE - Start-->
<!--Breadcrumb-->

<section>
    <div class="bannerimg cover-image bg-background3" data-image-src="{{ asset('images/banners/banner2.jpg') }}">
      <div class="header-text mb-0">
        <div class="container">
          <div class="text-center text-white">
            <h1 class="" id="breadcrumb_title">Reset Password</h1>
            <ol class="breadcrumb text-center">
              <li class="breadcrumb-item"><a href="{{ route('home', app()->getLocale()) }}">@lang('app.home')</a></li>
                @if( isset($titles['breadcrumbs']))
              <li class="breadcrumb-item">Reset Password</li>
                @endif
              <li class="breadcrumb-item active text-white" id="breadcrumb_title" aria-current="page">Reset Password</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--Breadcrumb--> 
  


<!--Forgot password-->
<section class="sptb">
    <div class="container">
      <div class="row">
        <div class="col-lg-5 col-xl-4 col-md-6 d-block mx-auto">
          <div class="single-page w-100 p-0" >
            <div class="wrapper wrapper2">
                  <form method="post" action="{{ route('custom-password.update', app()->getLocale()) }}" id="forgotpsd" class="card-body">
                  @csrf
                <h3 class="pb-2"> Password Reset done successfully</h3>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/Forgot password--> 
@endsection

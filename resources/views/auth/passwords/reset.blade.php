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
  <!--DI CODE - End-->
{{-- <section class="sptb">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        <!--DI CODE - Start-->
                        <form method="POST" action="{{ route('password.update', app()->getLocale()) }}">
                        <!--DI CODE - End-->
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}


<!--Forgot password-->
<section class="sptb">
    <div class="container">
      <div class="row">
        <div class="col-lg-5 col-xl-4 col-md-6 d-block mx-auto">
          <div class="single-page w-100 p-0" >
            <div class="wrapper wrapper2">
              {{-- <form method="post" action="{{ route('user.forgot.submit', app()->getLocale()) }}" id="forgotpsd" class="card-body"> --}}
                  <form method="post" action="{{ route('custom-password.update', app()->getLocale()) }}" id="forgotpsd" class="card-body">
                  @csrf
                <h3 class="pb-2">Reset Password</h3>
                @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
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
                  <input type="hidden" name="token" value="{{ $token }}">
                <div class="email">
                    <label>@lang('app.email')</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  
                </div>
                <div class="email">
                    <label for="password" >{{ __('Password') }}</label>

                    <div >
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                      
                    </div>
                </div>
                <div class="email">
                    <label for="password-confirm">{{ __('Confirm Password') }}</label>

                    {{-- <div class="col-md-6"> --}}
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    {{-- </div> --}}
                </div>
{{-- 
                <div class="form-group row mb-0">

                        <button type="submit" class="btn btn-primary">
                            {{ __('Reset Password') }}
                        </button>
                </div> --}}
                <div class="submit"><input type="submit" name="submit" id="submit" value=" {{ __('Reset Password') }}" class="btn btn-primary btn-block"> </div>
                {{-- <div class="text-center text-dark mb-0"> <a href="{{ route('userlogin', app()->getLocale()) }}">@lang('app.forget_it_send')</a> </div> --}}
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/Forgot password--> 
@endsection

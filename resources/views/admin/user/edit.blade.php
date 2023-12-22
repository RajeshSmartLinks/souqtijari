@extends('layouts.admin-master')

@section('extrastyle') 
<!-- Drop Zone Styles -->
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/file-uploaders/dropzone.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/file-uploaders/dropzone.css')}}">
@endsection

@section('content')
<div class="app-content content">
  <div class="content-overlay"></div>
  <div class="header-navbar-shadow"></div>
  <div class="content-wrapper">
    <div class="content-header row">
      <x-admin-breadcrumb :title="$titles['title']"></x-admin-breadcrumb>
    </div>
    <div class="content-body"> 
      
      <!-- invoice functionality start -->
      <section class="invoice-print mb-1">
        <div class="row">
          <fieldset class="col-12 col-md-5 mb-1 mb-md-0">
            &nbsp;
          </fieldset>
          <?php /*?><div class="col-12 col-md-7 d-flex flex-column flex-md-row justify-content-end"> <a href = "{{route('user.verified', 'verified')}}"
            class = "btn btn-primary btn-print mb-1 mb-md-0" > < i
            class = "feather icon-list" > < /i>&nbsp;Go to List</a> </div><?php */?>
        </div>
      </section>
      
      <!-- Adding Form -->
      <section id="multiple-column-form" class="input-validation">
        <div class="row match-height">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">{{$titles['subTitle']}}</h4>
              </div>
			<form class="form-horizontal" action="{{route('user.update', $editUser->id)}}" method="post"  enctype="multipart/form-data" novalidate>
              <div class="card-content">				 
                <div class="card-body">
                  <hr>
                  <x-admin-error-list-show></x-admin-error-list-show>                  
                    @csrf
                    @method('PUT')
                    <div class="form-body">
						<div class="row">
							<div class="col-sm-6 col-md-6">
							  <div class="form-group">
								<label class="form-label">@lang('app.first_name')</label>
								  <?PHP 
								  if(empty($editUser->first_name)){
									  $name = $editUser->name;
								  }
								  else{
									  $name = $editUser->first_name;
								  }
								  ?>
								<input type="text" class="form-control" name="first_name" id="first_name" value="{{ $name }}" placeholder="@lang('app.first_name')" readonly>
							  </div>
							</div>
							<div class="col-sm-6 col-md-6">
							  <div class="form-group">
								<label class="form-label">@lang('app.last_name')</label>
								<input type="text" class="form-control" name="last_name" id="last_name" value="{{ $editUser->last_name }}" placeholder="@lang('app.last_name')" readonly>
							  </div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6 col-md-6">
							  <div class="form-group">
								<label class="form-label">@lang('app.email_address')</label>
								<input type="text" class="form-control" name="email" id="email" value="{{ $editUser->email }}" placeholder="@lang('app.email_address')" readonly>
							  </div>
							</div>
							<div class="col-sm-6 col-md-6">
							  <div class="form-group">
								<label class="form-label">@lang('app.mobile')</label>
								<input type="text" class="form-control" name="mobile" id="mobile" value="{{ $editUser->mobile }}" placeholder="@lang('app.mobile')" readonly>
							  </div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6 col-md-6">
							  <div class="form-group">
								<label class="form-label">@lang('app.whatsapp')</label>
								<input type="text" class="form-control" name="whatsapp" id="whatsapp" value="{{ $editUser->whatsapp }}" placeholder="@lang('app.whatsapp')" readonly>
							  </div>
							</div>
							<?php /*?><div class="col-sm-6 col-md-6">
							  <div class="form-group">
								<label class="form-label">&nbsp;</label>
								<label class="custom-control custom-checkbox mb-3">
								  <input type="checkbox" class="custom-control-input" name="ad_phone_whatsapp" id="ad_phone_whatsapp" {{ $editUser->mobile == $editUser->whatsapp ? 'checked=""' : '' }}>
								  <span class="custom-control-label">@lang('app.whatsapp_mobile')</span> </label>
							  </div>
							</div><?php */?>
							<div class="col-sm-6 col-md-6">
							  <div class="form-group">
								<label class="form-label">@lang('app.address')</label>
								<input type="text" class="form-control" name="address" id="address" value="{{ $editUser->address }}" placeholder="@lang('app.address')" readonly>
							  </div>
							</div>							
						</div>
						<div class="row">
							<div class="col-sm-6 col-md-6">
							  <div class="form-group">
								<label class="form-label">@lang('app.facebook')</label>
								<input type="text" class="form-control" name="facebook" id="facebook" value="{{ $editUser->facebook }}" placeholder="https://www.facebook.com/" readonly>
							  </div>
							</div>
							<div class="col-sm-6 col-md-6">
							  <div class="form-group">
								<label class="form-label">@lang('app.twitter')</label>
								<input type="text" class="form-control" name="twitter" id="twitter" value="{{ $editUser->twitter }}" placeholder="https://twitter.com/" readonly>
							  </div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6 col-md-6">					
							  <div class="form-group">
								<label class="form-label">@lang('app.gender')</label>					  
								  <div class="custom-controls-stacked d-md-flex">
									  <?PHP 
//									  if($editUser->gender=='male'){echo trans('app.male');}
//									  elseif($editUser->gender=='female'){echo trans('app.female');}
									  ?>
									  @if($editUser->gender=='male')
									  <label class="custom-control custom-radio mr-4">
										<input type="radio" class="custom-control-input" name="gender" id="gender" value="male" {{ $editUser->gender=='male' ? 'checked' : '' }}>
										<span class="custom-control-label">@lang('app.male')</span>
									  </label>
									  @endif
									  @if($editUser->gender=='female')
									  <label class="custom-control custom-radio mr-4">
										<input type="radio" class="custom-control-input" name="gender" id="gender" value="female" {{ $editUser->gender=='female' ? 'checked' : '' }}>
										<span class="custom-control-label">@lang('app.female')</span>
									  </label>
									  @endif
								  </div>
							  </div>
							</div>
							<div class="col-sm-6 col-md-6">
							  <div class="form-group">
								<label class="form-label">Avatar</label>
								  @inject('user', 'App\Models\User')
								<img id="show_image" src="{{ !empty($editUser->avatar) ? asset($user::$imageThumbUrl . $editUser->avatar) : asset($user::$noImageUrl)  }}" width="50px;" height="50px;"> </div>
							</div>
						</div>
                </div>					 
              </div>
				<div class="card-header">
				  <h3 class="card-title">@lang('app.password_change')</h3>
				</div>
				<div class="card-body">
				  <div class="row">
					<div class="col-sm-6 col-md-6">
					  <div class="form-group">
						<label class="form-label">@lang('app.password')</label>
						<input type="password" class="form-control" name="password" id="password">
					  </div>
					</div>
					<div class="col-sm-6 col-md-6">
					  <div class="form-group">
						<label class="form-label">@lang('app.confirm_password')</label>
						<input type="password" class="form-control" name="confirm_password" id="confirm_password">
					  </div>
					</div>
				  </div>
				</div>
				 <div class="col-md-8 offset-md-4">
					<button type="submit" class="btn btn-primary mr-1 mb-1">Save </button>
				  </div>
				</div>
			</form>
            </div>
          </div>
        </div>
      </section>
      
      <!-- Adding Form Ends --> 
      
    </div>
  </div>
</div>
@endsection


@section('scripts') 

<!-- BEGIN: Page Vendor JS--> 
<script src="{{asset('vendors/js/extensions/dropzone.min.js')}}"></script> 
<script src="{{asset('vendors/js/ui/prism.min.js')}}"></script> 
<script src="{{asset('js/scripts/extensions/dropzone.js')}}"></script> 
<!-- END: Page Vendor JS--> 

<script>
        @if(session('success'))
        toastr.success('{{session('success')}}', 'Success');
        @endif
        @if(session('error'))
        toastr.error('{{session('error')}}', 'Error');
        @endif
    </script> 
@endsection
<!--DI CODE - Start-->
@extends('layouts.app')

@section('content') 

@include('layouts.partials.front.breadcrumbs') 

<!--User Dashboard-->
<section class="sptb">
  <div class="container">
    <div class="row"> @include('layouts.partials.front.sidebar')
      <div class="col-xl-9 col-lg-12 col-md-12">
        <div class="card mb-0">
          <div class="card-header">
            <h3 class="card-title">@lang('app.edit_profile')</h3>
          </div>
          <form method="POST" action="{{ route('user.update.submit', app()->getLocale()) }}" enctype="multipart/form-data">
            @csrf
            <?php /*?>@method('PUT')<?php */?>
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
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6 col-md-6">
                  <div class="form-group">
                    <label class="form-label">@lang('app.first_name')</label>
					  <?PHP 
					  if(empty($data['first_name'])){
						  $name = $data['name'];
					  }
					  else{
						  $name = $data['first_name'];
					  }
					  ?>
                    <input type="text" class="form-control" name="first_name" id="first_name" value="{{ $name }}" placeholder="@lang('app.first_name')">
                  </div>
                </div>
                <div class="col-sm-6 col-md-6">
                  <div class="form-group">
                    <label class="form-label">@lang('app.last_name')</label>
                    <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $data['last_name'] }}" placeholder="@lang('app.last_name')">
                  </div>
                </div>
                <div class="col-sm-6 col-md-6">
                  <div class="form-group">
                    <label class="form-label">@lang('app.email_address')</label>
                    <input type="text" class="form-control" name="email" id="email" value="{{ $data['email'] }}" placeholder="@lang('app.email_address')">
                  </div>
                </div>
                <div class="col-sm-6 col-md-6">
                  <div class="form-group">
                    <label class="form-label">@lang('app.mobile')</label>
                    <input type="text" class="form-control" name="mobile" id="mobile" value="{{ $data['mobile'] }}" placeholder="@lang('app.mobile')" readonly>
                  </div>
                </div>
                <div class="col-sm-6 col-md-6">
                  <div class="form-group">
                    <label class="form-label">@lang('app.whatsapp')</label>
                    <input type="text" class="form-control" name="whatsapp" id="whatsapp" value="{{ $data['whatsapp'] }}" placeholder="@lang('app.whatsapp')" >
                  </div>
                </div>
                <div class="col-sm-6 col-md-6">
                  <div class="form-group">
                    <label class="form-label">&nbsp;</label>
                    <label class="custom-control custom-checkbox mb-3">
                      <input type="checkbox" class="custom-control-input" name="ad_phone_whatsapp" id="ad_phone_whatsapp" {{ $data['mobile'] == $data['whatsapp'] ? 'checked=""' : '' }}>
                      <span class="custom-control-label">@lang('app.whatsapp_mobile')</span> </label>
                  </div>
                </div>
                <div class="col-sm-6 col-md-6">					
                  <div class="form-group">
                    <label class="form-label">@lang('app.gender')</label>					  
					  <div class="custom-controls-stacked d-md-flex">					  
						  <label class="custom-control custom-radio mr-4">
							<input type="radio" class="custom-control-input" name="gender" id="gender" value="male" {{ $data['gender']=='male' ? 'checked' : '' }}>
							<span class="custom-control-label">@lang('app.male')</span>
						  </label>
						  <label class="custom-control custom-radio mr-4">
							<input type="radio" class="custom-control-input" name="gender" id="gender" value="female" {{ $data['gender']=='female' ? 'checked' : '' }}>
							<span class="custom-control-label">@lang('app.female')</span>
						  </label>
					  </div>
				  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-label">@lang('app.address')</label>
                    <input type="text" class="form-control" name="address" id="address" value="{{ $data['address'] }}" placeholder="@lang('app.address')">
                  </div>
                </div>
                <?php /*?>
				<div class="col-sm-6 col-md-4">
				  <div class="form-group">
					<label class="form-label">City</label>
					<input type="text" class="form-control" placeholder="City">
				  </div>
				</div>
				<div class="col-sm-6 col-md-3">
				  <div class="form-group">
					<label class="form-label">Postal Code</label>
					<input type="number" class="form-control" placeholder="ZIP Code">
				  </div>
				</div>
				<div class="col-md-5">
				  <div class="form-group">
					<label class="form-label">Country</label>
					<select class="form-control select2-show-search border-bottom-0 w-100 select2-show-search" data-placeholder="Select">
					  <optgroup label="Categories">
						<option>--Select--</option>
						<option value="1">Germany</option>
						<option value="2">Real Estate</option>
						<option value="3">Canada</option>
						<option value="4">Usa</option>
						<option value="5">Afghanistan</option>
						<option value="6">Albania</option>
						<option value="7">China</option>
						<option value="8">Denmark</option>
						<option value="9">Finland</option>
						<option value="10">India</option>
						<option value="11">Kiribati</option>
						<option value="12">Kuwait</option>
						<option value="13">Mexico</option>
						<option value="14">Pakistan</option>
					  </optgroup>
					</select>
				  </div>
				</div>
                <?php */?>
                <div class="col-sm-6 col-md-6">
                  <div class="form-group">
                    <label class="form-label">@lang('app.facebook')</label>
                    <input type="text" class="form-control" name="facebook" id="facebook" value="{{ $data['facebook'] }}" placeholder="https://www.facebook.com/">
                  </div>
                </div>
                <div class="col-sm-6 col-md-6">
                  <div class="form-group">
                    <label class="form-label">@lang('app.twitter')</label>
                    <input type="text" class="form-control" name="twitter" id="twitter" value="{{ $data['twitter'] }}" placeholder="https://twitter.com/">
                  </div>
                </div>
                <?php /*?>
				<div class="col-md-12">
				  <div class="form-group">
					<label class="form-label">About Me</label>
					<textarea rows="5" class="form-control" placeholder="Enter About your description"></textarea>
				  </div>
				</div>
                <?php */?>
                <div class="col-md-12">
                  <div class="form-group mb-0">
                    <label class="form-label">@lang('app.upload_image')</label>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="avatar" id="avatar" onchange="document.getElementById('show_image').src = window.URL.createObjectURL(this.files[0])">
                      <label class="custom-file-label">@lang('app.choose_file')</label>
                    </div>
                  </div>
                </div>
                @if(!empty($data['avatar']))
                <div class="col-sm-6 col-md-6">
                  <div class="form-group">
                    <label class="form-label"></label>
                    <img id="show_image" src="{{ $data['avatar'] }}" width="50px;" height="50px;"> </div>
                </div>
                @endif </div>
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
            <div class="card-footer">
              <input type="submit" name="submit" id="submit" class="btn btn-primary" value="@lang('app.update_profile')">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/User Dashboard--> 
@endsection 

@section('extra-scripts') 
<script>
$('#ad_phone_whatsapp').change( function(){
	if ($('#ad_phone_whatsapp').is(':checked'))
	{
		$('#whatsapp').val($('#mobile').val());
	}
	else
	{
		$('#whatsapp').val("");
	}
});
</script> 
@endsection 
<!--DI CODE - End-->
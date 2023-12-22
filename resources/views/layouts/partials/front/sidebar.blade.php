<!--DI CODE - Start-->
<div class="col-xl-3 col-lg-12 col-md-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">@lang('app.my_dashboard')</h3>
    </div>
    <div class="card-body text-center item-user border-bottom">
      <div class="profile-pic">
        <div class="profile-pic-img"> <span class="bg-success dots" data-toggle="tooltip" data-placement="top" title="online"></span> <img src="{{ userdetails()['user_avatar'] }}" class="brround" alt="user"> </div>
        <a href="#" class="text-dark">
        <h4 class="mt-3 mb-0 font-weight-semibold">{{ userdetails()['user_full_name'] }}</h4>
        </a> </div>
    </div>
    <div class="item1-links  mb-0">
		<a href="{{ route('user.dashboard', app()->getLocale()) }}" class="{{ \Request::route()->getName() == 'user.dashboard' ? 'active' : ''  }} d-flex border-bottom"> <span class="icon1 {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-3"><i class="icon icon-user"></i></span> @lang('app.edit_profile') </a> 
		<a href="{{ route('createad', app()->getLocale()) }}" class="d-flex  border-bottom"> <span class="icon1 {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-3"><i class="icon icon-folder-alt"></i></span> @lang('app.adpost') </a>
		<a href="{{ route('user.ads', app()->getLocale()) }}" class="{{ \Request::route()->getName() == 'user.ads' ? 'active' : ''  }} d-flex  border-bottom"> <span class="icon1 {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-3"><i class="icon icon-diamond"></i></span> @lang('app.myads') </a> 
		<a href="{{ route('user.favourites', app()->getLocale()) }}" class="{{ \Request::route()->getName() == 'user.favourites' ? 'active' : ''  }} d-flex border-bottom"> <span class="icon1 {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-3"><i class="icon icon-heart"></i></span> @lang('app.myfavourites') </a> 
		
		<!--<a href="manged.html" class="d-flex  border-bottom"> <span class="icon1 {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-3"><i class="icon icon-folder-alt"></i></span> Managed Ads </a>
		<a href="payments.html" class=" d-flex  border-bottom"> <span class="icon1 {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-3"><i class="icon icon-credit-card"></i></span> Payments </a> 
		<a href="orders.html" class="d-flex  border-bottom"> <span class="icon1 {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-3"><i class="icon icon-basket"></i></span> Orders </a> 
		<a href="tips.html" class="d-flex border-bottom"> <span class="icon1 {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-3"><i class="icon icon-game-controller"></i></span> Safety Tips </a>
		<a href="settings.html" class="d-flex border-bottom"> <span class="icon1 {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-3"><i class="icon icon-settings"></i></span> Settings </a>-->
		<form id="logout-form" action="{{ route('logout', app()->getLocale()) }}" method="POST" >
		@csrf
		<a href="javascript:void(0)" onclick="$('#logout-form').submit()" class="d-flex"> <span class="icon1 {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-3"><i class="icon icon-power"></i></span> @lang('app.log_out') </a> </div>
		</form>		
  </div>
  <?php /*?><div class="card my-select">
    <div class="card-header">
      <h3 class="card-title">Search Ads</h3>
    </div>
    <div class="card-body">
      <div class="form-group">
        <input type="text" class="form-control" id="text" placeholder="What are you looking for?">
      </div>
      <div class="form-group">
        <select name="country" id="select-countries" class="form-control custom-select select2-show-search">
          <option value="1" selected="">All Categories</option>
          <option value="2">RealEstate</option>
          <option value="3">Restaurant</option>
          <option value="4">Beauty</option>
          <option value="5">Jobs</option>
          <option value="6">Services</option>
          <option value="7">Vehicle</option>
          <option value="8">Education</option>
          <option value="9">Electronics</option>
          <option value="10">Pets &amp; Animals</option>
          <option value="11">Computer</option>
          <option value="12">Mobile</option>
          <option value="13">Events</option>
          <option value="14">Travel</option>
          <option value="15">Clothing</option>
        </select>
      </div>
      <div class=""> <a href="#" class="btn  btn-primary">Search</a> </div>
    </div>
  </div><?php */?>
  <div class="card mb-xl-0">
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
<!--DI CODE - End-->
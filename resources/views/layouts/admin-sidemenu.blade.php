<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
  <div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
      <li class="nav-item mr-auto"><a class="navbar-brand"
                                            href="{{route('admin.dashboard')}}">
        <div class="brand-logo"></div>
        <h2 class="brand-text mb-0">{{env('APP_NAME')}}</h2>
        </a></li>
      <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"
                                               href="{{route('admin.dashboard')}}"><i
                        class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i
                        class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary"
                        data-ticon="icon-disc"></i></a></li>
    </ul>
  </div>
  <div class="shadow-bottom"></div>
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
      <li class="nav-item {{$current_route_name == 'admin.dashboard' ? 'active' : '' }}"><a
                    href="{{route('admin.dashboard')}}"><i class="feather icon-home"></i><span
                        class="menu-title"
                        data-i18n="Dashboard">Dashboard</span></a> </li>
      @can('operator-view')
      <li class=" navigation-header"><span>Operator</span></li>
      <li class=" nav-item {{in_array($current_route_name, ['operator.index', 'operator.edit']) ? 'active' : ''}}"> <a href="{{route('operator.index')}}"><i class="feather icon-user"></i><span
                            class="menu-title"
                            data-i18n="Email">Manage Operator</span></a> </li>
      @endcan
      <li class=" navigation-header"><span>Essentials</span></li>
      <li class="nav-item {{$current_route_name == 'category.index' ? 'active' : '' }}"><a
                    href="{{route('category.index')}}"><i class="feather icon-activity"></i><span
                        class="menu-title"
                        data-i18n="Email">Category</span></a> </li>
      <li class="nav-item {{$current_route_name == 'brand.index' ? 'active' : '' }}"><a
                    href="{{route('brand.index')}}"><i class="feather icon-tag"></i><span
                        class="menu-title"
                        data-i18n="Brand">Brand</span></a> </li>
      <li class=" navigation-header"><span>Location</span></li>
      <li class="nav-item {{$current_route_name == 'area.index' ? 'active' : '' }}"><a
                    href="{{route('area.index')}}"><i class="feather icon-map-pin"></i><span
                        class="menu-title"
                        data-i18n="State">Area</span></a> </li>
	  <!--DI CODE - Start-->
      <li class="navigation-header"><span>Registered User</span></li>
      <li class="nav-item {{$current_route_name == 'user.index' ? 'active' : '' }}"><a href="{{route('user.index')}}"><i class="feather icon-user-check"></i><span class="menu-title" data-i18n="Brand">User</span></a> </li>
      <li class="nav-item {{$current_route_name == 'userblocklist' ? 'active' : '' }}"><a href="{{route('userblocklist')}}"><i class="feather icon-user-x"></i><span class="menu-title" data-i18n="Brand">Blocked User</span></a> </li>
      
      <li class=" navigation-header"><span>Ads Management</span></li>
		@if ($current_route_name == 'adlist' || $current_route_name == 'adblocklist' || $current_route_name == 'ad.index' || $current_route_name == 'ad.edit')
			@php
				$active = 'active';
				$open = 'open';
			@endphp
		@else
			@php
				$active = '';
				$open = '';
			@endphp
		@endif
      <li class=" nav-item {{$open}}"> <a href="#" class="{{$active}}"><i  class="feather icon-anchor"></i><span class="menu-title" data-i18n="User">Ads</span></a>
        <ul class="menu-content">
          <li><a href="{{route('adlist')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Shop">List Ads</span></a> </li>
          <li><a href="{{route('ad.index')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Shop">Post Ads</span></a> </li>
          <li><a href="{{route('adblocklist')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Shop">Blocked Ads</span></a> </li>
        </ul>
      </li>
		
	  <li class="navigation-header"><span>Newsletter</span></li>
      <li class="nav-item {{$current_route_name == 'newsletter' ? 'active' : '' }}"><a href="{{route('newsletter')}}"><i class="feather icon-user-check"></i><span class="menu-title" data-i18n="Brand">Newsletter</span></a> </li>
		
      <li class=" navigation-header"><span>FAQ</span></li>
      <li class="nav-item {{$current_route_name == 'faq.index' ? 'active' : '' }}"><a href="{{route('faq.index')}}"><i class="feather icon-map-pin"></i><span class="menu-title" data-i18n="State">Faq</span></a> </li>
	  <li class=" navigation-header"><span>Push Notification</span></li>
		@if ($current_route_name == 'notification.index' || $current_route_name == 'notification.edit')
			@php($push_active = 'active')
		@else
			@php($push_active = '')
		@endif
      <li class="nav-item {{$push_active}}"><a href="{{route('notification.index')}}"><i class="feather icon-map-pin"></i><span class="menu-title" data-i18n="State">Push Notification</span></a> </li>
		
	   <?php /*?>@if(auth()->user()->hasRole('admin'))<?php */?>
			<li class="navigation-header"><span>Manage News</span></li>

			<li class=" nav-item">
				<a href="#"
				   class="{{ in_array($current_route_name ?? '', ['post.index', 'post.create', 'post.edit']) ? 'active' : '' }}"><i
						class="feather icon-archive"></i><span class="menu-title"
															   data-i18n="User">News</span></a>
				<ul class="menu-content">
					<li><a href="{{route('post.index')}}"><i class="feather icon-circle"></i><span
								class="menu-item"
								data-i18n="Shop">List News</span></a>
					</li>
				</ul>
			</li>
		<?php /*?>@endif<?php */?>

		<?php /*?>@if(auth()->user()->hasRole('admin'))<?php */?>
			<li class="nav-item {{ in_array($current_route_name ?? '', ['content.index', 'content.create', 'content.edit']) ? 'active' : '' }}"><a
					href="{{route('content.index')}}"><i class="feather icon-list"></i><span
						class="menu-title"
						data-i18n="Dashboard">Content Page</span></a>

			</li>
		<?php /*?>@endif<?php */?>
      <!--DI CODE - End-->
      <li class=" navigation-header"><span>Contacts</span></li>
      <li class="nav-item {{ $current_route_name == 'contactinfo'  ? 'active' : '' }}"> <a href="{{route('contactinfo')}}"><i class="feather icon-info"></i><span
                        class="menu-title"
                        data-i18n="General">Contact Information</span></a> </li>
      <li class="nav-item {{ $current_route_name == 'feedback'  ? 'active' : '' }}"> <a href="{{route('feedback')}}"><i class="feather icon-message-square"></i><span
                        class="menu-title"
                        data-i18n="General">Contact Messages</span></a> </li>
      <li class=" navigation-header"><span>Settings</span></li>
      <li class="nav-item {{ $current_route_name == 'admin.settings.show'  ? 'active' : '' }}"> <a href="{{route('admin.settings.show')}}"><i class="feather icon-settings"></i><span
                        class="menu-title"
                        data-i18n="General">General</span></a> </li>
      <!-- <li class="nav-item">
                <a href="#"><i class="feather icon-sliders"></i><span
                        class="menu-title"
                        data-i18n="General">Sliders</span></a>
            </li> -->
      <li class="nav-item {{in_array($current_route_name, ['role.index', 'role.edit']) ? 'active' : '' }}"><a
                    href="{{route('role.index')}}"><i class="feather icon-user-plus"></i><span
                        class="menu-title"
                        data-i18n="Roles">Roles</span></a> </li>
    </ul>
  </div>
</div>

<!--DI CODE - Start-->
@extends('layouts.app')

@section('content') 

@include('layouts.partials.front.breadcrumbs') 

<!--User Dashboard-->
<section class="sptb">
  <div class="container">
    <div class="row">
      @include('layouts.partials.front.sidebar') 
      <div class="col-xl-9 col-lg-12 col-md-12">
        <div class="card mb-0">
          <div class="card-header">
            <h3 class="card-title">@lang("app.myads")</h3>
          </div>
			@if ($message = Session::get('success'))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
			  {{ $message }}
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			@endif
          <div class="card-body">
            <div class="ads-tabs">
              <div class="tabs-menus"> 
                <!-- Tabs -->
                <ul class="nav panel-tabs">
                  <li class=""><a href="#tab1" class="active" data-toggle="tab">@lang('app.all_ads') ({{ @count($data['alluserads']) }})</a></li>
                  <li><a href="#tab2" data-toggle="tab">@lang('app.approved') ({{ @count($data['appproveduserads']) }})</a></li>
                  <li><a href="#tab3" data-toggle="tab">@lang('app.unapproved') ({{ @count($data['unappproveduserads']) }})</a></li>
                  <li><a href="#tab4" data-toggle="tab">@lang('app.featured') ({{ @count($data['featureduserads']) }})</a></li>
                </ul>
              </div>
              <div class="tab-content">	
				  <!--All Ads-->
                <div class="tab-pane active table-responsive border-top userprof-tab" id="tab1">
                  <table class="table table-bordered table-hover mb-0 text-wrap">
                    <thead>
                      <tr>
                        <!--<th></th>-->
                        <th>@lang('app.item')</th>
                        <th>@lang('app.category')</th>
                        <th>@lang('app.price_kd')</th>
                        <th>@lang('app.ad_status')</th>
                        <th width="15%">@lang('app.action')</th>
                      </tr>
                    </thead>
                    <tbody>
						@if(count($data['alluserads']) > 0)
						@foreach($data['alluserads'] as $alluserad)
                      <tr id="deleteclass_{{ $alluserad['id'] }}">
                        <!--<td><label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="checkbox" value="checkbox">
                            <span class="custom-control-label"></span> </label></td>-->
                        <td><div class="media mt-0 mb-0">
                            <div class="card-aside-img"> <a href="{{ route('viewad', [app()->getLocale(),$alluserad['slug']]) }}"></a> <!--<img src="{{ asset('images/products/h1.png') }}" alt="img">--><img src="{{ $alluserad['image'] }}" alt="{{ $alluserad['name'] }}"> </div>
							<br>
                            <div class="media-body">
                              <div class="card-item-desc {{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-4 p-0 mt-2"> <a href="{{ route('viewad', [app()->getLocale(),$alluserad['slug']]) }}" class="text-dark">
                                <h4 class="font-weight-semibold"> {{ $alluserad['name'] }} </h4>
                                </a> <a href="#"><i class="fa fa-clock-o {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{ $alluserad['createdate'] }}</a><br>
                                <!--<a href="#"><i class="fa fa-tag {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i>sale</a>--> </div>
                            </div>
                          </div></td>
                        <td>{{ $alluserad['category_name'] }} -> {{ $alluserad['sub_category_name'] }}</td>
                        <td class="font-weight-semibold fs-16">{{ $alluserad['price'] }}</td>
                        <td>
							@if( $alluserad['status'] == 1)
							<a href="#" class="badge badge-success">@lang('app.approved')</a>
							@else
							<a href="#" class="badge badge-primary">@lang('app.unapproved')</a>
							@endif
							@if( $alluserad['featured'] == 1)
							<br><br>
							<a href="#" class="badge badge-warning">@lang('app.featured')</a>
							@endif
							<!--<a href="#" class="badge badge-warning">Published</a>							
							<a href="#" class="badge badge-danger">Expired</a>
							<a href="#" class="badge badge-info">Sold</a>-->
						  </td>
                        <td><a href="{{ route('showedit', [app()->getLocale(),$alluserad['id']]) }}" class="btn btn-success btn-sm text-white" data-toggle="tooltip" data-original-title="@lang('app.edit')"><i class="fa fa-pencil"></i></a> <a onclick="onclickdelete({{ $alluserad['id'] }})" class="btn btn-danger btn-sm text-white" data-toggle="tooltip" data-original-title="@lang('app.delete')"><i class="fa fa-trash-o"></i></a> <!--<a class="btn btn-info btn-sm text-white" data-toggle="tooltip" data-original-title="Save to Wishlist"><i class="fa fa-heart-o"></i></a>--> <a href="{{ route('viewad', [app()->getLocale(),$alluserad['slug']]) }}" class="btn btn-primary btn-sm text-white" data-toggle="tooltip" data-original-title="@lang('app.view')"><i class="fa fa-eye"></i></a></td>
                      </tr>
						@endforeach
						@else
						<tr><td colspan="7">@lang('app.no_results')</td></tr>
						@endif
                    </tbody>
                  </table>
                </div>
				  <!--Approved Ads-->
                <div class="tab-pane  table-responsive border-top userprof-tab" id="tab2">
                  <table class="table table-bordered table-hover mb-0 text-wrap">
                    <thead>
                      <tr>
                        <!--<th></th>-->
                        <th>@lang('app.item')</th>
                        <th>@lang('app.category')</th>
                        <th>@lang('app.price_kd')</th>
                        <th>@lang('app.ad_status')</th>
                        <th width="15%">@lang('app.action')</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(count($data['appproveduserads']) > 0)
						@foreach($data['appproveduserads'] as $appproveduserad)
                      <tr id="deleteclassapprove_{{ $appproveduserad['id'] }}">
                        <!--<td><label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="checkbox" value="checkbox">
                            <span class="custom-control-label"></span> </label></td>-->
                        <td><div class="media mt-0 mb-0">
                            <div class="card-aside-img"> <a href="{{ route('viewad', [app()->getLocale(),$appproveduserad['slug']]) }}"></a> <!--<img src="{{ asset('images/products/h1.png') }}" alt="img">--><img src="{{ $appproveduserad['image'] }}" alt="{{ $appproveduserad['name'] }}"> </div>
							<br>
                            <div class="media-body">
                              <div class="card-item-desc {{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-4 p-0 mt-2"> <a href="{{ route('viewad', [app()->getLocale(),$appproveduserad['slug']]) }}" class="text-dark">
                                <h4 class="font-weight-semibold"> {{ $appproveduserad['name'] }} </h4>
                                </a> <a href="#"><i class="fa fa-clock-o {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{ $appproveduserad['createdate'] }}</a><br>
                                <!--<a href="#"><i class="fa fa-tag {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i>sale</a>--> </div>
                            </div>
                          </div></td>
                        <td>{{ $appproveduserad['category_name'] }} -> {{ $appproveduserad['sub_category_name'] }}</td>
                        <td class="font-weight-semibold fs-16">{{ $appproveduserad['price'] }}</td>
                        <td>
							@if( $appproveduserad['status'] == 1)
							<a href="#" class="badge badge-success">@lang('app.approved')</a>
							@else
							<a href="#" class="badge badge-primary">@lang('app.unapproved')</a>
							@endif
							<!--<a href="#" class="badge badge-warning">Published</a>
							<a href="#" class="badge badge-primary">featured</a							
							<a href="#" class="badge badge-danger">Expired</a>
							<a href="#" class="badge badge-info">Sold</a>-->
						  </td>
                        <td><a href="{{ route('showedit', [app()->getLocale(),$appproveduserad['id']]) }}" class="btn btn-success btn-sm text-white" data-toggle="tooltip" data-original-title="@lang('app.edit')"><i class="fa fa-pencil"></i></a> <a onclick="onclickdelete({{ $appproveduserad['id'] }})" class="btn btn-danger btn-sm text-white" data-toggle="tooltip" data-original-title="@lang('app.delete')"><i class="fa fa-trash-o"></i></a> <!--<a class="btn btn-info btn-sm text-white" data-toggle="tooltip" data-original-title="Save to Wishlist"><i class="fa fa-heart-o"></i></a>--> <a href="{{ route('viewad', [app()->getLocale(),$appproveduserad['slug']]) }}" class="btn btn-primary btn-sm text-white" data-toggle="tooltip" data-original-title="@lang('app.view')"><i class="fa fa-eye"></i></a></td>
                      </tr>
						@endforeach
						@else
						<tr><td colspan="7">@lang('app.no_results')</td></tr>
						@endif
                    </tbody>
                  </table>
                </div>
				  <!--Unapproved Ads-->
                <div class="tab-pane  table-responsive border-top userprof-tab" id="tab3">
                  <table class="table table-bordered table-hover  text-wrap mb-0">
                    <thead>
                      <tr>
                        <!--<th></th>-->
                        <th>@lang('app.item')</th>
                        <th>@lang('app.category')</th>
                        <th>@lang('app.price_kd')</th>
                        <th>@lang('app.ad_status')</th>
                        <th width="15%">@lang('app.action')</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(count($data['unappproveduserads']) > 0)
						@foreach($data['unappproveduserads'] as $unappproveduserad)
                      <tr id="deleteclassunapprove_{{ $unappproveduserad['id'] }}">
                        <!--<td><label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="checkbox" value="checkbox">
                            <span class="custom-control-label"></span> </label></td>-->
                        <td><div class="media mt-0 mb-0">
                            <div class="card-aside-img"> <a href="{{ route('viewad', [app()->getLocale(),$unappproveduserad['slug']]) }}"></a> <!--<img src="{{ asset('images/products/h1.png') }}" alt="img">--><img src="{{ $unappproveduserad['image'] }}" alt="{{ $unappproveduserad['name'] }}"> </div>
							<br>
                            <div class="media-body">
                              <div class="card-item-desc {{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-4 p-0 mt-2"> <a href="{{ route('viewad', [app()->getLocale(),$unappproveduserad['slug']]) }}" class="text-dark">
                                <h4 class="font-weight-semibold"> {{ $unappproveduserad['name'] }} </h4>
                                </a> <a href="#"><i class="fa fa-clock-o {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{ $unappproveduserad['createdate'] }}</a><br>
                                <!--<a href="#"><i class="fa fa-tag {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i>sale</a>--> </div>
                            </div>
                          </div></td>
                        <td>{{ $unappproveduserad['category_name'] }} -> {{ $unappproveduserad['sub_category_name'] }}</td>
                        <td class="font-weight-semibold fs-16">{{ $unappproveduserad['price'] }}</td>
                        <td>
							@if( $unappproveduserad['status'] == 1)
							<a href="#" class="badge badge-success">@lang('app.approved')</a>
							@else
							<a href="#" class="badge badge-primary">@lang('app.unapproved')</a>
							@endif
							<!--<a href="#" class="badge badge-warning">Published</a>
							<a href="#" class="badge badge-primary">featured</a							
							<a href="#" class="badge badge-danger">Expired</a>
							<a href="#" class="badge badge-info">Sold</a>-->
						  </td>
                        <td><a href="{{ route('showedit', [app()->getLocale(),$unappproveduserad['id']]) }}" class="btn btn-success btn-sm text-white" data-toggle="tooltip" data-original-title="@lang('app.edit')"><i class="fa fa-pencil"></i></a> <a onclick="onclickdelete({{ $unappproveduserad['id'] }})" class="btn btn-danger btn-sm text-white" data-toggle="tooltip" data-original-title="@lang('app.delete')"><i class="fa fa-trash-o"></i></a> <!--<a class="btn btn-info btn-sm text-white" data-toggle="tooltip" data-original-title="Save to Wishlist"><i class="fa fa-heart-o"></i></a>--> <a href="{{ route('viewad', [app()->getLocale(),$unappproveduserad['slug']]) }}" class="btn btn-primary btn-sm text-white" data-toggle="tooltip" data-original-title="@lang('app.view')"><i class="fa fa-eye"></i></a></td>
                      </tr>
						@endforeach
						@else
						<tr><td colspan="7">@lang('app.no_results')</td></tr>
						@endif
                    </tbody>
                  </table>
                </div>
				  <!--Featured Ads-->
				<div class="tab-pane  table-responsive border-top userprof-tab" id="tab4">
                  <table class="table table-bordered table-hover  text-wrap mb-0">
                    <thead>
                      <tr>
                        <!--<th></th>-->
                        <th>@lang('app.item')</th>
                        <th>@lang('app.category')</th>
                        <th>@lang('app.price_kd')</th>
                        <th>@lang('app.ad_status')</th>
                        <th width="15%">@lang('app.action')</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(count($data['featureduserads']) > 0)
						@foreach($data['featureduserads'] as $featureduserad)
                      <tr id="deleteclassfeature_{{ $featureduserad['id'] }}">
                        <!--<td><label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="checkbox" value="checkbox">
                            <span class="custom-control-label"></span> </label></td>-->
                        <td><div class="media mt-0 mb-0">
                            <div class="card-aside-img"> <a href="{{ route('viewad', [app()->getLocale(),$featureduserad['slug']]) }}"></a> <!--<img src="{{ asset('images/products/h1.png') }}" alt="img">--><img src="{{ $featureduserad['image'] }}" alt="{{ $featureduserad['name'] }}"> </div>
							<br>
                            <div class="media-body">
                              <div class="card-item-desc {{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-4 p-0 mt-2"> <a href="{{ route('viewad', [app()->getLocale(),$featureduserad['slug']]) }}" class="text-dark">
                                <h4 class="font-weight-semibold"> {{ $featureduserad['name'] }} </h4>
                                </a> <a href="#"><i class="fa fa-clock-o {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{ $featureduserad['createdate'] }}</a><br>
                                <!--<a href="#"><i class="fa fa-tag {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i>sale</a>--> </div>
                            </div>
                          </div></td>
                        <td>{{ $featureduserad['category_name'] }} -> {{ $featureduserad['sub_category_name'] }}</td>
                        <td class="font-weight-semibold fs-16">{{ $featureduserad['price'] }}</td>
                        <td>
							@if( $featureduserad['status'] == 1)
							<a href="#" class="badge badge-success">@lang('app.approved')</a>
							@else
							<a href="#" class="badge badge-primary">@lang('app.unapproved')</a>
							@endif
							<!--<a href="#" class="badge badge-warning">Published</a>
							<a href="#" class="badge badge-primary">featured</a							
							<a href="#" class="badge badge-danger">Expired</a>
							<a href="#" class="badge badge-info">Sold</a>-->
						  </td>
                        <td><a href="{{ route('showedit', [app()->getLocale(),$featureduserad['id']]) }}" class="btn btn-success btn-sm text-white" data-toggle="tooltip" data-original-title="@lang('app.edit')"><i class="fa fa-pencil"></i></a> <a onclick="onclickdelete({{ $featureduserad['id'] }})" class="btn btn-danger btn-sm text-white" data-toggle="tooltip" data-original-title="@lang('app.delete')"><i class="fa fa-trash-o"></i></a> <!--<a class="btn btn-info btn-sm text-white" data-toggle="tooltip" data-original-title="Save to Wishlist"><i class="fa fa-heart-o"></i></a>--> <a href="{{ route('viewad', [app()->getLocale(),$featureduserad['slug']]) }}" class="btn btn-primary btn-sm text-white" data-toggle="tooltip" data-original-title="@lang('app.view')"><i class="fa fa-eye"></i></a></td>
                      </tr>
						@endforeach
						@else
						<tr><td colspan="7">@lang('app.no_results')</td></tr>
						@endif
                    </tbody>
                  </table>
                </div>
				  
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/User Dashboard--> 
@endsection 

@section('extra-scripts')
<script>
function onclickdelete(id)
{
	if (confirm('@lang("app.are_you_sure")')) {
	//alert(id);
	$.ajax({
		//type: "POST",
		type: "GET",
		url: '{{ route("deletead", app()->getLocale()) }}',
		data: {'delete_id': id}
	}).done(function (result) {
		if(result)
		{
			$('#deleteclass_'+id).hide();
			$('#deleteclassapprove_'+id).hide();
			$('#deleteclassunapprove_'+id).hide();
			$('#deleteclassfeature_'+id).hide();
		}		
	});
	}
}
</script>
@endsection
<!--DI CODE - End-->
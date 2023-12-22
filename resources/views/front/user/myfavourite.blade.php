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
            <h3 class="card-title">@lang("app.myfavourites")</h3>
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
              
              <div class="tab-content">	
				  
                <div class="tab-pane active table-responsive border-top userprof-tab" id="tab1">
                  <table class="table table-bordered table-hover mb-0 text-nowrap">
                    <thead>
                      <tr>
                        <!--<th></th>-->
                        <th>@lang('app.item')</th>
                        <th>@lang('app.category')</th>
                        <th>@lang('app.price_kd')</th>
                        <th>@lang('app.action')</th>
                      </tr>
                    </thead>
                    <tbody>
						@if(count($data['alluserfavourites']) > 0)
						@foreach($data['alluserfavourites'] as $alluserfavourite)
                      <tr id="deleteclass_{{ $alluserfavourite['id'] }}">
                        <!--<td><label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="checkbox" value="checkbox">
                            <span class="custom-control-label"></span> </label></td>-->
                        <td><div class="media mt-0 mb-0">
                            <div class="card-aside-img"> <a href="{{ route('viewad', [app()->getLocale(),$alluserfavourite['slug']]) }}"></a> <!--<img src="{{ asset('images/products/h1.png') }}" alt="img">--><img src="{{ $alluserfavourite['image'] }}" alt="{{ $alluserfavourite['name'] }}"> </div>
							<br>
                            <div class="media-body">
                              <div class="card-item-desc {{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-4 p-0 mt-2"> <a href="{{ route('viewad', [app()->getLocale(),$alluserfavourite['slug']]) }}" class="text-dark">
                                <h4 class="font-weight-semibold"> {{ $alluserfavourite['name'] }} </h4>
                                </a> <a href="#"><i class="fa fa-clock-o {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i> {{ $alluserfavourite['createdate'] }}</a><br>
                                <!--<a href="#"><i class="fa fa-tag {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-1"></i>sale</a>--> </div>
                            </div>
                          </div></td>
                        <td>{{ $alluserfavourite['category_name'] }} -> {{ $alluserfavourite['sub_category_name'] }}</td>
                        <td class="font-weight-semibold fs-16">{{ $alluserfavourite['price'] }}</td>
                        <td><a href="{{ route('viewad', [app()->getLocale(),$alluserfavourite['slug']]) }}" class="btn btn-primary btn-sm text-white" data-toggle="tooltip" data-original-title="@lang('app.view')"><i class="fa fa-eye"></i></a></td>
                      </tr>
						@endforeach
						@else
						<tr><td colspan="4">@lang('app.no_results')</td></tr>
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
<!--DI CODE - End-->
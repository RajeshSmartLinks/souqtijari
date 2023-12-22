<!--DI CODE - Start-->
@extends('layouts.app')

@section('content') 

@include('layouts.partials.front.breadcrumbs') 


<!--Categories-->
<section class="sptb bg-white">
  <div class="container">
    <div class="section-title center-block text-center">
      <h2>@lang('app.categories')</h2>
      <!--<p>Mauris ut cursus nunc. Morbi eleifend, ligula at consectetur vehicula</p>-->
    </div>
    <div class="row">
		@foreach($data['categories'] as $category)
      <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card">
          <div class="item-card">
            <div class="item-card-desc"> <a href="{{ route('ad.category.list', [app()->getLocale(),$category['slug']]) }}"></a>
              <div class="item-card-img"> <img src="{{ $category['image'] }}" alt="img" class="br-tr-7 br-tl-7"> </div>
              <div class="item-card-text">
                <h4 class="mb-0">{{ $category['name'] }}<span>({{ $category['adsCountCategory'] }})</span></h4>
              </div>
            </div>
          </div>
        </div>
      </div>
		@endforeach
    </div>
  </div>
</section>
<!--/Categories--> 
@endsection 
<!--DI CODE - End-->
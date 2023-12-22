<!--DI CODE - Start-->
@extends('layouts.app')

@section('content') 

@include('layouts.partials.front.breadcrumbs') 

<!--Add listing-->
<section class="sptb">
  <div class="container">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="row">
			@if($lists->count() > 0)
			@foreach($lists as $list)
          <div class="col-xl-4 col-lg-6 col-md-12">
            <div class="card">
              <div class="item7-card-img max_min_height250"> <a href="{{route('news.detail', [ app()->getLocale(), $list->slug] ) }}"></a> <img src="{{ !empty($list->image_name) ? asset('uploads/post/'.$list->image_name) : asset('images/placeholder/noimage_homeblog.png') }}" alt="img" class="cover-image"><!--<img src="{{ asset('images/products/products/f1.jpg') }}" alt="img" class="cover-image">-->
                <!--<div class="item7-card-text"> <span class="badge badge-success">Restaurant</span> </div>-->
              </div>
              <div class="card-body">
                <div class="item7-card-desc d-flex mb-2"> <a href="#"><i class="fa fa-calendar-o text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2"></i>{{$list->created_at->diffForHumans()}}</a>
                  <!--<div class="{{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-auto"> <a href="#"><i class="fa fa-comment-o text-muted {{app()->getLocale() == 'en' ? 'mr' : 'ml'}}-2"></i>4 Comments</a> </div>-->
                </div>
                <a href="{{route('news.detail', [ app()->getLocale(), $list->slug] ) }}" class="text-dark">
                <h4 class="font-weight-semibold">{{$list->$aztitle}}</h4>
                </a>
                <p>{!! substr(strip_tags($list->$description), 0, 150) !!} ...</p>
                <a href="{{route('news.detail', [ app()->getLocale(), $list->slug] ) }}" class="btn btn-primary btn-sm">@lang('app.read_more')</a> </div>
            </div>
          </div>
			@endforeach
			@endif          
        </div>
        <div class="center-block text-center">
			{!! $lists->links() !!}
          <?php /*?><ul class="pagination mb-0">
            <li class="page-item page-prev disabled"> <a class="page-link" href="#" tabindex="-1">Prev</a> </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item page-next"> <a class="page-link" href="#">Next</a> </li>
          </ul><?php */?>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/Add listing--> 

@endsection 
<!--DI CODE - End-->
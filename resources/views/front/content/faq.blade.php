<!--DI CODE - Start-->
@extends('layouts.app')

@section('content') 

@include('layouts.partials.front.breadcrumbs') 

@if(count($data['faqs']) > 0)
<!--Faq section-->
<section class="sptb">
  <div class="container">
    <div class="panel-group1" id="accordion2">
		@foreach($data['faqs'] as $faq)
      <div class="panel panel-default mb-4 border p-0">
        <div class="panel-heading1">
          <h4 class="panel-title1"> <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse{{ $faq['slug'] }}" aria-expanded="false">{{ $loop->iteration }}. {{ $faq['title'] }}</a> </h4>
        </div>
        <div id="collapse{{ $faq['slug'] }}" class="panel-collapse collapse active" role="tabpanel" aria-expanded="false">
          <div class="panel-body bg-white">
             {!! $faq['description'] !!}
          </div>
        </div>
      </div>
		@endforeach
    </div>
  </div>
</section>
<!--/Faq section--> 
@endif
@endsection 
<!--DI CODE - End-->
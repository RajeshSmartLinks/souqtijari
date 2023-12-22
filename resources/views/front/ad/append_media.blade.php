<?php /*?>@if($ads_images->count() > 0)
    @foreach($ads_images as $img)
        <div class="creating-ads-img-wrap">
            <img src="{{ media_url($img, false) }}" class="img-responsive" />
            <div class="img-action-wrap" id="{{ $img->id }}">
                <a href="javascript:;" class="imgDeleteBtn"><i class="fa fa-trash-o"></i> </a>
                <a href="javascript:;" class="imgFeatureBtn"><i class="fa fa-star{{ $img->is_feature ==1 ? '':'-o' }}"></i> </a>
            </div>
        </div>
    @endforeach
@endif<?php */?>


@if(count($data['ads_images']) > 0)
@foreach($data['ads_images'] as $img)
<div class="p-2 border mb-4" id="media{{ $img['id'] }}">
  <div class="upload-images d-flex">
	<div> <!--<img src="{{ asset('images/products/h1.jpg') }}" alt="img" class="w73 h73 border p-0">--><img src="{{ $img['adimage_url'] }}" alt="{{ $img['adimage'] }}" class="w73 h73 border p-0"> </div>
	<div class="{{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-3 mt-2">
	  <h6 class="mb-0 mt-3 font-weight-bold">{{ $img['adimage'] }}</h6>
	  <!--<small>4.5kb</small>--> </div>
	<div class="float-{{app()->getLocale() == 'en' ? 'right' : 'left'}} {{app()->getLocale() == 'en' ? 'ml' : 'mr'}}-auto img-action-wrap" id="{{ $img['id'] }}">
		<a href="javascript:" data-id="{{ $img['id'] }}" class=" btn btn-icon btn-primary btn-sm mt-5 mr-2 imgFeatureBtn" ><i class="fa fa-star{{ $img['is_feature'] ==1 ? '':'-o' }}"></i></a>
		<a href="javascript:" data-id="{{ $img['id'] }}" class="float-right btn btn-icon btn-danger btn-sm mt-5 deleteMedia" ><i class="fa fa-trash-o"></i></a>
	</div>
  </div>
</div>
@endforeach
@endif
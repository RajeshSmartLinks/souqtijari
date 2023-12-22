<!--DI CODE - Start-->
@extends('layouts.admin-master')

@section('content')
<div class="app-content content">
  <div class="content-overlay"></div>
  <div class="header-navbar-shadow"></div>
  <div class="content-wrapper">
    <div class="content-header row">
      <x-admin-breadcrumb :title="$titles['title']"></x-admin-breadcrumb>
    </div>
    <div class="content-body"> 
      
      <!-- Adding Form -->
      <section id="multiple-column-form" class="bootstrap-select">
        <div class="row match-height">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">{{$titles['title']}}</h4>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <hr>
                  <x-admin-error-list-show></x-admin-error-list-show>
                  <form class="form" action="{{route('ad.update', $editAd->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-body">
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group row">
                            <div class="col-md-3"> <span>Choose Category</span> </div>
                            <div class="col-md-9">
                              <select name="ad_category_id" id="ad_category_id" class="form-control" required>
                                <option>Select Category</option>
                                @foreach($categories as $category)
                                    @if($category->child->count() > 0)                                
                                	<optgroup label="{{ $category->name_en }}">
                                        @foreach($category->child as $sub_category)
                                		<option value="{{ $sub_category->id }}" {{ $editAd->ad_sub_category_id == $sub_category->id ? 'selected="selected"' : '' }}>{{ $sub_category->name_en }}</option>
                                        @endforeach
                                    </optgroup>
                                    @endif
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group row">
                            <div class="col-md-3"> <span>Choose Brand</span> </div>
                            <div class="col-md-9">
                              <select name="ad_brand_id" id="ad_brand_id" class="form-control">
                                <option value="">Select Brand</option>
                                @foreach( $brands as $brand )
								<option value="{{ $brand->id }}" {{ $editAd->ad_brand_id == $brand->id ? 'selected="selected"' : '' }}>{{ $brand->name_en }}</option>
                                @endforeach 
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group row">
                            <div class="col-md-3"> <span>Ad Title</span> </div>
                            <div class="col-md-9">
                              <input type="text" name="ad_title" id="ad_title" class="form-control" placeholder="Ad Title" value="{{$editAd->ad_title}}" autocomplete="off" maxlength="40">
								<span>@lang('app.max_allowed_40')</span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group row">
                            <div class="col-md-3"> <span>Ad description</span> </div>
                            <div class="col-md-9">
                              <textarea name="ad_description" id="ad_description" class="form-control" rows="8" placeholder="Ad Description">{{$editAd->ad_description}}</textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group row">
                            <div class="col-md-3"> <span>Location</span> </div>
                            <div class="col-md-9">
                              <select name="ad_location_area" id="ad_location_area" class="form-control" required>
                                <option>Select Location</option>
                                @foreach($areas as $area)
                                    @if($area->child->count() > 0)
                                	<optgroup label="{{ $area->name_en }}">
                                        @foreach($area->child as $location_area)
                                		<option value="{{ $location_area->id }}" {{ $editAd->ad_location_area == $location_area->id ? 'selected="selected"' : '' }}>{{ $location_area->name_en }}</option>
                                        @endforeach
                                    </optgroup>
                                    @endif
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group row">
                            <div class="col-md-3"> <span>Condition</span> </div>
                            <div class="col-md-9">
                              <select name="ad_condition" id="ad_condition" class="form-control" required>
                                <option value="">Select Condition</option>
                                <option value="new" {{ $editAd->ad_condition == "new" ? 'selected="selected"' : '' }}>New</option>
                                <option value="used" {{ $editAd->ad_condition == "used" ? 'selected="selected"' : '' }}>Used</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group row">
                            <div class="col-md-3"> <span>Price</span> </div>
                            <div class="col-md-9">
                              <input type="text" placeholder="Ex. 15000" class="form-control" name="ad_price" id="ad_price" value="{{$editAd->ad_price}}">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group row">
                            <div class="col-md-3"> <span>Negotiable</span> </div>
                            <div class="col-md-9">
                              <input type="checkbox" value="1" name="ad_is_negotiable" id="ad_is_negotiable" {{ $editAd->ad_is_negotiable == "1" ? 'checked' : '' }}>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group row">
                            <div class="col-md-3"> <span>Seller Name</span> </div>
                            <div class="col-md-9">
                              <input type="text" name="ad_seller_name" id="ad_seller_name" class="form-control" placeholder="Seller Name" value="{{$editAd->ad_seller_name}}" autocomplete="off">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group row">
                            <div class="col-md-3"> <span>Seller Email</span> </div>
                            <div class="col-md-9">
                              <input type="text" name="ad_seller_email" id="ad_seller_email" class="form-control" placeholder="Seller Email" value="{{$editAd->ad_seller_email}}" autocomplete="off">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group row">
                            <div class="col-md-3"> <span>Seller Phone</span> </div>
                            <div class="col-md-9">
                              <label for="first-name-column">+965</label>
                              <input type="text" name="ad_seller_phone" id="ad_seller_phone" class="form-control" placeholder="Seller Phone" value="{{$editAd->ad_seller_phone}}" autocomplete="off">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group row">
                            <div class="col-md-3"> <span>Seller Address</span> </div>
                            <div class="col-md-9">
                              <input type="text" name="ad_seller_address" id="ad_seller_address" class="form-control" placeholder="Seller Address" value="{{$editAd->ad_seller_address}}" autocomplete="off">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group row">
                            <div class="col-md-3"> <span>Image</span> </div>
                            <div class="col-md-9">
								<div class="media-body mt-75">
									<div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
										<div class="dropzone dropzone-area" style="min-height: 0">
											<label class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer waves-effect waves-light" for="account-upload">Upload Image</label>
											<input type="file" multiple="multiple" name="ad_image[]" id="account-upload" placeholder="Ad Image" hidden="">
										</div>
									</div>
									<p class="text-muted ml-75 mt-50"><small>Allowed JPG, GIF or PNG. Dimention (740X440) | you can upload multiple Images</small></p>
								</div>
                            </div>
                          </div>
                        </div>
                      </div>
					@if($adsimages->count() > 0)
						<div class="row">
							@foreach($adsimages as $adsimage)
								<div class="col-3" id="media{{$adsimage->id}}">
									<div id='gallery-adm-images'>
										<div class="image">
											<img src="{{asset('uploads/ad/'.$adsimage->ads_image)}}" width="150"/> &nbsp;
											<a href="javascript:" data-id="{{$adsimage->id}}" class="deleteMedia"><span class="badge badge-danger badge-square"><i class="fa fa-trash"></i></span> </a>
										</div>
									</div>
								</div>
							@endforeach
						</div>
					@endif
                      <div>&nbsp;</div>
                      <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary mr-1 mb-1">Save </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
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
<script>
$('.zero-configuration').DataTable(
	{
		"displayLength": 50,
	}
);

@if(session('success'))
toastr.success('{{session('success')}}', 'Success');
@endif
@if(session('error'))
toastr.error('{{session('error')}}', 'Error');
@endif

$(document).ready(function(){
$('#ad_category_id').on("change", function(){
		//alert('test');
		var cat_id = $(this).val();

		$.ajax({
			//type: "POST",
			type: "GET",
			url: '{{ route("getbrand") }}',
			data: {'cat_id': cat_id}
		}).done(function (result) {
			if(result.length>0 || result == undefined || result == null){
				var new_res = $.parseJSON(result);
				$('#ad_brand_id').empty();
				$.each(new_res, function(key, value) {
					$("#ad_brand_id").append($("<option></option>").val(key).html(value)); 
				});					
			}
			else{
				$("#ad_brand_id").empty(); 
				//$("#ad_brand_id").html($("<option></option>").val().html("-- Brand --")); 
			}
		});
	});
});
	
 $('.deleteMedia').on("click", function () {
	delId = $(this).data('id');
	// alert(delId);
	 if (confirm('Please confirm to delete the image')) {
		$.ajax({
			url: '../../deleteMedia/' + delId,
			type: "GET",
			dataType: "json",
			success: function (data) {
				$('#media' + delId).fadeOut();
			},
		});
	} 
	
});
</script> 
@endsection 
<!--DI CODE - End-->
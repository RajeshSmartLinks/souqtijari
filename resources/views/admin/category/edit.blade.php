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
                                    <h4 class="card-title">Edit Category</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <hr>
                                        <x-admin-error-list-show></x-admin-error-list-show>

                                        <form class="form" action="{{route('category.update', $editCategory->id)}}"
                                              method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Choose Category</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select name="category_id" class="form-control"
                                                                        id="basicSelect">
                                                                    <option value="0">--Parent Category --</option>
                                                                    @foreach($parentCategories as $parentCategory)
                                                                        <option
                                                                            value="{{$parentCategory->id}}" {{ $editCategory->category_id == $parentCategory->id ? 'selected="selected"' : '' }}>{{$parentCategory->name_en}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="name_en" class="form-control"
                                                                   placeholder="Category Name(English)"
                                                                   name="name_en"
                                                                   value="{{$editCategory->name_en}}">
                                                            <label for="first-name-column">Category Name
                                                                (English)</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="name_ar" class="form-control"
                                                                   placeholder="Category Name(Arabic)"
                                                                   name="name_ar"
                                                                   value="{{$editCategory->name_ar}}">
                                                            <label for="first-name-column">Category Name
                                                                (Arabic)</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-12"></div>
													<!--DI CODE - Start-->
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-label-group">
                                                            <input type="file" id="image" class="form-control" placeholder="Category Icon" name="image">
                                                            <label for="first-name-column">Category Icon(250*250)</label>
                                                            <br/>
                                                            @if($editCategory->image)
                                                                <img src="{{$editCategory->image ? asset('uploads/category/'.$editCategory->image) : ''}}" width="60"/>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-label-group">
                                                            <input type="file" id="banner_image" class="form-control" placeholder="Category List Image" name="banner_image">
                                                            <label for="first-name-column">Category List Image(420*320)</label>
                                                            <br/>
                                                            @if($editCategory->banner_image)
                                                                <img src="{{$editCategory->banner_image ? asset('uploads/category/'.$editCategory->banner_image) : ''}}" width="60"/>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-label-group">
                                                            <input type="file" id="slide_image" class="form-control" placeholder="Category Slider Image" name="slide_image">
                                                            <label for="first-name-column">Category Slider Image(420*150)</label>
                                                            <br/>
                                                            @if($editCategory->slide_image)
															<span id="media{{ $editCategory->id }}">
                                                                <img src="{{$editCategory->slide_image ? asset('uploads/category/'.$editCategory->slide_image) : ''}}" width="60"  />
															<a href="javascript:" data-id="{{$editCategory->id}}" class="deleteCatSlide"><span class="badge badge-danger badge-square"><i class="fa fa-trash"></i></span> </a>
															</span>
                                                            @endif
                                                        </div>
                                                    </div>
													<!--DI CODE - End-->
                                                </div>

                                                <div>&nbsp;</div>
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Save
                                                    </button>
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
		
		
	 $('.deleteCatSlide').on("click", function () {
		delId = $(this).data('id');
		// alert(delId);
		 if (confirm('Please confirm to delete the image')) {
			$.ajax({
				url: '../../deleteCatSlide/' + delId,
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

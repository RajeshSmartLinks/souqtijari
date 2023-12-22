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

                                        <form class="form" action="{{route('brand.update', $brand->id)}}"
                                              method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
											<!--DI CODE - Start-->
											<div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <select name="category_id" class="form-control" required>
                                                                <option>-- Category --</option>
                                                                @foreach($categories as $category)
                                                                    @if($category->child->count() > 0)
                                                                        <optgroup label="{{ $category->name_en }}">
                                                                            @foreach($category->child as $sub_category)
                                                                                <option {{$brand->category_id==$sub_category->id ? 'selected' : ''}}
                                                                                    value="{{ $sub_category->id }}">{{ $sub_category->name_en }}</option>
                                                                            @endforeach
                                                                        </optgroup>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="name_en" class="form-control"
                                                                   placeholder="Brand Name(English)"
                                                                   name="name_en"
                                                                   value="{{$brand->name_en}}" autocomplete="off">
                                                            <label for="first-name-column">Brand Name
                                                                (English)</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="name_ar" class="form-control"
                                                                   placeholder="Brand Name(Arabic)"
                                                                   name="name_ar"
                                                                   value="{{$brand->name_ar}}" autocomplete="off">
                                                            <label for="first-name-column">Brand Name
                                                                (Arabic)</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-12"></div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-label-group">
                                                        <input type="file" id="image" class="form-control"
                                                               placeholder="Brand Image"
                                                               name="image">
                                                        <label for="first-name-column">Image(100*100)</label>
														<br/>
                                                            @if($brand->image)
															<span id="media{{ $brand->id }}">
                                                                <img src="{{$brand->image ? asset('uploads/brand/'.$brand->image) : ''}}" width="60"  />
															<!--<a href="javascript:" data-id="{{$brand->id}}" class="deleteCatSlide"><span class="badge badge-danger badge-square"><i class="fa fa-trash"></i></span> </a>-->
															</span>
                                                            @endif
                                                    </div>
                                                </div>
												
												


                                                <div>&nbsp;</div>
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Save
                                                    </button>
                                                </div>
                                            </div>
											
											
											
											
											
											
                                           <?php /*?> <div class="form-body">
                                                <div class="row">

                                                    <div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="name_en" class="form-control"
                                                                   placeholder="Brand Name(English)"
                                                                   name="name_en"
                                                                   value="{{$brand->name_en}}" autocomplete="off">
                                                            <label for="first-name-column">Category Name
                                                                (English)</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="name_ar" class="form-control"
                                                                   placeholder="Brand Name(Arabic)"
                                                                   name="name_ar"
                                                                   value="{{$brand->name_ar}}" autocomplete="off">
                                                            <label for="first-name-column">Category Name
                                                                (Arabic)</label>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-md-4 col-12"></div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-label-group">
                                                        <input type="file" id="image" class="form-control"
                                                               placeholder="Brand Image"
                                                               name="image">
                                                        <label for="first-name-column">Image(165*165)</label>
                                                    </div>
                                                </div>

                                                <div>&nbsp;</div>
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Save
                                                    </button>
                                                </div>
                                            </div><?php */?>
											<!--DI CODE - End-->
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

    </script>
@endsection

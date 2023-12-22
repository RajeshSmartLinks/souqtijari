@extends('layouts.admin-master')

@section('extrastyle')
    <!-- Drop Zone Styles -->
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/file-uploaders/dropzone.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/plugins/file-uploaders/dropzone.css')}}">

@endsection

@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <x-admin-breadcrumb :title="$title"></x-admin-breadcrumb>
            </div>
            <div class="content-body">

                <!-- invoice functionality start -->
                <section class="invoice-print mb-1">
                    <div class="row">
                        <fieldset class="col-12 col-md-5 mb-1 mb-md-0">&nbsp;</fieldset>
                        <div class="col-12 col-md-7 d-flex flex-column flex-md-row justify-content-end">
                            <a href="{{route('product.index')}}" class="btn btn-primary btn-print mb-1 mb-md-0"><i
                                    class="feather icon-list"></i>&nbsp;Go to List</a>
                            </a>
                        </div>
                    </div>
                </section>

                <!-- Adding Form -->
                <section id="multiple-column-form" class="input-validation">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$subTitle}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <hr>
                                        <x-admin-error-list-show></x-admin-error-list-show>


                                        <form class="form-horizontal" action="{{route('product.store')}}" method="post"
                                              enctype="multipart/form-data" novalidate>
                                            @csrf
                                            <div class="form-body">

                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-column">SKU Code</label>
                                                            <input type="text" id="sku" class="form-control"
                                                                   placeholder="SKU Code"
                                                                   name="sku"
                                                                   value="{{$skuCode}}" autocomplete="off" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-column">Title (English)</label>
                                                            <input type="text" id="title_en" class="form-control"
                                                                   placeholder="Title(English)"
                                                                   name="title_en"
                                                                   value="" autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-column">Title (Arabic)</label>
                                                            <input type="text" id="title_ar" class="form-control"
                                                                   placeholder="Title(Arabic)"
                                                                   name="title_ar"
                                                                   value="" autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="category">Category</label>
                                                            <select name="category_id" class="form-control"
                                                                    id="basicSelect" required>
                                                                <option value="">--Select Category --</option>
                                                                @if($categories->count() > 0)
                                                                    @foreach($categories as $category))
                                                                    <option
                                                                        value="{{$category->id}}">{{$category->name_en}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="category">Sub Category</label>
                                                            <select name="sub_category_id" class="form-control"
                                                                    id="basicSelect">
                                                                <option value="0">--Select Sub Category --</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="brand">Brand</label>
                                                            <select name="brand_id" class="form-control"
                                                                    id="basicSelect"
                                                                    required>
                                                                <option value="">-- Select Brand --</option>
                                                                @if($brands->count() > 0)
                                                                    @foreach($brands as $brand)
                                                                        <option
                                                                            value="{{$brand->id}}">{{$brand->name_en}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="country">Product Origin</label>
                                                            <select name="country_id" class="form-control"
                                                                    id="basicSelect"
                                                                    required>
                                                                <option value="">-- Select Origin --</option>
                                                                @if($countries->count() > 0)
                                                                    @foreach($countries as $country)
                                                                        <option
                                                                            value="{{$country->id}}">{{$country->name_en}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-column">Description (English)</label>
                                                            <textarea class="form-control" name="description_en"
                                                                      rows="10" placeholder="Description(English)"
                                                                      required>{{ old('description_en') }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-column">Description (Arabic)</label>
                                                            <textarea class="form-control" name="description_ar"
                                                                      rows="10" placeholder="Description(Arabic)"
                                                                      required>{{ old('description_ar') }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                            <!-- <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-column">Cost Price</label>
                                                            <input type="text" id="cost_price" class="form-control"
                                                                   placeholder="Cost Price"
                                                                   name="cost_price"
                                                                   value="{{ old('cost_price') }}" autocomplete="off"
                                                                   min="1" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-column">Price</label>
                                                            <input type="text" id="price" class="form-control"
                                                                   placeholder="Price"
                                                                   name="price"
                                                                   value="{{ old('price') }}" autocomplete="off" min="1"
                                                                   required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-column">Offer Price</label>
                                                            <input type="text" id="offer_price" class="form-control"
                                                                   placeholder="Offer Price"
                                                                   name="offer_price"
                                                                   value="{{ old('offer_price') }}" autocomplete="off"
                                                                   min="0">
                                                        </div>
                                                    </div>
                                                </div> -->

                                                <h3>Product Stocks</h3>

                                                @if($units->count() > 0)
                                                    @foreach($units as $unit)
                                                        <div class="row">
                                                            <div class="col-md-3 col-12">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="first-name-column">{{$unit->unit_en}}</label>
                                                                    <input type="hidden" name="unit_id[]"
                                                                           value="{{$unit->id}}"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-12">
                                                                <div class="form-group">
                                                                    <label for="first-name-column">Quantity</label>
                                                                    <input type="text" id="quantity"
                                                                           class="form-control"
                                                                           placeholder="Quantity"
                                                                           name="quantity[]"
                                                                           value="" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-12">
                                                                <div class="form-group">
                                                                    <label for="first-name-column">Price</label>
                                                                    <input type="text" id="price"
                                                                           class="form-control"
                                                                           placeholder="Price"
                                                                           name="price[]"
                                                                           value="" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-12">
                                                                <div class="form-group">
                                                                    <label for="first-name-column">Offer Price</label>
                                                                    <input type="text" id="price"
                                                                           class="form-control"
                                                                           placeholder="Offer Price"
                                                                           name="offer_price[]"
                                                                           value="" autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif

                                                <div>&nbsp;</div>

                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="media-body mt-75">
                                                            <div
                                                                class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                                                <div class="dropzone dropzone-area"
                                                                     style="min-height: 0">
                                                                    <label
                                                                        class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer"
                                                                        for="account-upload">Upload Image</label>
                                                                    <input type="file" id="account-upload"
                                                                           name="image[]" hidden multiple>
                                                                </div>
                                                            </div>
                                                            <p class="text-muted ml-75 mt-50"><small>Allowed JPG, GIF or
                                                                    PNG. Dimention (800X532) | you can upload multiple
                                                                    Images</small></p>


                                                        </div>
                                                    </div>
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

    <!-- Summernote -->
    <script src="{{asset('backend/plugins/summernote/summernote-bs4.min.js')}}"></script>

    <!-- <script src="{{asset('vendors/js/editors/quill/quill.min.js')}}"></script>
    <script src="{{asset('js/scripts/editors/editor-quill.js')}}"></script> -->

    <script>

        @if(session('success'))
        toastr.success('{{session('success')}}', 'Success');
        @endif
        @if(session('error'))
        toastr.error('{{session('error')}}', 'Error');
        @endif

        $('select[name="category_id"]').on('change', function () {

            categoryId = $(this).val();
            if (categoryId) {
                populate_sub_category(categoryId);
            } else {
                $('select[name="sub_category_id"]').empty();
            }
        });

        function populate_sub_category(catId) {
            $.ajax({
                url: 'subcategories/' + catId,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('select[name="sub_category_id"]').empty();
                    $.each(data, function (key, value) {
                        $('select[name="sub_category_id"]').append('<option value="' + key + '">' + value + '</option>');
                    });
                    $('.selectpicker').selectpicker('refresh');
                },
            });
        }

    </script>
@endsection

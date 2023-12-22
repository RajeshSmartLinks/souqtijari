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
                            <a href="{{route('notification.index')}}" class="btn btn-primary btn-print mb-1 mb-md-0"><i
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


                                        <form class="form-horizontal" action="{{route('notification.store')}}" method="post"
                                              enctype="multipart/form-data" novalidate>
                                            @csrf
                                            <div class="form-body">
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
                                                    <div class="col-md-6 col-6">
                                                        <div class="form-group">
                                                            <label for="first-name-column">Message (English)</label>
                                                            <textarea class="form-control" name="description_en"
                                                                      rows="10" placeholder="Message(English)"
                                                                      required>{{ old('description_en') }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-6">
                                                        <div class="form-group">
                                                            <label for="first-name-column">Message (Arabic)</label>
                                                            <textarea class="form-control" name="description_ar"
                                                                      rows="10" placeholder="Message(Arabic)"
                                                                      required>{{ old('description_ar') }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>&nbsp;</div>

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

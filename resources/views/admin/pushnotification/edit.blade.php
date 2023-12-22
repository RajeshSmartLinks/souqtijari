@extends('layouts.admin-master')

@section('extrastyle')
    <!-- Drop Zone Styles -->
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/file-uploaders/dropzone.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/plugins/file-uploaders/dropzone.css')}}">


    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('vendors/js/summernote/summernote-bs4.css')}}">

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


                                        <form class="form-horizontal"
                                              action="{{route('notification.update', $post->id)}}" method="post"
                                              enctype="multipart/form-data" novalidate>
                                            @csrf
                                            @method('PUT')
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-column">Title (English)</label>
                                                            <input type="text" id="title_en" class="form-control"
                                                                   placeholder="Title (English)"
                                                                   name="title_en"
                                                                   value="{{$post->title_en}}" autocomplete="off"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-column">Title (Arabic)</label>
                                                            <input type="text" id="title_ar" class="form-control"
                                                                   placeholder="Title (Arabic)"
                                                                   name="title_ar"
                                                                   value="{{$post->title_ar}}" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="first-name-column">Message (English)</label>
                                                            <textarea name="description_en" class="form-control" rows="10">{{$post->description_en}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="first-name-column">Message (Arabic)</label>
                                                            <textarea name="description_ar" class="form-control" rows="10">{{$post->description_ar}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <p></p>
                                                <p></p>
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

    <!-- <script src="{{asset('vendors/js/editors/quill/quill.min.js')}}"></script>
    <script src="{{asset('js/scripts/editors/editor-quill.js')}}"></script> -->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('vendors/js/extensions/dropzone.min.js')}}"></script>
    <script src="{{asset('vendors/js/ui/prism.min.js')}}"></script>
    <script src="{{asset('js/scripts/extensions/dropzone.js')}}"></script>

    <!-- Summernote -->
    <script src="{{asset('vendors/js/summernote/summernote-bs4.min.js')}}"></script>

    <script>
        @if(session('success'))
        toastr.success('{{session('success')}}', 'Success');
        @endif
        @if(session('error'))
        toastr.error('{{session('error')}}', 'Error');
        @endif


    </script>
@endsection

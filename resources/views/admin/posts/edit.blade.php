@extends('layouts.admin-master')

@section('extrastyle')
    <!-- Drop Zone Styles -->
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/file-uploaders/dropzone.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/plugins/file-uploaders/dropzone.css')}}">


    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('vendors/js/summernote/summernote-bs4.css')}}">

    <!-- Quill Editor -->
    <!-- <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/editors/quill/katex.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/editors/quill/monokai-sublime.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/editors/quill/quill.snow.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/editors/quill/quill.bubble.css')}}"> -->

@endsection

@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <x-admin-breadcrumb :title="$titles['title']"></x-admin-breadcrumb>
            </div>
            <div class="content-body">

                <!-- invoice functionality start -->
                <section class="invoice-print mb-1">
                    <div class="row">
                        <fieldset class="col-12 col-md-5 mb-1 mb-md-0">&nbsp;</fieldset>
                        <div class="col-12 col-md-7 d-flex flex-column flex-md-row justify-content-end">
                            <a href="{{route('post.index')}}" class="btn btn-primary btn-print mb-1 mb-md-0"><i
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
                                    <h4 class="card-title">{{$titles['subTitle']}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <hr>
                                        <x-admin-error-list-show></x-admin-error-list-show>


                                        <form class="form-horizontal"
                                              action="{{route('post.update', $editPost->id)}}" method="post"
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
                                                                   value="{{$editPost->title_en}}" autocomplete="off"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-column">Title (Arabic)</label>
                                                            <input type="text" id="title_ar" class="form-control"
                                                                   placeholder="Title (Arabic)"
                                                                   name="title_ar"
                                                                   value="{{$editPost->title_ar}}" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-column">Description (English)</label>
                                                            <textarea rows="10"
                                                                      name="description_en"
                                                                      class="ckeditor form-control"> {{$editPost->description_en}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-column">Description (Arabic)</label>
                                                            <textarea rows="10" name="description_ar"
                                                                      class="ckeditor form-control">{{$editPost->description_ar}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

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
                                                                           name="image" hidden>
                                                                </div>
                                                            </div>
                                                            <p class="text-muted ml-75 mt-50"><small>Allowed JPG, GIF or
                                                                    PNG. Dimention (750X450) | you can upload multiple
                                                                    Images</small></p>

                                                            @if(!empty($editPost->image_name))
                                                                <img
                                                                    src="{{asset('uploads/post/medium/'.$editPost->image_name)}}"/>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>&nbsp;</div>
                                                <h3>SEO Things</h3>

                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-column">Meta Keywords</label>
                                                            <textarea class="form-control" name="meta_keyword"
                                                                      rows="10" placeholder="Meta Keywords"
                                                            >{{ $editPost->meta_keyword }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group">
                                                            <label for="first-name-column">Meta Description</label>
                                                            <textarea class="form-control" name="meta_description"
                                                                      rows="10" placeholder="Meta Description"
                                                            >{{ $editPost->meta_description }}</textarea>
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

    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.ckeditor').ckeditor();
        });
    </script>

    <!-- <script src="{{asset('vendors/js/editors/quill/quill.min.js')}}"></script>
    <script src="{{asset('js/scripts/editors/editor-quill.js')}}"></script> -->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('vendors/js/extensions/dropzone.min.js')}}"></script>
    <script src="{{asset('vendors/js/ui/prism.min.js')}}"></script>
    <script src="{{asset('js/scripts/extensions/dropzone.js')}}"></script>

    <!-- Summernote -->
    <script src="{{asset('vendors/js/summernote/summernote-bs4.min.js')}}"></script>

    <script>
        $('.descriptionen').summernote()
        $('.descriptionar').summernote()

        @if(session('success'))
        toastr.success('{{session('success')}}', 'Success');
        @endif
        @if(session('error'))
        toastr.error('{{session('error')}}', 'Error');
        @endif


    </script>
@endsection

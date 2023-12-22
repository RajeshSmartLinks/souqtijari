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

                                        <form class="form" action="{{route('area.update', $editArea->id)}}"
                                              method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-4">
                                                                <span>Choose State</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select name="area_id" class="form-control"
                                                                        id="basicSelect">
                                                                    <option value="0">--State --</option>
                                                                    @foreach($states as $state)
                                                                        <option
                                                                            value="{{$state->id}}" {{ $editArea->area_id == $state->id ? 'selected="selected"' : '' }}>{{$state->name_en}}</option>
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
                                                                   value="{{$editArea->name_en}}">
                                                            <label for="first-name-column">Category Name
                                                                (English)</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="name_ar" class="form-control"
                                                                   placeholder="Category Name(Arabic)"
                                                                   name="name_ar"
                                                                   value="{{$editArea->name_ar}}">
                                                            <label for="first-name-column">Category Name
                                                                (Arabic)</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-12"></div>

                                                    <div class="col-md-6 col-12">
                                                        <div class="form-label-group">
                                                            <input type="file" id="image" class="form-control"
                                                                   placeholder="Area Image"
                                                                   name="image">
                                                            <label for="first-name-column">Area
                                                                Image(250*250)</label>
                                                            <br/>
                                                            @if($editArea->image)
                                                                <img
                                                                    src="{{$editArea->image ? asset('uploads/area/'.$editArea->image) : ''}}"
                                                                    width="60"/>
                                                            @endif
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

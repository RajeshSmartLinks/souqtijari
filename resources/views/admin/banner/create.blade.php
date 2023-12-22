@extends('layouts.admin-master')

@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <x-admin-breadcrumb :title="$title"></x-admin-breadcrumb>
            </div>
            <div class="content-body">

                <!-- Adding Form -->
                <section id="multiple-column-form" class="bootstrap-select">
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

                                        <form class="form" action="{{route('banner.store')}}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="name_en" class="form-control"
                                                                   placeholder="Title(English)"
                                                                   name="name_en"
                                                                   value="">
                                                            <label for="first-name-column">Title
                                                                (English)</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="name_ar" class="form-control"
                                                                   placeholder="Title(Arabic)"
                                                                   name="name_ar"
                                                                   value="">
                                                            <label for="first-name-column">Title
                                                                (Arabic)</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-12"></div>


                                                    <div class="col-md-6 col-12">
                                                        <div class="form-label-group">
                                                            <input type="file" id="banner_image" class="form-control"
                                                                   placeholder="Banner Image"
                                                                   name="banner_image">
                                                            <label for="first-name-column">Category
                                                                Banner Image(1300*525)</label>
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

                                        <x-admin-delete-modal :routename="$deleteRouteName"></x-admin-delete-modal>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Adding Form Ends -->

                <!-- List Datatable Starts -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$listTitle}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>Name (En/Ar)</th>
                                                    <th>Slider Image</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(count($banners) > 0)
                                                    @foreach($banners as $banner)
                                                        <tr>
                                                            <td>{{$banner->name_en}}<br/>{{$banner->name_ar}}</td>
                                                            <td class="product-img"><img
                                                                    src="{{$banner->banner_image ?  asset('uploads/banner/'.$banner->banner_image) : $noImage}} "
                                                                    width="50"/></td>
                                                            <td>

                                                                <a href="{{ route('banner.edit', $banner->id) }}"><i
                                                                        class="feather icon-edit"></i> Edit</a> |
                                                                <a href="javascript:" class="text-danger deleteBtn"
                                                                   data-id="{{$banner->id}}"
                                                                   data-toggle="modal"
                                                                   data-target="#deleteModal" id="deleteBtn"><i
                                                                        class="feather icon-trash"></i> Delete</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr align="center" class="alert alert-danger">
                                                        <td colspan="4">No Record(s)</td>
                                                    </tr>
                                                @endif

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- List Datatable Ends -->
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

        // Functionality section
        $('.deleteBtn').on("click", function () {
            let id = $(this).data('id');
            let url = '{{ route("banner.destroy", ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
            $("#delete_id").val(id);
        });
    </script>
@endsection

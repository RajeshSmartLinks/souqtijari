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
                                    <h4 class="card-title">{{$titles['subTitle']}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <hr>
                                        <x-admin-error-list-show></x-admin-error-list-show>

                                        <form class="form" action="{{route('area.store')}}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
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
                                                                            value="{{$state->id}}">{{$state->name_en}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="name_en" class="form-control"
                                                                   placeholder="Area Name(English)"
                                                                   name="name_en"
                                                                   value="" autocomplete="off">
                                                            <label for="first-name-column">Area Name
                                                                (English)</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="name_ar" class="form-control"
                                                                   placeholder="Area Name(Arabic)"
                                                                   name="name_ar"
                                                                   value="" autocomplete="off">
                                                            <label for="first-name-column">Area Name
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
                                                                Image(100*100)</label>
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
                                    <h4 class="card-title">Area List</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>Name (En/Ar)</th>
                                                    <th>State</th>
                                                    <th>Image</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(count($areas) > 0)
                                                    @foreach($areas as $area)
                                                        <tr>
                                                            <td>{{$area->name_en}}<br/>{{$area->name_ar}}</td>
                                                            <td>{{$area->parent['name_en'] ?? '-'}}</td>
                                                            <td class="product-img"><img
                                                                    src="{{$area->image ?  asset('uploads/area/'.$area->image) : $noImage }} "
                                                                    width="50"/></td>
                                                            <td>

                                                                <a href="{{ route('area.edit', $area->id) }}"><i
                                                                        class="feather icon-edit"></i> Edit</a> |
                                                                <a href="javascript:" onclick="onclickdelete({{$area->id}})" class="text-danger deleteBtn"
                                                                   data-id="{{$area->id}}"
                                                                   data-toggle="modal"
                                                                   data-target="#deleteModal" id="deleteBtn"><i
                                                                        class="feather icon-trash"></i> Delete</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr align="center" class="alert alert-danger">
                                                        <td colspan="5">No Record(s)</td>
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

        function onclickdelete($id)
		{
            let id = $id;
            let url = '{{ route("area.destroy", ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
            $("#delete_id").val(id);
        }
    </script>
@endsection

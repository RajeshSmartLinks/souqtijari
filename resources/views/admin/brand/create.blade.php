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

                                        <form class="form" action="{{route('brand.store')}}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
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
                                                                                <option
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
                                                                   value="" autocomplete="off">
                                                            <label for="first-name-column">Brand Name
                                                                (English)</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="name_ar" class="form-control"
                                                                   placeholder="Brand Name(Arabic)"
                                                                   name="name_ar"
                                                                   value="" autocomplete="off">
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
                                    <h4 class="card-title">{{$titles['listTitle']}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>Name (English)/(Arabic)</th>
                                                    <th>Image</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(count($brands) > 0)
                                                    @foreach($brands as $brand)
                                                        <tr>
                                                            <td>{{$brand->name_en}} (0)
                                                                <br/>{{$brand->name_ar}} </td>
                                                            <td class="product-img"><img
                                                                    src="{{$brand->image ?  asset('uploads/brand/'.$brand->image) : $noImage}} "
                                                                    width="50"/></td>
                                                            <td>
                                                                <a href="{{ route('brand.edit', $brand->id) }}"><i
                                                                        class="feather icon-edit"></i> Edit</a> |
                                                                <a href="javascript:" onclick="onclickdelete({{$brand->id}})"  class="text-danger deleteBtn"
                                                                   data-id="{{$brand->id}}"
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

        function onclickdelete($id)
		{
            let id = $id;
            let url = '{{ route("brand.destroy", ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
            $("#delete_id").val(id);
        }
    </script>
@endsection

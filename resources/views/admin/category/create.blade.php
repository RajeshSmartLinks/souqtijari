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

                                        <form class="form" action="{{route('category.store')}}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
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
                                                                            value="{{$parentCategory->id}}">{{$parentCategory->name_en}}</option>
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
                                                                   value="" autocomplete="off">
                                                            <label for="first-name-column">Category Name
                                                                (English)</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="name_ar" class="form-control"
                                                                   placeholder="Category Name(Arabic)"
                                                                   name="name_ar"
                                                                   value="" autocomplete="off">
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
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-label-group">
                                                            <input type="file" id="banner_image" class="form-control" placeholder="Category List Image" name="banner_image">
                                                            <label for="first-name-column">Category List Image(420*320)</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-label-group">
                                                            <input type="file" id="slide_image" class="form-control" placeholder="Category Slider Image" name="slide_image">
                                                            <label for="first-name-column">Category Slider Image(420*150)</label>
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
                                    <h4 class="card-title">Category List</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>Name (En/Ar)</th>
                                                    <th>Parent Category</th>
													<!--DI CODE - Start-->
                                                    <th>Category Icon</th>
                                                    <th>List Image</th>
                                                    <th>Slider Image</th>
													<!--DI CODE - End-->
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(count($categories) > 0)
                                                    @foreach($categories as $category)
                                                        <tr>
                                                            <td>{{$category->name_en}}<br/>{{$category->name_ar}}</td>
                                                            <td>{{$category->parent['name_en'] ?? '-'}}</td>
															<!--DI CODE - Start-->
                                                            <td class="product-img"><img src="{{$category->image ?  asset('uploads/category/'.$category->image) : $noImage }} " width="50"/></td>
                                                            <td class="product-img"><img src="{{$category->banner_image ?  asset('uploads/category/'.$category->banner_image) : $noImage}} " width="50"/></td>
                                                            <td class="product-img"><img src="{{$category->slide_image ?  asset('uploads/category/'.$category->slide_image) : $noImage}} " width="50"/></td>
															<!--DI CODE - End-->
                                                            <td>

                                                                <a href="{{ route('category.edit', $category->id) }}"><i
                                                                        class="feather icon-edit"></i> Edit</a> |
                                                                <a href="javascript:" onclick="onclickdelete({{$category->id}})" class="text-danger deleteBtn"
                                                                   data-id="{{$category->id}}"
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
            let url = '{{ route("category.destroy", ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
            $("#delete_id").val(id);
        }
    </script>
@endsection

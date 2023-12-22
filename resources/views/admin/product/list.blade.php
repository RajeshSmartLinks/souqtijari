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
                <!-- invoice functionality start -->
                <section class="invoice-print mb-1">
                    <div class="row">
                        <div class="col-12 col-md-12 d-flex flex-column flex-md-row justify-content-end">
                            <a href="{{route('product.import.form')}}" class="btn btn-primary btn-print mb-1 mb-md-0"><i
                                    class="feather icon-upload"></i>&nbsp;Import Product</a>
                            </a>&nbsp;&nbsp;&nbsp;
                            <a href="{{route('product.create')}}" class="btn btn-primary btn-print mb-1 mb-md-0"><i
                                    class="feather icon-plus-circle"></i>&nbsp;Add New</a>
                            </a>
                        </div>
                    </div>
                </section>

                <x-admin-delete-modal :routename="$deleteRouteName"></x-admin-delete-modal>

                <!-- List Datatable Starts -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$subTitle}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>SKU/Image</th>
                                                    <th>Title (En/Ar)</th>
                                                    <th>Category</th>
                                                    <th>Brand</th>
                                                    <th>Units</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(count($products) > 0)
                                                    @foreach($products as $product)
                                                        <tr>
                                                            <td class="product-img">
                                                                {{$product->sku}}<br/>
                                                                <img
                                                                    src="{{!empty($product->medias[0]['image_name']) ?  asset('uploads/product/'.$product->medias[0]['image_name']) : $noImage }} "
                                                                    width="50"/>
                                                            </td>
                                                            <td>{{$product->title_en}}<br/>{{$product->title_ar}} </td>
                                                            <td>{{$product->category->name_en}}</td>
                                                            <td>{{$product->brand->name_en}}</td>
                                                            <td>
                                                                @if($product->units->count() > 0)
                                                                    @foreach($product->units as $unit)
                                                                        <strong>{{$unit->unit_en}}
                                                                            : {{$unit->pivot['price']}}</strong>
                                                                    @endforeach
                                                                @endif
                                                            </td>
                                                            <td>

                                                                <a href="{{ route('product.edit', $product->id) }}"><i
                                                                        class="feather icon-edit"></i> Edit</a> |
                                                                <a href="javascript:" class="text-danger deleteBtn"
                                                                   data-id="{{$product->id}}"
                                                                   data-toggle="modal"
                                                                   data-target="#deleteModal" id="deleteBtn"><i
                                                                        class="feather icon-trash"></i> Delete</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr align="center" class="alert alert-danger">
                                                        <td colspan="6">No Record(s)</td>
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
            $("#delete_id").val(id);
        });

    </script>
@endsection

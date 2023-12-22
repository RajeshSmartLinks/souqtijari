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
                        <fieldset class="col-12 col-md-5 mb-1 mb-md-0">&nbsp;</fieldset>
                        <div class="col-12 col-md-7 d-flex flex-column flex-md-row justify-content-end">
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
                                                    <th>Keyword</th>
                                                    <th>Title (En/Ar)</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(count($posts) > 0)
                                                    @foreach($posts as $post)
                                                        <tr>
                                                            <td class="product-img">
                                                                {{$post->slug}}
                                                            </td>
                                                            <td>{{$post->title_en}}<br/>{{$post->title_ar}} </td>
                                                            <td>

                                                                <a href="{{ route('post.edit', $post->id) }}"><i
                                                                        class="feather icon-edit"></i> Edit</a>
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

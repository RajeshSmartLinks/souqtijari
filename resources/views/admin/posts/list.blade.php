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
                <!-- invoice functionality start -->
                <section class="invoice-print mb-1">
                    <div class="row">
                        <div class="col-12 col-md-12 d-flex flex-column flex-md-row justify-content-end">
                            <a href="{{route('post.create')}}" class="btn btn-primary btn-print mb-1 mb-md-0"><i
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
                                    <h4 class="card-title">{{$titles['subTitle']}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>Title (En/Ar)</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(count($posts) > 0)
                                                    @foreach($posts as $post)
                                                        <tr>
                                                            <td>{{$post->title_en}}<br/>{{$post->title_ar}} </td>
                                                            <td>

                                                                <a href="{{ route('post.edit', $post->id) }}"><i
                                                                        class="feather icon-edit"></i> Edit</a>
                                                                <a href="javascript:" onclick="onclickdelete({{$post->id}})" class="text-danger deleteBtn"
                                                                   data-id="{{$post->id}}"
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

        function onclickdelete($id)
		{
			let id = $id;
            let url = '{{ route("post.destroy", ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
            $("#delete_id").val(id);
        }

    </script>
@endsection

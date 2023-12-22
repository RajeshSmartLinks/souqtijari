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
                            <a href="{{route('notification.create')}}" class="btn btn-primary btn-print mb-1 mb-md-0"><i
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

                                                                <a href="{{ route('notification.edit', $post->id) }}"><i
                                                                        class="feather icon-edit"></i> Edit</a>&nbsp;&nbsp;
                                                                <button class="btn btn-primary btn-sm send_en"
                                                                        data-id="{{$post->id}}">Send
                                                                    English
                                                                </button> &nbsp;&nbsp;
                                                                <button class="btn btn-success btn-sm send_ar"
                                                                        data-id="{{$post->id}}">Send
                                                                    Arabic
                                                                </button>
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
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

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

        $(".send_en").on("click", function () {
            $(this).html('Sending...');
            $(this).prop('disabled', true);

            var id = $(this).data('id');

            $.ajax({
                type: "POST",
                url: "{{route('notification.push')}}",
                data: {"id": id, "lang": "en"},
                dataType: "json",
                success: function (msg) {
                    if (msg.status == "200") {
                        $(this).html('Send English');
                        $(this).prop('disabled', false);
                        alert(msg.message);

                    } else {
                        alert("Some Error Occured");
                    }
                },
                error: function (msg) {
                    alert('Error');
                }
            });

            return false;
        });

        $(".send_ar").on("click", function () {
            $(this).html('Sending...');
            $(this).prop('disabled', true);

            var id = $(this).data('id');

            $.ajax({
                type: "POST",
                url: "{{route('notification.push')}}",
                data: {"id": id, "lang": "ar"},
                dataType: "json",
                success: function (msg) {
                    if (msg.status == "200") {
                        $(this).html('Send Arabic');
                        $(this).prop('disabled', false);
                        alert(msg.message);

                    } else {
                        alert("Some Error Occured");
                    }
                },
                error: function (msg) {
                    alert('Error');
                }
            });

            return false;
        });

    </script>
@endsection

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

                <!-- Editing Form -->
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

                                        <form class="form" action="{{route('operator.update', $operator->id)}}"
                                              method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="operator_id" value="{{$operator->id}}">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="name" class="form-control"
                                                                   placeholder="Operator Name"
                                                                   name="name"
                                                                   value="{{$operator->name}}" autocomplete="off">
                                                            <label for="first-name-column">Operator Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="name" class="form-control"
                                                                   placeholder="Email"
                                                                   name="email"
                                                                   value="{{$operator->email}}" autocomplete="off">
                                                            <label for="first-name-column">Email</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="mobile" class="form-control"
                                                                   placeholder="Mobile"
                                                                   name="mobile"
                                                                   value="{{$operator->mobile}}" autocomplete="off">
                                                            <label for="first-name-column">Mobile</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="username" class="form-control"
                                                                   placeholder="Username"
                                                                   name="username"
                                                                   value="{{$operator->username}}" autocomplete="off">
                                                            <label for="first-name-column">Username</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-label-group">
                                                            <select name="role_id" class="form-control">
                                                                @foreach($roles as $role)
                                                                    <option
                                                                        value="{{$role->id}}" {{$operator->roles->contains($role->id) ? 'selected' : ''}}>{{$role->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <label for="first-name-column">Role</label>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-label-group">
                                                            <input type="password" id="password" class="form-control"
                                                                   placeholder="Password"
                                                                   name="password"
                                                                   value="" autocomplete="off">
                                                            <label for="first-name-column">Password</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-label-group">
                                                            <input type="password" id="Confirm Password"
                                                                   class="form-control"
                                                                   placeholder="Confirm Password"
                                                                   name="password_confirmation"
                                                                   value="" autocomplete="off">
                                                            <label for="first-name-column">Confirm Password</label>
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

                <!-- Editing Form Ends -->
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
            let url = '{{ route("role.destroy", ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
            $("#delete_id").val(id);
        });
    </script>
@endsection

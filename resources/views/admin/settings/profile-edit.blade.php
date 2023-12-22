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
                <!-- account setting page start -->
                <section id="page-account-settings">
                    <div class="row">
                        <!-- left menu section -->
                        <div class="col-md-3 mb-2 mb-md-0">
                            <ul class="nav nav-pills flex-column mt-md-0 mt-1">
                                <li class="nav-item">
                                    <a class="nav-link d-flex py-75 active" id="account-pill-general" data-toggle="pill"
                                       href="#account-vertical-general" aria-expanded="true">
                                        <i class="feather icon-globe mr-50 font-medium-3"></i>
                                        General
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- right content section -->
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <form novalidate action="{{route('admin.profile.update')}}" method="post"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <div role="tabpanel" class="tab-pane active"
                                                     id="account-vertical-general"
                                                     aria-labelledby="account-pill-general" aria-expanded="true">
                                                    <div class="media">
                                                        <a href="javascript: void(0);">
                                                            <img
                                                                src="{{$avatar}}"
                                                                class="rounded mr-75" alt="profile image" height="64"
                                                                width="64">
                                                        </a>
                                                        <div class="media-body mt-75">
                                                            <div
                                                                class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                                                <label
                                                                    class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer"
                                                                    for="account-upload">Upload new photo</label>
                                                                <input type="file" id="account-upload"
                                                                       name="profile_image" hidden>
                                                                <button class="btn btn-sm btn-outline-warning ml-50">
                                                                    Reset
                                                                </button>
                                                            </div>
                                                            <p class="text-muted ml-75 mt-50"><small>Allowed JPG, GIF or
                                                                    PNG. Max
                                                                    size of
                                                                    800kB</small></p>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <x-admin-error-list-show></x-admin-error-list-show>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label for="account-name">Name</label>
                                                                    <input type="text" class="form-control" name="name"
                                                                           id="account-name" placeholder="Name"
                                                                           value="{{$loggedUser->name}}" required
                                                                           data-validation-required-message="This name field is required"
                                                                           autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label for="account-e-mail">E-mail</label>
                                                                    <input type="email" class="form-control"
                                                                           name="email"
                                                                           id="account-e-mail" placeholder="Email"
                                                                           value="{{$loggedUser->email}}" required
                                                                           data-validation-required-message="This email field is required"
                                                                           autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <h3>Password</h3>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label for="account-new-password">New
                                                                        Password</label>
                                                                    <input type="password" name="password"
                                                                           id="account-new-password"
                                                                           class="form-control"
                                                                           placeholder="New Password"
                                                                           minlength="8" autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                            <button type="submit"
                                                                    class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
                                                                changes
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- account setting page end -->

            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script>
        @if(session('success'))
        toastr.success('{{session('success')}}', 'Success');
        @endif
    </script>
@endsection

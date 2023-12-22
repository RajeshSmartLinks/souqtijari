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
                                    <h4 class="card-title">{{$titles['sub_title']}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <hr>
                                        <x-admin-error-list-show></x-admin-error-list-show>

                                        <form class="form" action="{{route('contactinfo.update', $contactInfo->id)}}"
                                              method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <input type="email" id="name_en" class="form-control"
                                                                   placeholder="Email"
                                                                   name="contact_email"
                                                                   value="{{$contactInfo->contact_email}}" autocomplete="off">
                                                            <label for="first-name-column">Email</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="name_ar" class="form-control"
                                                                   placeholder="Mobile"
                                                                   name="contact_mobile"
                                                                   value="{{$contactInfo->contact_mobile}}"
                                                                   autocomplete="off">
                                                            <label for="first-name-column">Mobile</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="name_ar" class="form-control"
                                                                   placeholder="Whatsapp"
                                                                   name="contact_whatsapp"
                                                                   value="{{$contactInfo->contact_whatsapp}}"
                                                                   autocomplete="off">
                                                            <label for="first-name-column">Whatsapp</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="name_en" class="form-control"
                                                                   placeholder="Facebook Link"
                                                                   name="facebook_url"
                                                                   value="{{$contactInfo->facebook_url}}" autocomplete="off">
                                                            <label for="first-name-column">Facebook Link</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="instagram_url" class="form-control"
                                                                   placeholder="Instagram Link"
                                                                   name="instagram_url"
                                                                   value="{{$contactInfo->instagram_url}}"
                                                                   autocomplete="off">
                                                            <label for="first-name-column">Instagram Link</label>
                                                        </div>
                                                    </div>
													<!--DI CODE - Start-->
													<div class="col-md-4 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" id="twitter_url" class="form-control"
                                                                   placeholder="Twitter Link"
                                                                   name="twitter_url"
                                                                   value="{{$contactInfo->twitter_url}}"
                                                                   autocomplete="off">
                                                            <label for="first-name-column">Twitter Link</label>
                                                        </div>
                                                    </div>
													<div class="col-12">
													  <div class="form-label-group">
														  <textarea name="contact_address" id="contact_address" class="form-control" rows="4" placeholder="Contact Address" aria-invalid="false">{{$contactInfo->contact_address}}</textarea>
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

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Adding Form Ends -->

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        @if(session('success'))
        toastr.success('{{session('success')}}', 'Success');
        @endif
        @if(session('error'))
        toastr.error('{{session('error')}}', 'Error');
        @endif

    </script>
@endsection

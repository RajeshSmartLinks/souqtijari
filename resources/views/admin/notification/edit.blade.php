<!--DI CODE - Start-->
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
                <h4 class="card-title">{{$titles['title']}}</h4>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <hr>
                  <x-admin-error-list-show></x-admin-error-list-show>
                  <form class="form" action="{{route('notification.update', $editNotification->id)}}" method="post" enctype="multipart/form- data">
                    @csrf
                    @method('PUT')
                    <div class="form-body">
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group row">
                            <div class="col-md-6">
                              <input type="text" name="title_en" id="title_en" class="form-control" placeholder="Title (English)" value="{{$editNotification->title_en}}" autocomplete="off">
                            </div>
                            <div class="col-md-6">
                              <input type="text" name="title_ar" id="title_ar" class="form-control" placeholder="Title (Arabic)" value="{{$editNotification->title_ar}}" autocomplete="off">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group row"> </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group row">
                            <div class="col-md-6">
                              <textarea name="description_en" id="description_en" class="form-control" rows="8" placeholder="Description  (English)">{{$editNotification->description_en}}</textarea>
                            </div>
                            <div class="col-md-6">
                              <textarea name="description_ar" id="description_ar" class="form-control" rows="8" placeholder="Description  (Arabic)">{{$editNotification->description_ar}}</textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div>&nbsp;</div>
                      <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary mr-1 mb-1">Save </button>
                        <a href="{{route('notification.index')}}">
                        <button type="button" class="btn btn-primary mr-1 mb-1">Back </button>
                        </a> </div>
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
<!--DI CODE - End-->
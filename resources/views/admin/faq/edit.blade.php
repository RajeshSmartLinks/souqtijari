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
                  <form class="form" action="{{route('faq.update', $editFaq->id)}}" method="post" enctype="multipart/form- data">
                    @csrf
                    @method('PUT')
                    <div class="form-body">
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group row">
                            <div class="col-md-3"> <span>Faq Title (English)</span> </div>
                            <div class="col-md-9">
                              <input type="text" name="faq_title_en" id="faq_title_en" class="form-control" placeholder="Faq Title (English)" value="{{$editFaq->faq_title_en}}" autocomplete="off">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group row">
                            <div class="col-md-3"> <span>Faq Title (Arabic)</span> </div>
                            <div class="col-md-9">
                              <input type="text" name="faq_title_ar" id="faq_title_ar" class="form-control" placeholder="Faq Title (Arabic)" value="{{$editFaq->faq_title_ar}}" autocomplete="off">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group row">
                            <div class="col-md-3"> <span>Faq description (English)</span> </div>
                            <div class="col-md-9">
                              <textarea name="faq_description_en" id="faq_description_en" class="form-control" rows="8" placeholder="Faq Description (English)">{{$editFaq->faq_description_en}}</textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group row">
                            <div class="col-md-3"> <span>Faq description (Arabic)</span> </div>
                            <div class="col-md-9">
                              <textarea name="faq_description_ar" id="faq_description_ar" class="form-control" rows="8" placeholder="Faq Description (English)">{{$editFaq->faq_description_ar}}</textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div>&nbsp;</div>
                      <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary mr-1 mb-1">Save </button><a href="{{route('faq.index')}}"><button type="button" class="btn btn-primary mr-1 mb-1">Back </button></a>
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

    </script> 
@endsection 
<!--DI CODE - End-->
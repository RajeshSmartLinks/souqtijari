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
                <h4 class="card-title">{{$titles['subTitle']}}</h4>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <hr>
                  <x-admin-error-list-show></x-admin-error-list-show>
                  <form class="form" action="{{route('notification.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group row">
                            <div class="col-md-6">
                              <input type="text" name="title_en" id="title_en" class="form-control" placeholder="Title (English)" value="" autocomplete="off">
                            </div>
                            <div class="col-md-6">
                              <input type="text" name="title_ar" id="title_ar" class="form-control" placeholder="Title (Arabic)" value="" autocomplete="off">
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
                              <textarea name="description_en" id="description_en" class="form-control" rows="8" placeholder="Description  (English)"></textarea>
                            </div>
                            <div class="col-md-6">
                              <textarea name="description_ar" id="description_ar" class="form-control" rows="8" placeholder="Description  (Arabic)"></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div>&nbsp;</div>
                      <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary mr-1 mb-1">Save </button>
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
                <h4 class="card-title">{{$titles['listTitle']}}</h4>
              </div>
              <div class="card-content">
                <div class="card-body card-dashboard">
                  <div class="table-responsive">
                    <table class="table zero-configuration">
                      <thead>
                        <tr>
                          <th>S.No.</th>
                          <th>Title (English)</th>
                          <th>Title (Arabic)</th>
                          <!--<th>Description (English)</th>
                          <th>Description (Arabic)</th>-->
                          <th>Actions</th>
                          <th>Send In</th>
                        </tr>
                      </thead>
                      <tbody>
                      
                      @if(count($notifications) > 0)
                      @foreach($notifications as $notification)
                      <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$notification->title_en}}</td>
                        <td>{{$notification->title_ar}}</td>
                        <!--<td>{{Str::limit($notification->description_en, 20, ' (...)')}}</td>
                        <td>{{Str::limit($notification->description_ar, 20, ' (...)')}}</td>-->
                        <td><a href="{{ route('notification.edit', $notification->id) }}"><i class="feather icon-edit"></i> Edit</a> | <a href="javascript:" onclick="onclickdelete({{$notification->id}})" class="text-danger deleteBtn" data-id="{{$notification->id}}" data-toggle="modal" data-target="#deleteModal" id="deleteBtn"><i class="feather icon-trash"></i> Delete</a></td>
                        <td><a href="#"><i class="feather icon-edit"></i> English</a> | <a href="#"><i class="feather icon-edit"></i> Arabic</a></td>
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
            let url = '{{ route("notification.destroy", ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
            $("#delete_id").val(id);
        }
    </script> 
@endsection 
<!--DI CODE - End-->
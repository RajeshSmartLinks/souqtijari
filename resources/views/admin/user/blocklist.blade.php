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
          <fieldset class="col-12 col-md-5 mb-1 mb-md-0">
            &nbsp;
          </fieldset>
          <div class="col-12 col-md-7 d-flex flex-column flex-md-row justify-content-end"> </a> </div>
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
							<!--DI CODE - Start-->
                          <th>S.No.</th>
                          <!--<th>Name</th>-->
                          <th>Full Name</th>
                          <th>Gender</th>
                          <th>Email</th>
							<!--DI CODE - End-->
                          <th>Mobile</th>
                          <th width="24%">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      
                      @if(count($users) > 0)
                      @foreach($users as $user)
                      <tr>
						  <!--DI CODE - Start-->
                        <td>{{$loop->iteration}}</td>
                        <!--<td class="product-img"> {{$user->name}}<br/></td>-->
                        <td >{{$user->first_name=='' ? $user->name : $user->first_name.' '.$user->last_name}} </td>
                        <td>{{$user->gender}} </td>
                        <td>{{$user->email}} </td>
							<!--DI CODE - End-->
                        <td>{{$user->mobile}} </td>
                        <td><a href="{{ route('user.edit', $user->id) }}"><i class="feather icon-edit"></i> Edit</a> | <a href="javascript:" onclick="onclickdelete({{$user->id}})" class="text-danger deleteBtn" data-id="{{$user->id}}" data-toggle="modal" data-target="#deleteModal" id="deleteBtn"><i class="feather icon-trash"></i> Delete</a></td>
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
            let url = '{{ route("user.destroy", ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
            $("#delete_id").val(id);
        }
	
	// DI CODE - Start
	function onclickblock(id)
	{
		$.ajax({
			type: "GET",
			url: '{{ route("userblock") }}',
			data: {'user_id': id}
		}).done(function (result) {
			$('#blockcontent_'+id).html(result);
			$('#blockclass_'+id).removeClass();
			$('#blockclasscolor_'+id).removeClass();
			var classname;
			var classcolorname;
			if(result==" Blocked")
			{
				classname = 'feather icon-minus-circle';
				classcolorname = 'text-danger';
			}
			else if(result==" Not Blocked")
			{
				classname = 'feather icon-alert-circle';
				classcolorname = '';
			}
			$('#blockclass_'+id).addClass(classname);
			$('#blockclasscolor_'+id).addClass(classcolorname);
		});
	}
	// DI CODE - End
    </script> 
@endsection 
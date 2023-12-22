<!-- DI CODE - Start-->
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
                          <th>S.No.</th>
                          <th>Email</th>
                          <th>Created At</th>
                          <th width="24%">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      
                      @if(count($newsletters) > 0)
                      @foreach($newsletters as $newsletter)
                      <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$newsletter->email}} </td>
                        <td>{{ date('Y-m-d H:i:s',strtotime($newsletter->created_at)) }} </td>
                        <td><a href="javascript:" onclick="onclickdelete({{$newsletter->id}})" class="text-danger deleteBtn" data-id="{{$newsletter->id}}" data-toggle="modal" data-target="#deleteModal" id="deleteBtn"><i class="feather icon-trash"></i> Delete</a> | <a href="javascript:" onclick="onclickunsubcribe({{$newsletter->id}})" id="blockclasscolor_{{$newsletter->id}}" class="{{$newsletter->status=='0' ? 'text-danger' : ''}}"><i class="feather {{$newsletter->status=='0' ? 'icon-minus-circle' : 'icon-alert-circle'}}" id="blockclass_{{$newsletter->id}}"></i><span id=blockcontent_{{$newsletter->id}}> {{$newsletter->status=='0' ? 'Un Subcribed' : 'Subcribed'}}</span></a>
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
		let url = '{{ route("newsletter.destroy", ":id") }}';
		url = url.replace(':id', id);
		$("#deleteForm").attr('action', url);
		$("#delete_id").val(id);
	}
	
	function onclickunsubcribe(id)
	{
		$.ajax({
			type: "GET",
			url: '{{ route("newsletterunsubcribe") }}',
			data: {'newsletter_id': id}
		}).done(function (result) {
			$('#blockcontent_'+id).html(result);
			$('#blockclass_'+id).removeClass();
			$('#blockclasscolor_'+id).removeClass();
			var classname;
			var classcolorname;
			if(result==" Un Subcribed")
			{
				classname = 'feather icon-minus-circle';
				classcolorname = 'text-danger';
			}
			else if(result==" Subcribed")
			{
				classname = 'feather icon-alert-circle';
				classcolorname = '';
			}
			$('#blockclass_'+id).addClass(classname);
			$('#blockclasscolor_'+id).addClass(classcolorname);
		});
	}

</script> 
@endsection 
<!--DI CODE - End-->
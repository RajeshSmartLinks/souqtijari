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
		<div class="">
			<form class="form-horizontal" action="{{route('adimport')}}" method="post" name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
				@csrf
                <div class="input-row">
                    <label class="col-md-4 control-label">Choose CSV File - Ads</label> <input type="file" name="import_file" id="import_file" accept=".csv">
                    <button type="submit" id="submit" name="import" class="btn-submit">Import</button>
                    <br />
                </div>
            </form>
		</div>
		<div class="">
			<form class="form-horizontal" action="{{route('adimagesimport')}}" method="post" name="frmCSVImportImage" id="frmCSVImportImage" enctype="multipart/form-data">
				@csrf
                <div class="input-row">
                    <label class="col-md-4 control-label">Choose CSV File - Ads Images</label> <input type="file" name="import_file_image" id="import_file_image" accept=".csv">
                    <button type="submit" id="submit" name="import" class="btn-submit">Import</button>
                    <br />
                </div>
            </form>
		</div>
		<div class="">
			<form class="form-horizontal" action="{{route('createadimagesthumb')}}" method="post" name="frmCSVImportImage" id="frmCSVImportImage" enctype="multipart/form-data">
				@csrf
                <div class="input-row">
                    <label class="col-md-4 control-label">Click to create thumb images for ads</label> 
                    <button type="submit" id="submit_thumb" name="submit_thumb" class="btn-submit">Create Thumbimage</button>
                    <br />
                </div>
            </form>
		</div>
      
      <!-- List Datatable Starts -->
      <section id="basic-datatable">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">{{$titles['title']}}</h4>
              </div>
              <div class="card-content">
                <div class="card-body card-dashboard">
                  <div class="table-responsive">
                    <table class="table zero-configuration">
                      <thead>
                        <tr>
                          <th>S.No.</th>
						  <th>Image</th>
                          <th>Title</th>
                          <th>Description</th>
                          <th>Category</th>
                          <?php /*?><th>Image</th><?php */?>
                          <th style="width: 200px !important">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      
                      @if(count($ads) > 0)
                      @foreach($ads as $ad)
                      <tr>
                        <td>{{$loop->iteration}}</td>
						<td class="product-img">
							<?php $images = explode("," ,$ad->ad_images)?>
							<img
							src="{{  asset('uploads/ad/thumb/'.$images[0] ) ?? $noImage}} "
							width="50"/></td>
                        <td>{{$ad->ad_title}}</td>
                        <td>{{Str::limit($ad->ad_description, 20, ' (...)')}}</td>
                        <td>{{$ad->category_name}} --> {{$ad->sub_category_name}}</td>
                        <?php /*?><td class="product-img"><img src="{{$ad->ad_image ?  asset('uploads/ad/'.$ad->ad_image) : $noImage }} " width="50"/></td><?php */?>
                        
                        <td>
							<a href="{{ route('ad.edit', $ad->id) }}"><i class="feather icon-edit"></i> Edit</a> | 
							<a href="javascript:" onclick="onclickdelete({{$ad->id}})" class="text-danger deleteBtn"  data-id="{{$ad->id}}" data-toggle="modal" data-target="#deleteModal" id="deleteBtn"><i class="feather icon-trash"></i> Delete</a> | 
						
							<a href="javascript:" onclick="onclickblock({{$ad->id}})" id="blockclasscolor_{{$ad->id}}" class="{{$ad->status=='0' ? 'text-danger' : ''}}"><i class="feather {{$ad->status=='0' ? 'icon-minus-circle' : 'icon-alert-circle'}}" id="blockclass_{{$ad->id}}"></i><span id=blockcontent_{{$ad->id}}> {{$ad->status=='0' ? 'Blocked' : 'Not Blocked'}}</span></a> | 
							
							<a href="javascript:" onclick="onclickfeatured({{$ad->id}})"><i class="feather {{$ad->ad_is_featured ? 'icon-check-square' : 'icon-square'}}" id="featuredclass_{{$ad->id}}"></i><span id=featuredcontent_{{$ad->id}}> {{$ad->ad_is_featured ? 'Featured' : 'Not Featured'}}</span></a> | 
							<a href="javascript:" onclick="onclickpriority({{$ad->id}})"><i class="feather {{$ad->ad_priority ? 'icon-check-circle' : 'icon-circle'}}" id="priorityclass_{{$ad->id}}"></i><span id=prioritycontent_{{$ad->id}}> {{$ad->ad_priority ? 'Priority' : 'Not Priority'}}</span></a>
						  </td>
                      </tr>
                      @endforeach
                      @else
                      <tr align="center" class="alert alert-danger">
                        <td colspan="5">No Record(s)</td>
                      </tr>
                      @endif
                        </tbody>
                      
                    </table>
                    <x-admin-delete-modal :routename="$deleteRouteName"></x-admin-delete-modal>
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
			 "columnDefs": [
				{ width: '200px', targets: 5 }  //step 2, column 3 out of 4
			]
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

		//alert(id);
		let url = '{{ route("ad.destroy", ":id") }}';
		url = url.replace(':id', id);
		$("#deleteForm").attr('action', url);
		$("#delete_id").val(id);
	}
	
	function onclickblock(id)
	{
		$.ajax({
			type: "GET",
			url: '{{ route("adblock") }}',
			data: {'ad_id': id}
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
	
	function onclickfeatured(id)
	{
		$.ajax({
			type: "GET",
			url: '{{ route("adfeatured") }}',
			data: {'ad_id': id}
		}).done(function (result) {
			$('#featuredcontent_'+id).html(result);
			$('#featuredclass_'+id).removeClass();
			var classname;
			if(result==" Featured")
			{
				classname = 'feather icon-check-square';
			}
			else if(result==" Not Featured")
			{
				classname = 'feather icon-square';
			}
			$('#featuredclass_'+id).addClass(classname);
		});
	}
	
	function onclickpriority(id)
	{
		$.ajax({
			type: "GET",
			url: '{{ route("adpriority") }}',
			data: {'ad_id': id}
		}).done(function (result) {
			$('#prioritycontent_'+id).html(result);
			$('#priorityclass_'+id).removeClass();
			var classname;
			if(result==" Priority")
			{
				classname = 'feather icon-check-circle';
			}
			else if(result==" Not Priority")
			{
				classname = 'feather icon-circle';
			}
			$('#priorityclass_'+id).addClass(classname);
		});
	}
	
	
</script> 
@endsection 
<!--DI CODE - End-->
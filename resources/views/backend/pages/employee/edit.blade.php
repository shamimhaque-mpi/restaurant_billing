<!-- Full Structure -->
@extends('backend.layouts.master')

@section('fav_title', __('backend/employee.edit_employee') )

<!-- Write Styles <style>In Here</style> -->
@section('styles')
@endsection

<!-- This Section Will Shown <body>In Here</body> -->
@section('content')
<!-- Top Management Part -->
<div class="app-title">
	<div>
		<h1><i class="{{ 'fa fa-male' }}"></i> {{ __('backend/employee.employee_management') }}</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
		<li class="breadcrumb-item"><a href="{{ route('admin.employee.index') }}">{{ __('backend/employee.employee') }}</a></li>
		<li class="breadcrumb-item active">{{ __('backend/default.edit') }}</li>
	</ul>
</div>

<!-- Edit Form Part -->
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h2><i class="{{ 'fa fa-pencil-square' }}"></i> {{ __('backend/employee.edit_employee') }}</h2></div>
					{{-- <div class="col-md-6"><a href="{{ route('admin.employee.index') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div> --}}
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="card-body">
				@include('backend.partials.error_message')
				<form class="form-horizontal" action="{{ route('admin.employee.update',$row->id) }}" method="post" enctype="multipart/form-data">
					@csrf


					<div class="form-group row">
			            <label class="control-label col-md-3 text-right">
			              <strong>{{ __('backend/form_field.name') }}</strong>
			              <span class="text-danger">*</span></label>
			            <div class="col-md-5">
			              <input type="text" id="name" class="form-control" name="name" value="{{ $row->name }}" required>
			            </div>
			        </div>

					<div class="form-group row">
			            <label class="control-label col-md-3 text-right">
			              <strong>{{ __('backend/form_field.mobile') }}</strong>
			              <span class="text-danger">*</span></label>
			            <div class="col-md-5">
			              <input type="text" id="mobile" class="form-control" name="mobile" value="{{ $row->mobile }}" required>
			            </div>
			        </div>

					<div class="form-group row">
			            <label class="control-label col-md-3 text-right">
			              <strong>{{ __('backend/form_field.pre_address') }}</strong>
			              <span class="text-danger">*</span></label>
			            <div class="col-md-5">
			              <input type="text" id="per_address" class="form-control" name="per_address" value="{{ $row->per_address }}" required>
			            </div>
			        </div>

					<div class="form-group row">
			            <label class="control-label col-md-3 text-right">
			              <strong>{{ __('backend/form_field.per_address') }}</strong>
			              <span class="text-danger">*</span></label>
			            <div class="col-md-5">
			              <input type="text" id="pre_address" class="form-control" name="pre_address" value="{{ $row->pre_address }}" required>
			            </div>
			        </div>

					<div class="form-group row">
			            <label class="control-label col-md-3 text-right">
			              <strong>{{ __('backend/form_field.nid_no') }}</strong>
			              <span class="text-danger">*</span></label>
			            <div class="col-md-5">
			              <input type="text" id="nid_no" class="form-control" name="nid_no" value="{{ $row->nid_no }}" required>
			            </div>
			        </div>

					<div class="form-group row">
			            <label class="control-label col-md-3 text-right">
			              <strong>{{ __('backend/form_field.designation') }}</strong>
			              <span class="text-danger">*</span></label>
			            <div class="col-md-5">
			              <input type="text" id="gesignation" class="form-control" name="designation" value="{{ $row->designation }}" required>
			            </div>
			        </div>

					<div class="form-group row">
			            <label class="control-label col-md-3 text-right">
			              <strong>{{ __('backend/form_field.salary') }}</strong>
			              <span class="text-danger">*</span></label>
			            <div class="col-md-5">
			              <input type="number" id="salary" class="form-control" name="salary" value="{{ $row->salary }}" required>
			            </div>
			        </div>

					<div class="form-group row">
			            <label class="control-label col-md-3 text-right">
			              <strong>{{ __('backend/default.photo') }}</strong>
			              <span class="text-danger"> </span></label>
			            <div class="col-md-5">
			              <input type="file" id="photo" class="form-control" name="photo">
			            </div>
			        </div>

					<div class="form-group row">
			            <div class="col-md-8">
			              <button type="submit" class="btn btn-primary float-right">{{ __('backend/default.update') }}</button>
			            </div>
			        </div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

<!-- Write Scripts <script fileType="text/javascript">In Here</script> -->
@section('scripts')
@endsection
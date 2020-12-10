<!-- Full Structure -->
@extends('backend.layouts.master')

@section('fav_title', __('backend/purchase_item.edit_purchase_item') )

<!-- Write Styles <style>In Here</style> -->
@section('styles')
@endsection

<!-- This Section Will Shown <body>In Here</body> -->
@section('content')
<!-- Top Management Part -->
<div class="app-title">
	<div>
		<h1><i class="{{ 'fa fa-sitemap' }}"></i> {{ __('backend/purchase_item.purchase_item_management') }}</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
		<li class="breadcrumb-item"><a href="{{ route('admin.purchase_item.index') }}">{{ __('backend/purchase_item.purchase_item') }}</a></li>
		<li class="breadcrumb-item active">{{ __('backend/default.edit') }}</li>
	</ul>
</div>

<!-- Edit Form Part -->
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h2><i class="{{ 'fa fa-pencil-square' }}"></i> {{ __('backend/purchase_item.edit_purchase_item') }}</h2></div>
					<div class="col-md-6"><a href="{{ route('admin.purchase_item.index') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="card-body">
				@include('backend.partials.error_message')
				<form class="form-horizontal" action="{{ route('admin.purchase_item.update',$row->id) }}" method="post" enctype="multipart/form-data">
					@csrf

	                <div class="form-row">
	                    <div class="col-md-6"><label for="title" class="label">Category</label>
	                        <div>
	                            <select name="r_m_cat_id" class="form-control" id="r_m_cat_id" required="">
	                            	<option value="" selected="true" disabled="true"> --- Select Raw Material Category ---</option>
	                            	@foreach($raw_material_categories as $raw_material_category)
	                            	<option value="{{ $raw_material_category->id }}" {{ $raw_material_category->id == $row->r_m_cat_id ? "selected" : "" }}> {{ $raw_material_category->title }} </option>
	                            	@endforeach
	                            </select>
	                        </div>

	                        <label for="title" class="label pt-2">Title</label>
	                        <div>
	                            <input type="text" class="form-control mb-2" value="{{ $row->title }}" name="title" id="title" required>
	                        </div>
	                        <label for="regular_price" class="label">Regular Price</label>
	                        <div>
	                            <input type="number" step=".5" class="form-control mb-2" value="{{ $row->regular_price }}" name="regular_price" id="regular_price" required>
	                        </div>
	                        <label for="status" class="label">Status</label>
	                        <div>
	                        	<select name="status" id="status" class="form-control">
	                        		<option value="1" {{ $row->status == 1 ? 'selected' : '' }}>Active</option>
	                        		<option value="0" {{ $row->status == 0 ? 'selected' : '' }}>Deactive</option>
	                        	</select>
	                        </div>
	                    </div>
	                    <div class="col-md-6 mb-2">
	                        <label for="description" class="label">Description</label>
	                        <div>
	                            <textarea style="height: 258px;" class="form-control" name="description" id="description">{!! $row->description !!}</textarea>
	                        </div>
	                    </div>
	                </div>


					<button type="submit" class="btn btn-primary float-right">{{ __('backend/default.update') }}</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

<!-- Write Scripts <script fileType="text/javascript">In Here</script> -->
@section('scripts')
@endsection
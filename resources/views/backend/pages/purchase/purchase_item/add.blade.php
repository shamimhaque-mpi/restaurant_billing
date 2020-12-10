<!-- Full Structure -->
@extends('backend.layouts.master')

@section('fav_title', __('backend/purchase_item.add_purchase_item') )

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
		<li class="breadcrumb-item active">{{ __('backend/default.add_new') }}</li>
	</ul>
</div>

<!-- Add Form Part -->
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h2><i class="{{ 'fa fa-plus-square' }}"></i> {{ __('backend/purchase_item.add_purchase_item') }}</h2></div>
					<div class="col-md-6"><a href="{{ route('admin.purchase_item.index') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>
					<div class="clearfix"></div>

				</div>
			</div>
			<div class="card-body">
				@include('backend.partials.error_message')
				<form class="form-horizontal" action="{{ route('admin.purchase_item.store') }}" method="post" enctype="multipart/form-data">
					@csrf

	                <div class="form-row">
	                    <div class="col-md-6">
	                        <label for="title" class="label">Category</label>
	                        <div>
	                            <select name="r_m_cat_id" class="form-control" id="r_m_cat_id" required="">
	                            	<option value="" selected="true" disabled="true"> --- Select Raw Material Category ---</option>
	                            	@foreach($raw_material_categories as $raw_material_category)
	                            	<option value="{{ $raw_material_category->id }}"> {{ $raw_material_category->title }} </option>
	                            	@endforeach
	                            </select>
	                        </div>

	                        <label for="title" class="label pt-2">Title</label>
	                        <div>
	                            <input type="text" class="form-control mb-2" name="title" id="title" required>
	                        </div>

	                        <label for="regular_price" class="label">Regular Price</label>
	                        <div>
	                            <input type="number" step=".5" class="form-control mb-2" name="regular_price" id="regular_price" required>
	                        </div>
	                    </div>
	                    <div class="col-md-6 mb-2">
	                        <label for="description" class="label">Description</label>
	                        <div>
	                            <textarea rows="8" class="form-control" name="description" id="description"></textarea>
	                        </div>
	                    </div>
	                </div>

					<button type="submit" class="btn btn-primary float-right">{{ __('backend/default.submit') }}</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

<!-- Write Scripts <script fileType="text/javascript">In Here</script> -->
@section('scripts')
	<script>
		$("#r_m_cat_id").select2();
	</script>
@endsection
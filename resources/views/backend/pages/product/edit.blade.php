<!-- Full Structure -->
@extends('backend.layouts.master')

@section('fav_title', __('backend/product.edit_product') )

<!-- Write Styles <style>In Here</style> -->
@section('styles')
@endsection

<!-- This Section Will Shown <body>In Here</body> -->
@section('content')
<!-- Top Management Part -->
<div class="app-title">
	<div>
		<h1><i class="{{ 'fa fa-archive' }}"></i> {{ __('backend/product.product_management') }}</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
		@if ('edit' == 'index')
		<li class="breadcrumb-item active">{{ __('backend/product.product') }}</li>
		@elseif ('edit' == 'add')
		<li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">{{ __('backend/product.product') }}</a></li>
		<li class="breadcrumb-item active">{{ __('backend/default.add_new') }}</li>
		@elseif ('edit' == 'edit')
		<li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">{{ __('backend/product.product') }}</a></li>
		<li class="breadcrumb-item active">{{ __('backend/default.edit') }}</li>
		@endif
	</ul>
</div>

<!-- Edit Form Part -->
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					@if ('edit' == 'index')
					<div class="col-md-6"><a href="{{ route('admin.product.create') }}" class="float-right btn btn-primary"><i class="fa fa-plus"></i> {{ __('backend/default.add_new') }}</a></div>

					@elseif ('edit' == 'add')
					<div class="col-md-6"><h2><i class="{{ 'fa fa-pencil-square' }}"></i> {{ __('backend/product.add_product') }}</h2></div>
					<div class="col-md-6"><a href="{{ route('admin.product.index') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>

					@elseif ('edit' == 'edit')
					<div class="col-md-6"><h2><i class="{{ 'fa fa-pencil-square' }}"></i> {{ __('backend/product.edit_product') }}</h2></div>
					<div class="col-md-6"><a href="{{ route('admin.product.index') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>
					@endif
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="card-body">
				@include('backend.partials.error_message')
				<form class="form-horizontal" action="{{ route('admin.product.update', $row->slug) }}" method="post" enctype="multipart/form-data">
					@csrf

					<div class="form-row">
						<div class="col-md-6 form-group mb-0">
							<div class="form-group">
								<label for="title">{{ __('backend/default.title') }} <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="title" id="title" required placeholder="" value="{{ $row->title }}">
							</div>

							<div class="form-group">
								<label for="category_id">{{ __('backend/category.category') }} <span class="text-danger">*</span></label>
								<select name="category_id" id="category_id" class="form-control" required>
									<option selected disabled>{{ __('backend/product.select_category') }}</option>
									@foreach($categories as $category)
									<option value="{{ $category->id }}" {{ $row->category_id == $category->id ? 'selected':'' }}>{{ $category->title }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label for="status">{{ __('backend/default.status') }} <span class="text-danger">*</span></label>
								<select name="status" id="status" class="form-control" required>
									<option value="1" {{ $row->status == 1 ? 'selected':'' }}>{{ __('backend/default.active') }}</option>
									<option value="0" {{ $row->status == 0 ? 'selected':'' }}>{{ __('backend/default.deactive') }}</option>
								</select>
							</div>
						</div>
						<div class="col-md-6 form-group mb-0">
							<label for="description">{{ __('backend/default.description') }} <span class="text-danger">*</span></label>
							<textarea name="description" id="description" class="form-control" cols="30" rows="4" required style="min-height: 200px"> {!! $row->description !!} </textarea>
						</div>
					</div>

					<div class="form-row">
						<div class="col-md-5 form-group">
							<label for="purchase_price">{{ __('backend/default.purchase_price') }} <span class="text-danger">*</span></label>
							<input type="number" class="form-control" name="purchase_price" id="purchase_price" required placeholder="" value="{{ $row->purchase_price }}">
						</div>

						<div class="col-md-5 form-group">
							<label for="regular_sale_price">{{ __('backend/product.regular_sale_price') }} <span class="text-danger">*</span></label>
							<input type="number" class="form-control" name="regular_sale_price" id="regular_sale_price" required placeholder="" value="{{ $row->regular_sale_price }}">
						</div>
						<div class="col-md-2 form-group">
							<label for="discount">{{ __('backend/default.discount') }} <span class="text-danger">*</span> <small>({{ __('backend/default.in_%') }})</small></label>
							<input type="number" min="0" max="100" class="form-control" name="discount" id="discount" placeholder="" required value="{{ $row->discount }}">
						</div>
					</div>

					<div class="form-row" id="img">
						<div class="col-md-3 form-group position-relative">
							<label for="image">{{ __('backend/default.photo') }} <span class="text-green">*</span></label>
							<input type="file" class="form-control img_" name="image" id="image">
              				<input  class="form-control" type="hidden" name="old_image" value="{{ $row->image }}" >
							<img class="image_preview position-absolute img_prv" src="{{ asset($row->image) }}">
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
<script>
	$(document).ready(function(){

		$('#category_id').select2();

        $('body').on('click','.img_',function(){
        	$(this).change(function(){
        		$('.img_prv').attr('src', window.URL.createObjectURL(this.files[0]));
        		/*$('.img_prv').removeClass('img_prv');
        		$(this).removeClass('img_');
        		$(this).attr('readonly','""');
        		var newImage = "<div class=\"col-md-3 form-group\">\n" +
        		"					<label for=\"image\"> <span class=\"text-danger\">&nbsp;</span> </label>\n" +
        		"					<input type=\"file\" class=\"form-control img_\" name=\"image[]\">\n" +
        		"					<img class=\"image_preview position-absolute img_prv\" src=\"\">" +
        		"               </div>";
        		$("#img").append(newImage);*/
        	});
        })

    });
</script>
@endsection
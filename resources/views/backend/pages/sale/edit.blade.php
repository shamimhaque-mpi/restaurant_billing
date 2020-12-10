<!-- Full Structure -->
@extends('backend.layouts.master')

@section('fav_title', 'Edit')

<!-- Write Styles <style>In Here</style> -->
@section('styles')
@endsection

<!-- This Section Will Shown <body>In Here</body> -->
@section('content')
<!-- Top Management Part -->
<div class="app-title">
	<div>
		<h1><i class="{{ 'fa fa-money' }}"></i> {{ __('backend/sale.sale_management') }}</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
		@if ('edit' == 'index')
		<li class="breadcrumb-item active">{{ __('backend/sale.sale') }}</li>
		@elseif ('edit' == 'add')
		<li class="breadcrumb-item"><a href="{{ route('admin.sale.index') }}">{{ __('backend/sale.sale') }}</a></li>
		<li class="breadcrumb-item active">{{ __('backend/default.add_new') }}</li>
		@elseif ('edit' == 'edit')
		<li class="breadcrumb-item"><a href="{{ route('admin.sale.index') }}">{{ __('backend/sale.sale') }}</a></li>
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
					<div class="col-md-6"><a href="{{ route('admin.sale.add') }}" class="float-right btn btn-primary"><i class="fa fa-plus"></i> {{ __('backend/default.add_new') }}</a></div>

					@elseif ('edit' == 'add')
					<div class="col-md-6"><h2><i class="{{ 'fa fa-pencil-square' }}"></i> {{ __('backend/sale.add_sale') }}</h2></div>
					<div class="col-md-6"><a href="{{ route('admin.sale.index') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>

					@elseif ('edit' == 'edit')
					<div class="col-md-6"><h2><i class="{{ 'fa fa-pencil-square' }}"></i> {{ __('backend/sale.edit_sale') }}</h2></div>
					<div class="col-md-6">
						<a href="{{ route('admin.sale.index') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a>
						<a href="{{ route('admin.sale.add') }}" class="float-right btn btn-info mr-2"><i class="fa fa-arrow-left"></i> {{ __('backend/default.add_new') }}</a>
					</div>
					@endif
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="card-body">
				<sale-edit
				submit="{{ __('backend/default.submit') }}"
				sl="{{ __('backend/default.sl') }}"
				photo="{{ __('backend/form_field.photo') }}"
				name="{{ __('backend/form_field.name') }}"
				customer_name_field="{{ __('backend/default.customer_name') }}"
				paid_field="{{ __('backend/default.paid') }}"
				customer_mobile_field="{{ __('backend/default.customer_mobile') }}"
				total_field="{{ __('backend/default.total_price') }}"
				quantity="{{ __('backend/default.quantity') }}"
				price="{{ __('backend/default.price') }}"
				discount_field="{{ __('backend/default.discount') }}"
				total="{{ __('backend/default.total') }}"
				select_category="{{ __('backend/form_field.select_category') }}"
				select_product="{{ __('backend/form_field.select_product') }}"
				action="{{ __('backend/default.action') }}"
				url="{{ url('/') }}"
				:id="{{ $id }}"
				:categories="{{ $categories }}"
				return_field="{{ __('backend/default.return') }}"
				payable_field="{{ __('backend/default.payable') }}"
				></sale-edit>
			</div>
		</div>
	</div>
</div>
@endsection

<!-- Write Scripts <script fileType="text/javascript">In Here</script> -->
@section('scripts')
@endsection

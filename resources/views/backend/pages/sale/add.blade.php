<!-- Full Structure -->
@extends('backend.layouts.master')

@section('fav_title', 'Add')

<!-- Write Styles <style>In Here</style> -->
@section('styles')
<style type="text/css">
	.container__ {
		height: 140px;
	}

	.inner {
		height: 140px;
		white-space:nowrap;
	}

	.floatLeft {
		cursor: pointer;
		width: 100px;
		height: 100px; 
		margin:10px 10px 10px 10px; 
		display: inline-block;
	}
	img {
		height: 100%;
	}
	input[type='number'] {
		-moz-appearance:textfield;
	}

	input::-webkit-outer-spin-button,
	input::-webkit-inner-spin-button {
		-webkit-appearance: none;
	}
	/*.simplebar-track.simplebar-horizontal .simplebar-scrollbar{
	    height: 18px !important;
	    display: block !important;
	    cursor: pointer;
	}
	.simplebar-track.simplebar-horizontal {
	    height: 21px !important;
	    display: block !important;
	    cursor: pointer;
	}*/
</style>
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
		@if ('add' == 'index')
		<li class="breadcrumb-item active">{{ __('backend/sale.sale') }}</li>
		@elseif ('add' == 'add')
		<li class="breadcrumb-item"><a href="{{ route('admin.sale.index') }}">{{ __('backend/sale.sale') }}</a></li>
		<li class="breadcrumb-item active">{{ __('backend/default.add_new') }}</li>
		@elseif ('add' == 'edit')
		<li class="breadcrumb-item"><a href="{{ route('admin.sale.index') }}">{{ __('backend/sale.sale') }}</a></li>
		<li class="breadcrumb-item active">{{ __('backend/default.edit') }}</li>
		@endif
	</ul>
</div>
<!-- Add Form Part -->
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					@if ('add' == 'index')
					<div class="col-md-6"><a href="{{ route('admin.sale.add') }}" class="float-right btn btn-primary"><i class="fa fa-plus"></i> {{ __('backend/default.add_new') }}</a></div>

					@elseif ('add' == 'add')
					<div class="col-md-6"><h2><i class="{{ 'fa fa-plus-square' }}"></i> {{ __('backend/sale.add_sale') }}</h2></div>
					<div class="col-md-6">
						<a href="{{ route('admin.sale.add') }}" title="Reload" class="float-right btn btn-warning alert-warning mx-1"><i class="fa fa-refresh"></i></a>
						<a href="{{ route('admin.sale.index') }}" title="Sale List" class="float-right btn btn-primary alert-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a>
					</div>

					@elseif ('add' == 'edit')
					<div class="col-md-6"><h2><i class="{{ 'fa fa-plus-square' }}"></i> {{ __('backend/sale.edit_sale') }}</h2></div>
					<div class="col-md-6"><a href="{{ route('admin.sale.index') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>
					@endif
					<div class="clearfix"></div>
				</div>
			</div>
			{{-- <div class="d-block">
				<div class="btn-group float-right pt-2 pr-2 mb-0" role="group" aria-label="Basic example">
				  <button type="button" title="Previous" id="previous" class="btn btn-info horizon-prev"><span>&lt;</span></button>
				  <button type="button" title="next" id="next" class="btn btn-info horizon-next"><span>&gt;</span></button>
				</div>
			</div> --}}
			<div class="card-body">
				<add-sale 
				submit="{{ __('backend/default.submit') }}" 
				product="{{ __('backend/product.product') }}" 
				:categories="{{ $categories }}" 
				select_category="{{ __('backend/form_field.select_category') }}"
				url="{{ url('/') }}"
				bill="{{ __('backend/default.go_to_bill') }}"
				sl="{{ __('backend/default.sl') }}"
				photo="{{ __('backend/form_field.photo') }}"
				name="{{ __('backend/form_field.name') }}"
				quantity="{{ __('backend/default.quantity') }}"
				price="{{ __('backend/default.price') }}"
				is_order="{{ __('backend/default.order') }}"
				discount="{{ __('backend/default.discount') }}"
				discount_2="{{ __('backend/default.discount') }}"
				vat="{{ __('backend/default.vat') }}"
				total="{{ __('backend/default.total') }}"
				customer_name_field="{{ __('backend/default.customer_name') }}"
				paid_field="{{ __('backend/default.paid') }}"
				customer_mobile_field="{{ __('backend/default.customer_mobile') }}"
				no_data="{{ __('backend/default.no_data') }}"
				action="{{ __('backend/default.action') }}"
				url="{{ url('/') }}"
				after_discount="{{ __('backend/default.after_discount') }}"
				return_field="{{ __('backend/default.return') }}"
				payable_field="{{ __('backend/default.amount') }}"
				>
			</add-sale>
		</div>
	</div>
</div>
</div>
@endsection

@section('scripts')
<script>
	$('.reset_button').click();
	function slider_(x)
	{
		$('.inner').children('div').scollBy(200, 0);
	}
	$(document).ready(function(){	// console.log(select2);
		// var init_val = $('.product__container').html().length;

		$('.reset_button').click();
		$('.active__').click(function() {
			$(this).siblings().removeClass('btn-success');
			$(this).siblings().addClass('btn-theme');

			$(this).removeClass('btn-theme');
			$(this).addClass('btn-success');
			//$('.fa-refresh').addClass('fa-spin');

			// var final_val = $('.product__container').html().length;

			// if (init_val != final_val) {
			// 	console.log($('.product__container').html().length);
			// 	$('.fa-refresh').removeClass('fa-spin');
			// }

		});
	});
</script>
@endsection

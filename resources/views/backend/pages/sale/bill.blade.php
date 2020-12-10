<!-- Full Structure -->
@extends('backend.layouts.master')

@section('fav_title', 'Bill')

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
		@if ('index' == 'index')
		<li class="breadcrumb-item active">{{ __('backend/sale.sale') }}</li>
		@elseif ('index' == 'add')
		<li class="breadcrumb-item"><a href="{{ route('admin.sale.index') }}">{{ __('backend/sale.sale') }}</a></li>
		<li class="breadcrumb-item active">{{ __('backend/default.add_new') }}</li>
		@elseif ('index' == 'edit')
		<li class="breadcrumb-item"><a href="{{ route('admin.sale.index') }}">{{ __('backend/sale.sale') }}</a></li>
		<li class="breadcrumb-item active">{{ __('backend/default.edit') }}</li>
		@endif
	</ul>
</div>

<!-- Table Part -->
<div class="row">
	<div class="col-md-12">
		<div class="card">
		  

			<div class="card-header">
				<div class="row">
					@if ('index' == 'index')
					<div class="col-md-6"><h2><i class="{{ 'fa fa-table' }}"></i> {{ __('backend/default.bill') }}</h2></div>
					<div class="col-md-6">
                        <a href="{{ route('admin.sale.index') }}" class="float-right btn btn-info mr-2"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a>
                        <a href="{{ route('admin.sale.allItemDelete') }}" class="float-right btn btn-danger mr-2"><i class="fa fa-minus"></i> {{ __('backend/default.cashClear') }}</a>
                        <a href="{{ route('admin.sale.add') }}" class="float-right btn btn-primary mr-2"><i class="fa fa-plus"></i> {{ __('backend/default.add_new') }}</a>
                    </div>

					@elseif ('index' == 'add')
					<div class="col-md-6"><h2><i class="{{ 'fa fa-table' }}"></i> {{ __('backend/sale.add_sale') }}</h2></div>
					<div class="col-md-6"><a href="{{ route('admin.sale.index') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>

					@elseif ('index' == 'edit')
					<div class="col-md-6"><h2><i class="{{ 'fa fa-table' }}"></i> {{ __('backend/sale.edit_sale') }}</h2></div>
					<div class="col-md-6"><a href="{{ route('admin.sale.index') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>
					@endif
					<div class="clearfix"></div>
				</div>
			</div>

			<div class="card-body">
				<div class="table-responsive pt-1">
                    <bill
                        submit="{{ __('backend/default.submit') }}"
                        sl="{{ __('backend/default.sl') }}"
                        photo="{{ __('backend/form_field.photo') }}"
                        name="{{ __('backend/form_field.name') }}"
                        quantity="{{ __('backend/default.quantity') }}"
                        price="{{ __('backend/default.price') }}"
                        discount="{{ __('backend/default.discount') }}"
                        total="{{ __('backend/default.total') }}"
                        customer_name_field="{{ __('backend/default.customer_name') }}"
                        paid_field="{{ __('backend/default.paid') }}"
                        customer_mobile_field="{{ __('backend/default.customer_mobile') }}"
                        no_data="{{ __('backend/default.no_data') }}"
                        action="{{ __('backend/default.action') }}"
                        url="{{ url('/') }}"
                        after_discount="{{ __('backend/default.after_discount') }}"
                    >

                    </bill>
				</div>

			</div>
            <div class="card-footer"></div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
@endsection

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
					<div class="col-md-6"><h2><i class="{{ 'fa fa-table' }}"></i> {{ __('backend/sale.sale_list') }}</h2></div>
					<div class="col-md-5"><a href="{{ route('admin.sale.add') }}" class="float-right btn btn-primary alert-primary"><i class="fa fa-plus"></i> {{ __('backend/default.add_new') }}</a></div>
					<div class="col-md-1">
						<a href="#" onclick="print_method()" class="btn btn-primary alert-primary text-center float-right">
							<i class="fa fa-print"></i> {{ __('backend/default.print') }}
						</a>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="card-body">

				<div class="col-sm-12 mb-3 p-3 hide">
					<div class="row">
						<table class="table mb-0">
							<tr>
								<th class="text-center p-0 border-0">
									@php
										$site_setting = \App\Models\Setting::first();
									@endphp
									<h3>{{ $site_setting->title }}</h3>
									<span>{{ $site_setting->address }}</span> <br />
									<p class="p-0 m-1">
										<i class="fa fa-envelope"></i> : {{ $site_setting->email }} |
										<i class="fa fa-phone-square"></i> : {{ $site_setting->mobile }} |
										<i class="fa fa-facebook-square"></i> : {{ $site_setting->faccebook }}
									</p>
								</th>
							</tr>
						</table>
					</div>
				</div>

				<div class="hide col-sm-12 text-center"><h2><i class="{{ 'fa fa-table' }}"></i> All Sale</h2></div>


				@php
				$permissions = \App\Models\Menu::where('url', substr(url()->current(), 1+strlen(url('/'))))
				->orWhere('url', substr(url()->current(), strlen(url('/'))))->first();
				if(Auth::guard('admin')->user()->admin_role == 3){
					$bodyMenu = \App\Models\Role::where('admin_id', Auth::guard()->id())->first();
				}
				else{
					$bodyMenu = \App\Models\Role::where('role', Auth::guard()->user()->admin_role)->first();
				}
				@endphp
				<all-sale
					saler="{{ __('backend/default.saler') }}"
					status="{{ __('backend/default.status') }}"
					sl="{{ __('backend/default.sl') }}"
					title="{{ __('backend/default.title') }}"
					quantity="{{ __('backend/default.quantity') }}"
					total="{{ __('backend/default.total_price') }}"
					final_total="{{ __('backend/default.total') }}"
					action="{{ __('backend/default.action') }}"
					:permission_submenus="{{ $permissions->submenus }}"
					:in_body="{{ $bodyMenu->in_body }}"
					url="{{ url('/') }}"
					sale_date="{{ __('backend/default.sale_date') }}"
					customer_name="{{ __('backend/default.customer_name') }}"
					total_sale="{{ __('backend/sale.total_sale') }}"
					total_product="{{ __('backend/sale.total_product') }}"
					customer_mobile="{{ __('backend/default.customer_mobile') }}"
					voucher="{{ __('backend/default.voucher') }}"
					discount="{{ __('backend/default.discount') }}"
					after_discount="{{ __('backend/default.after_discount') }}"
					price="{{ __('backend/default.price') }}"
					grand_total="{{ __('backend/sale.grand_total') }}"
					table_no_th="{{ __('backend/default.table') }}"
					due_th="{{ __('backend/due.due') }}"
				>
				</all-sale>
		</div>

		<div class="card-footer">

		</div>
	</div>
</div>
</div>
@endsection

<!-- Write Scripts <script fileType="text/javascript">In Here</script> -->
@section('scripts')
<script>
	$(document).ready(function(){
		$('#from_date').datepicker({
			format: 'yyyy-mm-dd',
			todayHighlight:'TRUE',
			autoclose: true,
		});

		$('#to_date').datepicker({
			format: 'yyyy-mm-dd',
			todayHighlight:'TRUE',
			autoclose: true,
		});

		$("#select2").select2();
	});
</script>
@endsection

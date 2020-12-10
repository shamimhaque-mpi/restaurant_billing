<!-- Full Structure -->
@extends('backend.layouts.master')

@section('fav_title', __('backend/product.view_product') )

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
		@if ('view' == 'index')
		<li class="breadcrumb-item active">{{ __('backend/product.product') }}</li>
		@elseif ('view' == 'add')
		<li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">{{ __('backend/product.product') }}</a></li>
		<li class="breadcrumb-item active">{{ __('backend/default.add_new') }}</li>
		@elseif ('view' == 'edit')
		<li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">{{ __('backend/product.product') }}</a></li>
		<li class="breadcrumb-item active">{{ __('backend/default.edit') }}</li>
		@elseif ('view' == 'view')
		<li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">{{ __('backend/product.product') }}</a></li>
		<li class="breadcrumb-item active">{{ __('backend/default.view') }}</li>
		@endif
	</ul>
</div>

<!-- Table Part -->
<div class="row">
	<div class="col-md-12">
		<div class="card">

			<div class="card-header">
				<div class="row">
					@if ('view' == 'index')
					<div class="col-md-6"><h2><i class="{{ 'fa fa-eye' }}"></i> {{ __('backend/product.product_list') }}</h2></div>
					<div class="col-md-5"><a href="{{ route('admin.product.create') }}" class="float-right btn btn-primary"><i class="fa fa-plus"></i> {{ __('backend/default.add_new') }}</a></div>

					@elseif ('view' == 'add')
					<div class="col-md-6"><h2><i class="{{ 'fa fa-eye' }}"></i> {{ __('backend/product.add_product') }}</h2></div>
					<div class="col-md-5"><a href="{{ route('admin.product.index') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>

					@elseif ('view' == 'edit')
					<div class="col-md-6"><h2><i class="{{ 'fa fa-eye' }}"></i> {{ __('backend/product.edit_product') }}</h2></div>
					<div class="col-md-5"><a href="{{ route('admin.product.index') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>

					@elseif ('view' == 'view')
					<div class="col-md-6"><h2><i class="{{ 'fa fa-eye' }}"></i> {{ __('backend/product.view_product') }}</h2></div>
					<div class="col-md-5">
						<div class="btn-group float-right">
							<a href="{{ route('admin.product.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a><a href="{{ route('admin.product.edit',$row->slug) }}" class="btn btn-warning"><i class="fa fa-edit"></i> {{ __('backend/default.edit') }}</a>
						</div>
					</div>
					@endif
					<div class="col-md-1">
						<h2>
							<a href="#" onclick="print_method()" class="btn btn-primary text-center float-right">
								<i class="fa fa-print"></i> {{ __('backend/default.print') }}
							</a>
						</h2>
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
				<div class="hide col-sm-12 text-center"><h5><i class="{{ 'fa fa-table' }}"></i>Product Details</h5></div>

				<div class="w-100">
					<div class="table-responsive">
						<table class="table table-bordered display table-striped">
							<tbody>
								<tr>
									<td>
										<strong>Title: </strong>
									</td>
									<td>
										<span class="monospace-inconsolata">{{ $row->title }}</span>
									</td>
								</tr>
								<tr>
									<td>
										<strong>Photo: </strong>
									</td>
									<td>
										<img class="monospace-inconsolata" style="width: 200px;" src="{{ asset($row->image) }}">
									</td>
								</tr>
								<tr>
									<td>
										<strong>Category: </strong>
									</td>
									<td>
										<span class="monospace-inconsolata">{{ $row->category->title }}</span>
									</td>
								</tr>
								<tr>
									<td>
										<strong>Details: </strong>
									</td>
									<td>
										<span class="monospace-inconsolata">{!! $row->description !!}</span>
									</td>
								</tr>
								<tr>
									<td>
										<strong>Purchase Price: </strong>
									</td>
									<td>
										<span class="monospace-inconsolata">{{ $row->purchase_price }}</span>
									</td>
								</tr>
								<tr>
									<td>
										<strong>Sale Price: </strong>
									</td>
									<td>
										<span class="monospace-inconsolata">{{ $row->regular_sale_price }}</span>
									</td>
								</tr>
								<tr>
									<td>
										<strong>Discount: </strong>
									</td>
									<td>
										<span class="monospace-inconsolata">{{ $row->discount }}</span>
									</td>
								</tr>
								<tr>
									<td>
										<strong>Total Sale: </strong>
									</td>
									<td>
										<span class="monospace-inconsolata">{{ $row->total_sale }}</span>
									</td>
								</tr>
								<tr style="background-color: lightcyan;">
									<td>
										<strong>Created: </strong>
									</td>
									<td>
										<span class="monospace-inconsolata">{{ date_format($row->created_at,"d/M/Y H:i:sa") }}</span>
									</td>
								</tr>
								<tr style="background-color: lightgoldenrodyellow;">
									<td>
										<strong>Updated: </strong>
									</td>
									<td>
										<span class="monospace-inconsolata">{{ date_format($row->updated_at,"d/M/Y H:i:sa") }}</span>
									</td>
								</tr>
								<tr>
									<td>
										<strong>Status: </strong>
									</td>
									<td>
										<span class="monospace-inconsolata">{{ $row->status == 1 ? 'Active' : 'Deactive' }}</span>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endsection

	<!-- Write Scripts <script fileType="text/javascript">In Here</script> -->
	@section('scripts')
	@endsection
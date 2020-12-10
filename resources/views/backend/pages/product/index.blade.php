<!-- Full Structure -->
@extends('backend.layouts.master')

@section('fav_title', __('backend/product.product') )

<!-- Write Styles <style>In Here</style> -->
@section('styles')
<style type="text/css">
	td.p-1{
		text-align: center;
	}
</style>
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
		@if ('index' == 'index')
		<li class="breadcrumb-item active">{{ __('backend/product.product') }}</li>
		@elseif ('index' == 'add')
		<li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">{{ __('backend/product.product') }}</a></li>
		<li class="breadcrumb-item active">{{ __('backend/default.add_new') }}</li>
		@elseif ('index' == 'edit')
		<li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">{{ __('backend/product.product') }}</a></li>
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
					<div class="col-md-6"><h2><i class="{{ 'fa fa-table' }}"></i> {{ __('backend/product.product_list') }}</h2></div>
					<div class="col-md-5"><a href="{{ route('admin.product.create') }}" class="float-right btn btn-primary"><i class="fa fa-plus"></i> {{ __('backend/default.add_new') }}</a></div>

					@elseif ('index' == 'add')
					<div class="col-md-6"><h2><i class="{{ 'fa fa-table' }}"></i> {{ __('backend/product.add_product') }}</h2></div>
					<div class="col-md-5"><a href="{{ route('admin.product.index') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>

					@elseif ('index' == 'edit')
					<div class="col-md-6"><h2><i class="{{ 'fa fa-table' }}"></i> {{ __('backend/product.edit_product') }}</h2></div>
					<div class="col-md-5"><a href="{{ route('admin.product.index') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>
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
				<div class="hide col-sm-12 text-center"><h4><i class="{{ 'fa fa-table' }}"></i> All Product</h4></div>

                <form action="{{ route('admin.product.index') }}" method="post" class="none">
					@csrf
					<div class="row mb-3">
						{{-- <!--<div class="col-md-4">-->
						<!--	<select name="cost_field_id" id="cost_field_id" class="form-control">-->
						<!--		<option disabled selected>Select Cost Field</option>-->
						<!--		@foreach($cost_fields as $cost_field)-->
						<!--		<option value="{{ $cost_field->id }}" {{ $app->request->input('cost_field_id') ==  $cost_field->id ? 'selected' : ''}}>{{ $cost_field->title }}</option>-->
						<!--		@endforeach-->
						<!--	</select>-->
						<!--</div>--> --}}
        				<div class="col-md-4 col-sm-10 ml-2">
        				    <select name="category__" id="category__" class="form-control">>
        				        <option disabled selected>Select Category</option>
        				        @foreach ($categories as $category)
        				        <option {{ $_category ==  $category->id ? 'selected' : ''}} value="{{ $category->id }}">{{ $category->title }}</option>
        				        @endforeach
        				    </select>
        				</div>
        				
					    <button class="btn btn-primary searchByDate col-md-1 col-sm-2" type="submit">{{ __('backend/default.search') }}</button>

					</div>
				</form>
				<!-- Permission for Admin Access -->
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


				<div class="toggle-table-column alert-info br-2 p-2 mb-2 none">
					<strong>{{ __('backend/default.table_toggle_message') }} </strong>
					<br>

					<a href="#" class="toggle-vis" data-column="0"><b>{{ __('backend/default.sl') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="1"><b>{{ __('backend/default.title') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="2"><b>{{ __('backend/default.photo') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="3"><b>{{ __('backend/category.category') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="4"><b>{{ __('backend/default.purchase_price') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="5"><b>{{ __('backend/product.regular_sale_price') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="6"><b>{{ __('backend/default.status') }}</small></b></a> |
					<a href="#" class="toggle-vis" data-column="7"><b>{{ __('backend/default.action') }}</small></b></a>

				</div>
				<div class="table-responsive pt-1">
					<table id="datatable" class="table table-bordered table-hover display">

						<thead>
							<th>{{ __('backend/default.sl') }}</th>
							<th>{{ __('backend/default.title') }}</th>
							<th>{{ __('backend/default.photo') }}</th>
							<th>{{ __('backend/category.category') }}</th>
							<th>{{ __('backend/default.purchase_price') }}</th>
							<th>{{ __('backend/product.regular_sale_price') }}</th>
							<th>{{ __('backend/default.status') }}</th>
							<th class="action">{{ __('backend/default.action') }}</th>
						</thead>
						<tbody>


							@foreach ($rows as $row)
							<tr class="{{ $row->status == 0 ? 'deactive_':'' }}">
								<td>{{ $loop->index+1 }}</td>
								<td>{{ $row->title }}</td>
								<td class="p-1">
									<img src="{{ asset($row->image) }}" class="img-thumbnail" style="height: 62px;">
								</td>
								<td>
									<!-- <i class="fa fa-pie-chart"></i> -->
									 {{ $row->category->title }}
								</td>
								<td>{{ $row->purchase_price }}</td>
								<td>{{ $row->regular_sale_price }}</td>
								<td>{{ $row->status == 1 ? 'Actived' : 'Deactived' }}</td>
								<td class="action">
									<div class="btn-group">

										<!-- Checking Admin Access -->
										@foreach($permissions->submenus as $key => $permission)
										@if(\App\Models\Menu::checkBodyMenu($permission->id, $bodyMenu->in_body))
                                        @if($key == 0)
                                        <a href="{{route($permission->route, $row->slug)}}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                        @elseif($key == 1)
                                        <a href="{{route($permission->route, $row->slug)}}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                        @else
                                        <button class="btn {{ $row->status == 0 ? 'btn-secondary disabled':' btn-danger' }}" onClick="deleteMethod({{ json_encode($row->id) }})" role="button" {{ $row->status == 0? 'disabled':'' }}><i class="fa fa-minus-circle"></i></button>
                                        @endif
										@endif
										@endforeach
									</div>
								</td>
							</tr>
							@endforeach

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
<script>
    $('#category__').select2();
</script>
@endsection
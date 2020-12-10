<!-- Full Structure -->
@extends('backend.layouts.master')

@section('fav_title', __('backend/purchase_item.purchase_item') )

<!-- Write Styles <style>In Here</style> -->
@section('styles')
<style type="text/css">

	@media print{
		.none,
		.toggle-table-column {
			display: none !important;
		}
		.hide {
			display: block !important;
		}
		.hide_tbl_tr {
			display: table-cell !important;
		}
		.text-white {
			color: #000000 !important;
		}
	}
	.hide {
		display: none;
	}
</style>
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
		<li class="breadcrumb-item active">{{ __('backend/purchase_item.purchase_item') }}</li>
	</ul>
</div>

<!-- Table Part -->
<div class="row">
	<div class="col-md-12">
		<div class="card">

			<div class="card-header none">
				<div class="row">
					<div class="col-md-6"><h2><i class="{{ 'fa fa-table' }}"></i> {{ __('backend/purchase_item.purchase_item_list') }}</h2></div>
					<div class="col-md-6">
						<a href="{{ route('admin.purchase_item.add') }}" class="float-right btn alert-primary"><i class="fa fa-plus"></i> {{ __('backend/default.add_new') }}</a>
						<button class="btn btn-info alert-info float-right mr-2" onclick="print_method()">
							<i class="fa fa-fw fa-print"></i>{{ __('backend/default.print') }}
						</button>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>

			<div class="card-body">

				<!-- Permission for Admin Access -->
				@php
					$permissions = \App\Models\Menu::orderBy('id', 'desc')->where('url', substr(url()->current(), 1+strlen(url('/'))))
					->orWhere('url', substr(url()->current(), strlen(url('/'))))->first();
					if(Auth::guard('admin')->user()->admin_role == 3){
						$bodyMenu = \App\Models\Role::where('admin_id', Auth::guard('admin')->id())->first();
					}
					else{
						$bodyMenu = \App\Models\Role::where('role', Auth::guard()->user()->admin_role)->first();
					}
				@endphp

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
				<div class="hide col-sm-12 text-center"><h2>{{-- <i class="fa fa-table"></i> --}} Item List</h2></div>

				<div class="toggle-table-column alert-info br-2 p-2 mb-2">
					<strong>{{ __('backend/default.table_toggle_message') }} </strong>
					<br>

					<a href="#" class="toggle-vis" data-column="0"><b>{{ __('backend/default.sl') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="1"><b>{{ __('backend/default.title') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="2"><b>{{ __('backend/default.regular_price') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="3"><b>{{ __('backend/category.category') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="4"><b>{{ __('backend/default.description') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="5"><b>{{ __('backend/default.status') }}</small></b></a> |
					<a href="#" class="toggle-vis" data-column="6"><b>{{ __('backend/default.action') }}</small></b></a>

				</div>
				<div class="table-responsive pt-1">
					<table id="datatable" class="table table-bordered table-hover display none">

						<thead>
							<th width="5%">{{ __('backend/default.sl') }}</th>
							<th>{{ __('backend/default.title') }}</th>
							<th class="none">{{ __('backend/default.regular_price') }}</th>
							<th class="none">{{ __('backend/category.category') }}</th>
							<th class="none">{{ __('backend/default.description') }}</th>
							<th class="none">{{ __('backend/default.status') }}</th>
							<th width="15%" class="action text-center none">{{ __('backend/default.action') }}</th>
						</thead>
						<tbody>
							@foreach ($rows as $row)
							<tr class="{{ $row->status == 0 ? 'deactive_':'' }}">
								<td>{{ $loop->index+1 }}</td>
								<td>{{ $row->title }}</td>
								<td class="none">{{ $row->regular_price }}&nbsp;TK</td>
								<td class="none">{{ $row->raw_material_category ? $row->raw_material_category->title : "N/A"  }}</td>
								<td class="none">{{ $row->description }}</td>

								<td class="none">{{ $row->status == 1 ? 'Active' : 'Deactive' }}</td>
								<td class="action text-center none">
									<div class="btn-group">
										<!-- Checking Admin Access -->
										@foreach($permissions->submenus as $key => $permission)
											@if(\App\Models\Menu::checkBodyMenu($permission->id, $bodyMenu->in_body))

												@if($key == 0)
													<a class="btn btn-info" href="{{ route($permission->route, $row->id) }}"><i class="fa fa-edit"></i></a>
												@else
													<button class="btn text-white {{ $row->status == 0? ' btn-secondary disabled':' btn-danger' }}" onClick="deleteMethod({{ $row->id }})" {{ $row->status == 0? 'disabled':'' }}><i class="fa fa-trash"></i></button>
												@endif

											@endif
										@endforeach
									</div>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					<div class="hide">
						@foreach($groups as $key=>$group)
							<h5>
								<strong>{{ $key }}</strong>
							</h5>	
							<table  class="table table-bordered table-hover">
								<tr>
									<th width="5%">SL</th>
									<th width="55%">Title</th>
									<th width="20%">Quantity</th>
									<th width="20%">Price</th>
								</tr>
								@foreach($group as $key=>$row )
								<tr>
									<td>{{ $key+1 }}</td>
									<td>{{ $row->title }}</td>
									<td></td>
									<td></td>
								</tr>
								@endforeach
							</table>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

<!-- Write Scripts <script fileType="text/javascript">In Here</script> -->
@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		$("#datatable_wrapper").children(":first").addClass('none');
		$("#datatable_wrapper").children(":last").addClass('none');
	});
</script>
@endsection
<!-- Full Structure -->
@extends('backend.layouts.master')

@section('fav_title', __('backend/purchase_item.purchase_history') )

<!-- Write Styles <style>In Here</style> -->
@section('styles')
@endsection

<!-- This Section Will Shown <body>In Here</body> -->
@section('content')
<!-- Top Management Part -->
<div class="app-title">
	<div>
		<h1><i class="{{ 'fa fa-sitemap' }}"></i> {{ __('backend/purchase_item.purchase_management') }}</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
		<li class="breadcrumb-item active">{{ __('backend/purchase_item.purchase_history') }}</li>
	</ul>
</div>

<!-- Table Part -->
<div class="row">
	<div class="col-md-12">
		<div class="card">

			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h2><i class="{{ 'fa fa-table' }}"></i> {{ __('backend/purchase_item.purchase_list') }}</h2></div>
					<div class="col-md-5"><a href="{{ route('admin.purchase.add') }}" class="float-right btn btn-primary"><i class="fa fa-plus"></i> {{ __('backend/default.add_new') }}</a></div>
					<div class="col-md-1">
						<a href="#" onclick="print_method()" class="btn btn-primary text-center float-right">
							<i class="fa fa-print"></i> {{ __('backend/default.print') }}
						</a>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>

			<div class="card-body">
				<form action="{{ route('admin.purchase.index') }}" method="post" class="none">
					@csrf
					<div class="row mb-3">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-3">
									<div class="input-group date" id="fromDate" data-provide="datepicker">
										<input placeholder="From" type="text" class="form-control from_date" name="from_date" value="" autocomplete="off">
										<div class="input-group-addon from_icon">
											<span><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group date" id="toDate" data-provide="datepicker">
										<input placeholder="To" type="text" class="form-control to_date" name="to_date" value="" autocomplete="off">
										<div class="input-group-addon to_icon">
											<span><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<select class="form-control" name="purchase_field_id" id="select2">
											<option value="" selected disabled>----Select Purchase Field-----</option>
											@php
												$purchase_fields = \App\Models\PurchaseItem::where('status', 1)->get();
											@endphp
											@foreach($purchase_fields as $purchase_field)
											<option value="{{ $purchase_field->id }}">{{ $purchase_field->title }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-1">
									<button class="btn btn-primary searchByDate" type="submit">{{ __('backend/default.search') }}</button>
								</div>
								<div class="col-md-2">
									<div class="form-control">
										{{-- Don't Change --}}
										<strong>Total:
											@php
											$total_ = 0;
											$purchase_history = \App\Models\PurchaseHistory::where('status', 1)->get();
											foreach ($purchase_history as $value) {
												$total_ += (int)$value->price;
											}
											echo $total_." TK";
											@endphp
										</strong>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
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
				<div class="hide col-sm-12 text-center"><h5><i class="{{ 'fa fa-table' }}"></i> Purchase History</h5></div>


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

				<div class="toggle-table-column alert-info br-2 p-2 mb-2 none">
					<strong>{{ __('backend/default.table_toggle_message') }} </strong>
					<br>

					<a href="#" class="toggle-vis" data-column="0"><b>{{ __('backend/default.sl') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="1"><b>{{ __('backend/default.date') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="2"><b>{{ __('backend/default.purchase') }} {{ __('backend/default.field') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="3"><b>{{ __('backend/default.price') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="4"><b>{{ __('backend/default.quantity') }}</b></a> |
					{{-- <a href="#" class="toggle-vis" data-column="4"><b>{{ __('backend/unit.unit') }}</b></a> | --}}
					{{-- <a href="#" class="toggle-vis" data-column="5"><b>{{ __('backend/default.description') }}</b></a> | --}}
					<a href="#" class="toggle-vis" data-column="5"><b>{{ __('backend/default.voucher') }}</small></b></a> |
					{{-- <a href="#" class="toggle-vis" data-column="5"><b>{{ __('backend/default.status') }}</small></b></a> | --}}
					<a href="#" class="toggle-vis" data-column="6"><b>{{ __('backend/default.action') }}</small></b></a>

				</div>
				<div class="table-responsive pt-1">
					<table id="datatable" class="table table-bordered table-hover display">

						<thead>
							<th width="7%">{{ __('backend/default.sl') }}</th>
							<th>{{ __('backend/default.date') }}</th>
							<th>{{ __('backend/default.purchase') }} {{ __('backend/default.field') }}</th>
							<th>{{ __('backend/default.price') }}</th>
							<th>{{ __('backend/default.quantity') }}</th>
							{{-- <th>{{ __('backend/unit.unit') }}</th> --}}
							{{-- <th>{{ __('backend/default.description') }}</th> --}}
							<th>{{ __('backend/default.voucher') }}</th>
							{{-- <th>{{ __('backend/default.status') }}</th> --}}
							<th width="15%" class="action text-center">{{ __('backend/default.action') }}</th>
						</thead>
						<tbody>
							@foreach ($rows as $row)
							<tr class="{{ $row->status == 0 ? 'deactive_':'' }}">
								<td>{{ $loop->index+1 }}</td>
								<td>{{ $row->purchase_date }}</td>
								<td>{{ $row->purchase_item->title }}</td>
								<td>{{ $row->price }}&nbsp;TK</td>
								<td>{{ $row->quantity }}</td>
								{{-- <td>{{ $row->unit }}</td> --}}
								{{-- <td>{{ $row->description }}</td> --}}

								<td class="voucher cursor-help">{{ $row->voucher }}</td>
								{{-- <td>{{ $row->status == 1 ? 'Active' : 'Deactive' }}</td> --}}
								<td class="action text-center">
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
		$('.voucher').on('click', function(event) {
			var voucher = $(this).text();
			var search_input = $("#datatable_filter").find('input');
			search_input.val(voucher);
			search_input.focus();
		});
	});
	$('#fromDate').datepicker({
			format: 'yyyy-mm-dd',
			todayHighlight:'TRUE',
			autoclose: true,
		});

		$('#toDate').datepicker({
			format: 'yyyy-mm-dd',
			todayHighlight:'TRUE',
			autoclose: true,
		});

		$('#datetimepicker1').datepicker({
			format: 'yyyy-mm-dd',
			todayHighlight:'TRUE',
			autoclose: true,
		});
</script>
@endsection
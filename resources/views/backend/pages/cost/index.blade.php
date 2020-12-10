<!-- Full Structure -->
@extends('backend.layouts.master')

@section('fav_title', __('backend/cost.cost') )

<!-- Write Styles <style>In Here</style> -->
@section('styles')
<style type="text/css">
	.datepicker {
		margin-top: 60px;
	}
	.input-group-addon i {
		height: 33px !important;
		right: 2px !important;
		top: 2px;
	}
	.td-padding td{
		padding: 0.55rem;
	}

</style>
@endsection

<!-- This Section Will Shown <body>In Here</body> -->
@section('content')
<!-- Top Management Part -->
<div class="app-title">
	<div>
		<h1><i class="{{ 'fa fa-contao' }}"></i> {{ __('backend/cost.cost_management') }}</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
		<li class="breadcrumb-item active">{{ __('backend/cost.cost') }}</li>
	</ul>
</div>

<!-- Table Part -->
<div class="row">
	<div class="col-md-12">
		<div class="card">

			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h2><i class="{{ 'fa fa-table' }}"></i> {{ __('backend/cost.cost_list') }}</h2></div>
					<div class="col-md-5"><a href="{{ route('admin.cost.add') }}" class="float-right btn btn-primary"><i class="fa fa-plus"></i> {{ __('backend/default.add_new') }}</a></div>
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
						<table class="table mb-0 border-0">
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
				<div class="hide col-sm-12 text-center"><h5><i class="{{ 'fa fa-table' }}"></i> All Cost</h5></div>


				<form action="{{ route('admin.cost.index') }}" method="post" class="none">
					@csrf
					<div class="row mb-3">
						<div class="col-md-11">
							<div class="row">
								<div class="col-md-4">
									<div class="input-group date" id="fromDate" data-provide="datepicker">
										<input type="text" class="form-control from_date" name="from_date" value="{{ $app->request->input('from_date') }}">
										<div class="input-group-addon from_icon">
											<span><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="input-group date" id="toDate" data-provide="datepicker">
										<input type="text" class="form-control to_date" name="to_date" value="{{ $app->request->input('to_date') }}">
										<div class="input-group-addon to_icon">
											<span><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<select name="cost_field_id" id="cost_field_id" class="form-control">
										<option disabled selected>Select Cost Field</option>
										@foreach($cost_fields as $cost_field)
										<option value="{{ $cost_field->id }}" {{ $app->request->input('cost_field_id') ==  $cost_field->id ? 'selected' : ''}}>{{ $cost_field->title }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>

						<div class="col-md-1 pr-3">
							<div class="row">
								<button class="btn btn-primary searchByDate" type="submit">{{ __('backend/default.search') }}</button>
							</div>
						</div>
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
				
				@php
					// Pagination Serial
					if (request()->filled('page')){
						$PreviousPageLastSN = $items*(request()->page-1); //PreviousPageLastSerialNumber
						$PageNumber = request()->page;
					}
					else{
						$PreviousPageLastSN = 0; //PreviousPageLastSerialNumber
						$PageNumber = 1;
					}

					//Last Page Items Change Restriction
					if ($PageNumber*$items > $total + $items){
						header('Location: ' . $_SERVER['HTTP_REFERER']);
						die();
					}
				@endphp

                @include('backend.partials.page_numbering', ['route' => 'admin.cost.index'])

				<div class="table-responsive pt-1">
					<table class="table table-bordered table-hover display">

						<thead>
							<th>{{ __('backend/default.sl') }}</th>
							<th>{{ __('backend/default.date') }}</th>
							<th>{{ __('backend/cost.cost_type') }}</th>
							<th>{{ __('backend/cost.cost_field') }}</th>
							{{-- <th>{{ __('backend/default.quantity') }}</th> --}}
							<th>{{ __('backend/default.description') }}</th>
							<th>{{ __('backend/cost.cost_by') }}</th>
							<th>{{ __('backend/cost.cost') }}</th>
							<th class="action">{{ __('backend/default.action') }}</th>
						</thead>
						<tbody>
							@php
								$totalPrice = 0;
							@endphp
							@foreach ($rows as $row)
							<tr class="{{ $row->status == 0 ? 'deactive_':'' }}">
								<td>{{ $loop->index+1 }}</td>
								<td>{{ $row->pickdate }}</td>
								<td>{{ $row->cost_type }}</td>
								<td>{{ $row->field_title }}</td>
								<td>{{ $row->description }}</td>
								<td>{{ $row->cost_by }}</td>
								<td>{{ $row->price.' TK' }} @php $totalPrice += $row->price; @endphp</td>
								<td class="action">
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
							<tr>
								<td colspan="6" class="text-right"><strong>{{ __('backend/default.total') }} </strong></td>
								<td class="border-right-0"> <strong>{{ $totalPrice }} TK</strong></td>
								<td class="none border-left-0"></td>
							</tr>

						</tbody>
					</table>
				</div>
				@include('backend.partials.pagination', ['table' => $rows])
			</div>
		</div>
	</div>
</div>
@endsection

<!-- Write Scripts <script fileType="text/javascript">In Here</script> -->
@section('scripts')
<script type="text/javascript">

	$(document).ready(function(){
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

		$("#cost_field_id").select2();
	});
</script>
@endsection
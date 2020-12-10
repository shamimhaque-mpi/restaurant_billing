<!-- Full Structure -->
@extends('backend.layouts.master')

@section('fav_title', __('backend/report.report') )

<!-- Write Styles <style>In Here</style> -->
@section('styles')
@endsection

<!-- This Section Will Shown <body>In Here</body> -->
@section('content')
<!-- Top Management Part -->
<div class="app-title">
	<div>
		<h1><i class="{{ 'fa fa-credit-card' }}"></i> {{ __('backend/report.report_management') }}</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
		<li class="breadcrumb-item active">{{ __('backend/report.report') }}</li>
	</ul>
</div>

<!-- Table Part -->
<div class="row">
	<div class="col-md-12">
		<div class="card">

			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h2><i class="{{ 'fa fa-table' }}"></i> {{ __('backend/default.cost') }} {{ __('backend/report.report') }}</h2></div>
					{{-- <div class="col-md-6"><a href="{{ route('admin.report.add') }}" class="float-right btn btn-primary"><i class="fa fa-plus"></i> {{ __('backend/default.add_new') }}</a></div> --}}
					<div class="col-md-6">
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
							<tr>
							    <th class="text-center p-0 border-0">Cost Report</th>
							</tr>
						</table>
					</div>
				</div>
				
				<form action="{{ route('admin.report.cost') }}" method="post" class="none col-md-12">
					@csrf
					<div class="form-row mb-3">
						<div class="col-md-3">
							<div class="input-group date" id="fromDate" data-provide="datepicker">
								<input placeholder="To" type="text" class="form-control from_date" name="from_date" value="{{ $app->request->input('from_date') }}" autocomplete="off">
								<div class="input-group-addon from_icon">
									<span><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="input-group date" id="toDate" data-provide="datepicker">
								<input placeholder="From" type="text" class="form-control to_date" name="to_date" value="{{ $app->request->input('to_date') }}" autocomplete="off">
								<div class="input-group-addon to_icon">
									<span><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="input-group">
								<select class="form-control" name="cost_field_id" id="select2">
									<option value="" selected disabled>--Select Cost Field--</option>
									@php
									$cost_fields = \App\Models\Cost_field::where('status', 1)->get();
									@endphp
									@foreach($cost_fields as $cost_field)
									<option value="{{ $cost_field->id }}">{{ $cost_field->title }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-md-1">
							<button class="btn btn-primary searchByDate" type="submit">{{ __('backend/default.search') }}</button>
						</div>
						<div class="col-md-2">
							<div class="form-control"><strong>Total: 
								{{ \App\Models\Cost::where('status', 1)->get()->sum('price') }} TK</strong>
							</div>
						</div>

					</div>
				</form>
				<div class="table-responsive pt-1">
					<table id="datatable" class="table table-bordered table-hover table-striped display">
						<thead>
							<tr>
								<th>{{ __('backend/default.sl') }}</th>
								<th>{{ __('backend/default.date') }}</th>
								<th>{{ __('backend/cost.cost_type') }}</th>
								<th>{{ __('backend/cost.cost_field') }}</th>
								<th>{{ __('backend/default.description') }}</th>
								<th>{{ __('backend/cost.cost') }}</th>
								<th>{{ __('backend/cost.cost_by') }}</th>
							</tr>
						</thead>
						<tbody>
							@php
						    	$totalPrice = 0;
						    @endphp
							@foreach ($costs as $row)
							<tr class="{{ $row->status == 0 ? 'deactive_':'' }}">
								<td>{{ $loop->index+1 }}</td>
								<td>{{ $row->pickdate }}</td>
								<td>{{ $row->cost_type }}</td>
								<td>{{ $row->field_title }}</td>
								<td>{{ $row->description }}</td>
								<td>{{ $row->price.' TK' }} @php $totalPrice += $row->price; @endphp</td>
								<td>{{ $row->cost_by }}</td>
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
		$('#select2').select2();
	</script>
@endsection
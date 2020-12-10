<!-- Full Structure -->
@extends('backend.layouts.master')

@section('fav_title', "SMS - Report" )

<!-- Write Styles <style>In Here</style> -->
@section('styles')
@endsection

<!-- This Section Will Shown <body>In Here</body> -->
@section('content')
<!-- Top Management Part -->
<div class="app-title">
	<div>
		<h1><i class="{{ 'fa fa-dashboard' }}"></i> {{ __('backend/journal.journal_management') }}</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
		<li class="breadcrumb-item active">{{ __('backend/journal.journal') }}</li>
	</ul>
</div>

<!-- Table Part -->
<div class="row">
	<div class="col-md-12">
		<div class="card">

			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h2><i class="{{ 'fa fa-table' }}"></i> Report</h2></div>
					<div class="col-md-5 text-right"><strong class="text-success">Total Sent: {{ $totalSms }}</strong></div>
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
							<tr>
							    <th class="text-center p-0 border-0">SMS Report</th>
							</tr>
						</table>
					</div>
				</div>

				<div class="table-responsive pt-1">
					<table id="datatable" class="table table-bordered table-hover display">

						<thead>
							<th>SL</th>
							<th width="10%">Mobile</th>
							<th width="10%">Send At</th>
							<th width="15%">Send By</th>
							<th>Size</th>
							<th>Status</th>
							<th>Message</th>
						</thead>
						<tbody>
							@foreach($allSms as $key => $value)
								<tr>
									<td>{{ $loop->index + 1 }}</td>
									<td>{{ $value->mobile }}</td>
									<td>{{ $value->sending_date }}</td>
									<td>{{ $value->send_by_user }}</td>
									<td>{{ $value->sms_count }}</td>
									<td>{{ $value->is_send == 1 ? 'Delivered' : 'Not Sent' }}</td>
									<td>{{ $value->sms }}</td>
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
@endsection
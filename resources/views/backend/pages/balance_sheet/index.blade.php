<!-- Full Structure -->
@extends('backend.layouts.master')

@section('fav_title', __('backend/balance_sheet.balance_sheet') )

<!-- Write Styles <style>In Here</style> -->
@section('styles')

<style type="text/css">
	.datepicker {
		margin-top: 60px;
	}
	.input-group-addon i {
		height: 33px !important;
		right: 2px;
		top: 2px;
	}
</style>
@endsection

<!-- This Section Will Shown <body>In Here</body> -->
@section('content')


<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-11">
				<h2><i class="fa fa-table"></i> {{ __('backend/balance_sheet.balance_sheet') }}</h2>
			</div>
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
		<div class="hide col-sm-12 text-center"><h5><i class="{{ 'fa fa-table' }}"></i>Balance Sheet</h5></div>

		<form action="{{ route('admin.balance_sheet.index') }}" method="post" class="none">
			@csrf
			<div class="row mb-3">
				<div class="col-md-3">
					<div class="input-group date" id="fromDate" data-provide="datepicker">
						<input type="text" class="form-control from_date" name="from_date" value="{{ $app->request->input('from_date') }}" autocomplete="off">
						<div class="input-group-addon from_icon">
							<span><i class="fa fa-calendar"></i></span>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="input-group date" id="toDate" data-provide="datepicker">
						<input type="text" class="form-control to_date" name="to_date" value="{{ $app->request->input('to_date') }}" autocomplete="off">
						<div class="input-group-addon to_icon">
							<span><i class="fa fa-calendar"></i></span>
						</div>
					</div>
				</div>
				<div class="col-md-1">
					<button class="btn btn-primary searchByDate" type="submit">{{ __('backend/default.search') }}</button>
				</div>
			</div>
		</form>
		<br>

		<div class="row">

			{{-- Table of sales --}}
			<div class="col-md-6">
				<div class="card mb-2">
					<div class="card-header">
						<div class="row">
							<div class="col-md-12"><h2><i class="fa fa-table"></i> {{ __('backend/balance_sheet.sales') }}</h2></div><div class="clearfix"></div>
						</div>
					</div>

					<div class="card-body">        
						<div class="table-responsive">
							<table class="table table-bordered table-hover display">
								<thead>
									<th>{{ __('backend/default.sl') }}</th>
									<th>{{ __('backend/default.date') }}</th>
									<th>{{ __('backend/default.voucher') }}</th>
									<th>{{ __('backend/balance_sheet.amount') }}</th>
								</thead>
								<tbody>
									@php
									$totalSale = 0;
									$i = 0;
									@endphp	
									@foreach($sales as $sale)
										@if($sale->given_money > 0)	
										<tr class="">
											<td>{{ $i = $i + 1 }}</td>
											<td>{{ substr($sale->created_at, 0, 10) }}</td>
											<td>{{ \App\Helpers\CalculationHelper::generateVoucher($sale->id) }}</td>
											<td>{{ $sale->given_money.' ৳' }} @php $totalSale += $sale->given_money; @endphp</td>                  
										</tr>
										@endif
									@endforeach 
									<tr>
										<td colspan="3" class="text-right"><strong>{{ __('backend/default.total') }}</strong></td>
										<td><strong>{{ $totalSale.' ৳' }}</strong></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			{{-- Table of Purcheses --}}
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<div class="row">
									<div class="col-md-12"><h2><i class="fa fa-table"></i> {{ __('backend/balance_sheet.purchases') }}</h2></div><div class="clearfix"></div>
								</div>
							</div>
							<div class="card-body">        
								<div class="table-responsive">
									<table  class="table table-bordered table-hover display">
										<thead>
											<th>{{ __('backend/default.sl') }}</th>
											<th>{{ __('backend/default.date') }}</th>
											<th>{{ __('backend/default.voucher') }}</th>
											<th>{{ __('backend/balance_sheet.amount') }}</th>
										</thead>
										<tbody>
											@php
											$totalPuchase = 0;
											@endphp	
											@foreach($purchases as $purchase)
												{{-- @dd($purchases, $purchase); --}}
											<tr class="">
												<td>{{ $loop->index + 1 }}</td>
												<td>{{ $purchase->date }}</td>
												{{-- <td>{{ \App\Helpers\CalculationHelper::generateVoucher($purchase->id) }}</td> --}}
												<td>{{ $purchase['voucher'] }}</td>
												<td>{{ $purchase['price'].' ৳' }} @php $totalPuchase += $purchase['price']; @endphp</td>                  
											</tr>
											<tr>
												@endforeach	
												<td colspan="3" class="text-right"><strong>{{ __('backend/default.total') }}</strong></td>
												<td><strong>{{ $totalPuchase.' ৳' }}</strong></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			{{-- Table of Dues --}}
			<div class="col-md-6">
				<div class="card mb-2">
					<div class="card-header">
						<div class="row">
							<div class="col-md-12"><h2><i class="fa fa-table"></i> {{ __('backend/balance_sheet.due_collection') }}</h2></div><div class="clearfix"></div>
						</div>
					</div>

					<div class="card-body">        
						<div class="table-responsive">
							<table class="table table-bordered table-hover display">
								<thead>
									<th>{{ __('backend/default.sl') }}</th>
									<th>{{ __('backend/default.date') }}</th>
									<th>{{ __('backend/default.voucher') }}</th>
									<th>{{ __('backend/balance_sheet.amount') }}</th>
								</thead>
								<tbody>
									@php
									$totalSale = 0;
									$i = 0;
									@endphp	
									@foreach($dues as $due)
									@if($due->payment > 0)	
									<tr class="">
										<td>{{ $i = $i + 1 }}</td>
										<td>{{ $due->date }}</td>
										<td>{{ \App\Helpers\CalculationHelper::generateVoucher($due->id) }}</td>
										<td>{{ $due->payment.' ৳' }} @php $totalSale += $due->payment; @endphp</td>                  
									</tr>
									@endif
									@endforeach 
									<tr>
										<td colspan="3" class="text-right"><strong>{{ __('backend/default.total') }}</strong></td>
										<td><strong>{{ $totalSale.' ৳' }}</strong></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			{{-- Table of Cost --}}
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col-md-12"><h2><i class="fa fa-table"></i> {{ __('backend/cost.cost') }}</h2></div><div class="clearfix"></div>
						</div>
					</div>
					<div class="card-body">        
						<div class="table-responsive">
							<table  class="table table-bordered table-hover display">
								<thead>
									<th>{{ __('backend/default.sl') }}</th>
									<th>{{ __('backend/default.date') }}</th>
									<th>{{ __('backend/default.voucher') }}</th>
									<th>{{ __('backend/balance_sheet.amount') }}</th>
								</thead>
								<tbody>
									@php
									$totalCost = 0;
									@endphp
									@foreach($costs as $cost)
									<tr class="">
										<td>{{ $loop->index + 1 }}</td>
										<td>{{ substr($cost->created_at, 0, 10)}}</td>
										{{-- <td>{{ \App\Helpers\CalculationHelper::generateVoucher($cost->id) }}</td> --}}
										<td>{{ $cost_fields[$cost->cost_field_id] }}</td>
										<td>{{ $cost->price.' ৳' }} @php $totalCost += $cost->price; @endphp</td>                  
									</tr>
									@endforeach
									<tr>
										<td colspan="3" class="text-right"><strong>{{ __('backend/default.total') }}</strong></td>
										<td><strong>{{ $totalCost.' ৳' }}</strong></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				@php
					$PuchaseCost = $totalPuchase + $totalCost;
				@endphp
				<div class="row">
					<div class="col-md-12 mt-3">
						<strong class="w-100 {{ $PuchaseCost > 0 ? 'alert-danger' : 'alert-success' }} d-block text-center pt-3 pb-2 br-2">
							<h3>Total : {{ $PuchaseCost }} ৳ </h3>
						</strong>
					</div>
				</div>
			</div>
			
			{{-- Table of Closing --}}
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col-md-12"><h2><i class="fa fa-table"></i> {{ __('backend/balance_sheet.closing') }}</h2></div><div class="clearfix"></div>
						</div>
					</div>

					<div class="card-body">        
						<div class="table-responsive">
							<table class="table table-bordered table-hover display">
								<thead>
									<th>{{ __('backend/default.sl') }}</th>
									<th>{{ __('backend/default.date') }}</th>
									<th>{{ __('backend/default.opening_balance') }}</th>
									<th>{{ __('backend/balance_sheet.closing_balance') }}</th>
								</thead>
								<tbody>
									@php
									    $opening_balance = 0;
									@endphp	
									@foreach($closing_balane as $value)
									@php
									    if($loop->index>0){
    									    $opening_balance = $closing_balane[($loop->index-1)]->closing_balance;
    									}
									@endphp
									<tr class="">
										<td>{{ $loop->index + 1 }}</td>
										<td>{{ $value->date }}</td>
										<td>{{ $opening_balance }}</td>
										<td>{{ $value->closing_balance }}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
							
							@php
							    $closing_balance = $totalSale - ($totalPuchase+$totalCost);
							@endphp
							<div style="text-align: right;"><a href="{{ route("admin.balance_sheet.closing",$closing_balance) }}" class="btn btn-primary">Closing</a></div>
						</div>
					</div>
				</div>
			</div>

		</div>
		<br>
		<br>
		@php
			$balance = $totalSale - ($totalPuchase+$totalCost)
		@endphp
		{{-- <div class="row {{ $balance > 0 ? 'alert-success' : 'alert-danger' }} pt-2">
			<div class="col-md-12 text-center"><strong><h3>Total : {{ $balance }} </h3></strong></div>
		</div>	 --}}

		<div class="row">
			<div class="col-md-12 mt-3">
				<strong class="w-100 {{ $totalDue->total_collection > 0 ? 'alert-success' : 'alert-danger' }} d-block text-center pt-3 pb-2 br-2">
					<h3>Total Balance : {{ $totalDue->total_collection }} ৳ </h3>
				</strong>
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
	});
</script>
@endsection
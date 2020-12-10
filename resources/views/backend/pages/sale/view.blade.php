@extends('backend.layouts.master')

@section('fav_title', 'Sale')

@section('styles')
<link href="https://fonts.googleapis.com/css?family=Oleo+Script&display=swap" rel="stylesheet">
<style>
	@media print{
		.none{
			display: none;
		}
		.hide{
			display: block !important;
		}
		.text-white{
			/*font-family: 'Oleo Script', cursive;*/
			color: #000000 !important;
		}
		.pm_0{
		    padding:0 !important;
		    margin:0 !important;
		}
		.v_customer label {
		    margin-left: 20px;
		}
		.v_customer,
		.table {
		    max-width: 425px;
		    width: 100%;
		}
		.total_width {width: 90px;}
		.table tr th,
		.table tr td {
		    padding: 5px !important;
		}
		.v_customer {
		    margin-top: 0 !important;
		    margin-bottom: 0 !important;
		}
		@page {
			/*margin-top: 2cm;
		    margin-bottom: 2cm;
		    margin-left: 2cm;
		    margin-right: 2cm;*/
			size :A4 portrait;
		}
	}
	
	.hide{
		display: none;
	}
</style>
@endsection

@section('content')
<div class="app-title">
	<div>
		<h1><i class="{{ 'fa fa-money' }}"></i> {{ __('backend/sale.sale_management') }}</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
		@if ('view' == 'index')
		<li class="breadcrumb-item active">{{ __('backend/sale.sale') }}</li>
		@elseif ('view' == 'add')
		<li class="breadcrumb-item"><a href="{{ route('admin.sale.index') }}">{{ __('backend/sale.sale') }}</a></li>
		<li class="breadcrumb-item active">{{ __('backend/default.add_new') }}</li>
		@elseif ('view' == 'edit')
		<li class="breadcrumb-item"><a href="{{ route('admin.sale.index') }}">{{ __('backend/sale.sale') }}</a></li>
		<li class="breadcrumb-item active">{{ __('backend/default.edit') }}</li>
		@elseif ('view' == 'view')
		<li class="breadcrumb-item"><a href="{{ route('admin.sale.index') }}">{{ __('backend/sale.sale') }}</a></li>
		<li class="breadcrumb-item active">{{ __('backend/default.view') }}</li>
		@endif
	</ul>
</div>


<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row none">
					<div class="col-md-6"><h2>{{-- <i class="{{ 'fa fa-eye' }}"></i> --}} {{ __('backend/sale.view_sale') }}</h2></div>
					<div class="col-md-6">

						<a href="{{ route('admin.sale.index') }}" class="float-right btn btn-primary alert-primary ml-2"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a>

						<button class="btn alert-info float-right ml-2" onclick="print_method()">
							<i class="fa fa-fw fa-print"></i>{{ __('backend/default.print') }}
						</button>
						<a href="{{ route('admin.sale.custom.bill', $sales[0]->sale_id) }}" class="float-right btn btn-primary alert-primary ml-2"><i class="fa fa-plus"></i> {{ __('backend/default.bill') }}</a>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>

			<div class="card-body pm_0">
				<div class="row">
					@php
					$sale_id = $sales[0]->sale_id;
					$sale_id_len = strlen((string)$sales[0]->sale_id);
					$voucher = $sales[0]->sale_id;
					if($sale_id_len < 2){
						$voucher = "00000".$sale_id;
					}
					elseif($sale_id_len < 3){
						$voucher = "0000".$sale_id;
					}
					elseif($sale_id_len < 4){
						$voucher = "000".$sale_id;
					}
					elseif($sale_id_len < 5){
						$voucher = "00".$sale_id;
					}
					elseif($sale_id_len < 2){
						$voucher = "0".$sale_id;
					}

					$site_setting = \App\Models\Setting::first();
					@endphp

					<div class="col-sm-12 hide">
						<div class="row">

							<table class="table table-bordered mb-0 ml-3" style="border-bottom: 2px solid #009688;">
								<tr>
									<th class="text-center p-0 border-0">
										<h3 style="font-family: 'Oleo Script', cursive;">{{ strtoupper($site_setting->title) }}</h3>
										<span>{!! $site_setting->address !!}</span> <br />
										<p class="p-0 m-1">
											 {{ $site_setting->email }}
											 {{ $site_setting->mobile }}
											
										</p>
									</th>
								</tr>
							</table>

							{{-- <div class="col-sm-4">
								<img class=" mt-3" src="{{ asset('public/images/settings/'.$site_setting->favicon) }}" style="height: 50px; width: 50px; float: left;">
							</div>
							<div class="col-sm-4 text-center">
								<h4>{{ $site_setting->title }}</h4>
								<span>{!! $site_setting->address !!}</span>
							</div>
							<div class="col-sm-4 text-right">
								<p class="mt-3">
									{{ $site_setting->email }} : <i class="fa fa-envelope"></i><br>
									{{ $site_setting->mobile }} : <i class="fa fa-phone-square"></i><br>
									{{ $site_setting->facebook }} : <i class="fa fa-facebook-square"></i>
								</p>
							</div> --}}
						</div>
					</div>
					<div class="col-sm-12 v_customer">
						<div class="row">
							<div class="col-6">
								<label class="mx-0"><strong>{{ __('backend/default.voucher') }}:</strong> <span class="">{{ $voucher }}</span> </label>
							</div>
							
							<div class="col-6">
								<label class="mx-0 float-right"><strong>{{ __('backend/default.table_no') }}</strong> : {{ $sales[0] ? $sales[0]->table_name : "N/A" }}</label>
							</div>
							<div class="col-md-6 col-12">
								<label class="mx-0"><strong>{{ __('backend/default.date') }}</strong> : {{ date('Y-M-d') }} {{ date('h:i:s a') }}</label><br>
							</div>
							<div class="col-md-6 none">
								<div class="d-flex justify-content-end align-items-center">
									<label class="m-0" for="first"><input name="table" checked="true" type="radio" id="first" value="kitchen">&nbsp;Kitchen</label>&nbsp;&nbsp;&nbsp;&nbsp;
									<label class="m-0" for="second"><input name="table" type="radio" id="second" value="start_order">&nbsp;Due Memo</label>&nbsp;&nbsp;&nbsp;&nbsp;
									<label class="m-0" for="third"><input name="table" type="radio" id="third" value="close_order">&nbsp;Paid Memo</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive">


				<!-- ===================== For kitchen ================== -->
							<div id="first_table" class="bill_memo">
								<table class="table table-bordered">
										<th width="30">{{ __('backend/default.sl') }}</th>
										<th >{{ __('backend/product.product') }}</th>
										<th width="40" class="total_width">{{ __('backend/default.qty') }}</th>

										@php
										$totalPrice = 0;
										$totalQty = 0;
										@endphp
										@foreach($sales as $sale)
											<tr>
												<td>{{ $loop->index + 1 }}</td>
												<td>
													{{ $sale->title }} <br>
													@php $totalQty += $sale->quantity @endphp
													@php $totalPrice += $sale->price * $sale->quantity @endphp
												</td>
												<td>{{ (int)$sale->quantity }}</td>
											</tr>
										@endforeach
								</table>
							</div>
				<!-- ===================== kitchen Table End ==================== -->
				<!-- ===================== Due Memo bill ================== -->
							<div id="second_table" class="bill_memo" style="display: none;">
								<table class="table table-bordered">
										<th width="40">{{ __('backend/default.sl') }}</th>
										<th>{{ __('backend/product.product') }}</th>
										<th class="total_width">{{ __('backend/default.total') }}</th>

										@php
										$totalPrice = 0;
										$totalQty = 0;
										@endphp
										@foreach($sales as $sale)
											<tr>
												<td>{{ $loop->index + 1 }}</td>
												<td>
													{{ $sale->title }} <br>
													({{ (int)$sale->quantity.' x '.(int)$sale->price }})
													@php $totalQty += $sale->quantity @endphp
													@php $totalPrice += $sale->price * $sale->quantity @endphp
												</td>
												<td>{{ $sale->price * $sale->quantity.' ৳' }}</td>
											</tr>
										@endforeach
										<tr>
											<th colspan="2" class="text-right"><strong>{{ __('backend/default.total') }}</strong></th>
											<th>
												{{ $sale->after_discount.' ৳' }} 
												<small>
													<s>{{ ($totalPrice == $sale->after_discount ? "" : $totalPrice.' ৳') }}</s>
												</small>
											</th>
										</tr>
								</table>
							</div>
				<!-- =====================  Due Memo bill End ================== -->
				<!-- =====================  Paid Memo bill ===================== -->

							<div id="third_table" class="" style="display: none;">
								<table class="table table-bordered">
										<th width="40">{{ __('backend/default.sl') }}</th>
										<th>{{ __('backend/product.product') }}</th>
										<th class="total_width">{{ __('backend/default.total') }} @if($sale->total_due != 0) <a href="{{ route('admin.sale.due.collect', $sale->sale_id) }}" class="btn btn-primary pull-right none">Continue To Due Collect</a> @endif</th>
										@php
										$totalPrice = 0;
										$totalQty = 0;
										@endphp
										@foreach($sales as $sale)
											<tr>
												<td>{{ $loop->index + 1 }}</td>
												<td>
													{{ $sale->title }} <br>
													({{ (int)$sale->quantity.' x '.(int)$sale->price }})
													@php $totalQty += $sale->quantity @endphp
													@php $totalPrice += $sale->price * $sale->quantity @endphp
												</td>
												<td>{{ (int)($sale->price * $sale->quantity).' ৳' }}</td>
											</tr>
										@endforeach
										<tr>
											<th colspan="2" class="text-right"><strong>{{ __('backend/default.total') }}</strong></th>
											<th>{{ (int)$totalPrice.' ৳' }}</th>
										</tr>
										<tr>
											<th colspan="2" class="text-right"><strong>{{ __('backend/default.discount') }}</strong></th>
											<th>{{ sprintf('%0.2f', $sale->discount_2).' %' }}</th>
										</tr>
										<tr>
											<th colspan="2" class="text-right"><strong>{{ __('backend/default.discount') }}</strong></th>
											<th>{{ sprintf('%0.2f', $sale->discount).' ৳' }}</th>
										</tr>
										<tr>
											<th colspan="2" class="text-right"><strong>{{ __('backend/default.vat') }}</strong></th>
											<th>{{ sprintf('%0.2f', $sale->vat).' %' }}</th>
										</tr>
										<tr>
											<th colspan="2" class="text-right"><strong>{{ __('backend/default.payable') }}</strong></th>
											<th>{{ sprintf('%0.2f', $sale->after_discount).' ৳' }}</th>
										</tr>
										<tr>
											<th colspan="2" class="text-right">{{ __('backend/default.paid') }}</th>
											<th>{{ sprintf('%0.2f', $sales[0]->given_money).' ৳' }}</th>
										</tr>
										<tr>
											<th colspan="2" class="text-right">{{ __('backend/default.return') }}</th>
											<th>
												@php
													$return = $sales[0]->given_money - $sale->after_discount;
												@endphp
												{{ sprintf('%0.2f', $return > 0 ? $return : "0").' ৳' }}
											</th>
										</tr>
										<tr>
											<th colspan="2" class="text-right">{{ __('backend/default.due') }}</th>
											<th>{{ $sale->total_due.' ৳' }}</th>
										</tr>
								</table>
							</div>
					
				<!-- =====================  Paid Memo bill End ================= -->



						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
	<script>
		window.onload=()=>{
			if(window.location.hash == "#paid"){
				first_table.style.display = "none"
				second_table.style.display = "none"
				third_table.style.display = "block"
				third.checked = true;
			}else{
				first.onclick=()=>{
					first_table.style.display = "block"
					second_table.style.display = "none"
					third_table.style.display = "none"
				}  
				second.onclick=()=>{
					first_table.style.display = "none"
					second_table.style.display = "block"
					third_table.style.display = "none"
				} 
				third.onclick=()=>{
					first_table.style.display = "none"
					second_table.style.display = "none"
					third_table.style.display = "block"
				}  
			}
		}
	</script>
@endsection

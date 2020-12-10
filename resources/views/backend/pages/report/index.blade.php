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
					<div class="col-md-6"><h2><i class="{{ 'fa fa-table' }}"></i> {{ __('backend/report.report_list') }}</h2></div>
					{{-- <div class="col-md-6"><a href="{{ route('admin.report.add') }}" class="float-right btn btn-primary"><i class="fa fa-plus"></i> {{ __('backend/default.add_new') }}</a></div> --}}
					<div class="clearfix"></div>
				</div>
			</div>

			<div class="card-body">
				<div>
					<div class="btn-group" role="group" aria-label="Basic example">
					  <button type="button" onclick="TabMenu('sales')" class="btn btn-primary">Sales</button>
					  <button type="button" onclick="TabMenu('cost')" class="btn btn-primary">Cost</button>
					  <button type="button" onclick="TabMenu('purchase')" class="btn btn-primary">Purchase</button>
					</div>
					<hr>
				</div>
				<div class="table-responsive pt-1">
							 		{{-- Table-1 --}}
					<div id="TABLE_1" class="">
						<table class="table table-bordered table-hover display">
							<thead>
								<tr style="background: #009688; color:#fff;">
									<th class="text-center" colspan="8">{{ __('backend/default.sales') }}</th>
								</tr>
								<th width="5%">{{ __('backend/default.sl') }}</th>
								<th width="15%">{{ __('backend/default.saler') }}</th>
								<th width="15%">{{ __('backend/default.sale_date') }}</th>
								<th width="5%">{{ __('backend/default.voucher') }}</th>
								<th width="5%">{{ __('backend/default.quantity') }}</th>
								<th width="10%">{{ __('backend/default.total') }}</th>
								<th width="10%">{{ __('backend/default.discount') }}</th>
								<th width="15%">{{ __('backend/sale.grand_total') }}</th>


							</thead>
							<tbody>
								@php
									$voucher = \App\Helpers\CalculationHelper::class;
								@endphp
								@foreach ($sales as $row)
								<tr class="{{ $row->status == 0 ? 'deactive_':'' }}">
									<td>{{ $loop->index+1 }}</td>
									<td>{{ $row->saler_name }}</td>
									<td>{{ $row->created_at }}</td>
									<td>{{ $voucher::generateVoucher($row->id) }}</td>
									<td>{{ $row->total_product }}</td>
									<td>{{ $row->total_price }}</td>
									<td>{{ $row->discount }}</td>
									<td>{{ $row->total_price_after_discount }}</td>

								</tr>
								@endforeach
								

							</tbody>
						</table>
					</div>
					

							 		{{-- Table-2 --}}
					<div id="TABLE_2" class="d-none">
						<table class="table table-bordered table-hover display">
							<thead>
								<tr style="background: #009688; color:#fff;">
									<th class="text-center" colspan="8">{{ __('backend/default.cost') }}</th>
								</tr>
								<th>{{ __('backend/default.sl') }}</th>
								<th>{{ __('backend/default.date') }}</th>
								<th>{{ __('backend/cost.cost_type') }}</th>
								<th>{{ __('backend/cost.cost_field') }}</th>
								<th>{{ __('backend/default.description') }}</th>
								<th>{{ __('backend/cost.cost') }}</th>
								<th>{{ __('backend/cost.cost_by') }}</th>
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
								<tr>
									<td colspan="5" class="text-right"><strong>{{ __('backend/default.total') }} </strong></td>
									<td > <strong>{{ $totalPrice }} TK</strong></td>
									<td class="none"></td>
								</tr>
							</tbody>
						</table>
					</div>

							 		{{-- Table-3 --}}
					<div id="TABLE_3" class="d-none">
						<table class="table table-bordered table-hover display">
							<thead>
								<tr style="background: #009688; color:#fff;">
									<th class="text-center" colspan="8">{{ __('backend/default.purchase') }}</th>
								</tr>
								<th width="7%">{{ __('backend/default.sl') }}</th>
								<th>{{ __('backend/default.date') }}</th>
								<th>{{ __('backend/default.purchase') }} {{ __('backend/default.field') }}</th>
								<th>{{ __('backend/default.price') }}</th>
								<th>{{ __('backend/default.quantity') }}</th>
								<th>{{ __('backend/default.voucher') }}</th>
							</thead>
							<tbody>

							    
								@foreach ($PurchaseHistory as $row)
								<tr class="{{ $row->status == 0 ? 'deactive_':'' }}">

									<td>{{ $loop->index+1 }}</td>
									<td>{{ $row->purchase_date }}</td>
									<td>{{ $row->purchase_item->title }}</td>
									<td>{{ $row->price }}&nbsp;TK</td>
									<td>{{ $row->quantity }}</td>
									<td class="voucher cursor-help">{{ $row->voucher }}</td>

								</tr>
								@endforeach
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection

<!-- Write Scripts <script fileType="text/javascript">In Here</script> -->
@section('scripts')
	<script>
		$(document).ready(function(){
			$('table.display').each(function(){
				var total_row = $(this).find('tr').length;
				if(total_row > 15){
					$(this).DataTable();
				}
			});
		});
			function TabMenu(data){
				switch(data){
					case 'sales':
						if($('#TABLE_1').hasClass('d-none')){
							$('#TABLE_1').removeClass('d-none');
							$('#TABLE_2,#TABLE_3').addClass('d-none');
						}
				    break;
				  	case 'cost':
				  		if($('#TABLE_2').hasClass('d-none')){
							$('#TABLE_2').removeClass('d-none');
							$('#TABLE_1,#TABLE_3').addClass('d-none');
						}
				    break;
				    case 'purchase':
				    	if($('#TABLE_3').hasClass('d-none')){
							$('#TABLE_3').removeClass('d-none');
							$('#TABLE_1,#TABLE_2').addClass('d-none');;
						}
				    break;
				  	default:
				}
			}
	</script>
@endsection
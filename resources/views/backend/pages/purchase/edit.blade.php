<!-- Full Structure -->
@extends('backend.layouts.master')

@section('fav_title', __('backend/purchase_item.edit_purchase_item') )

<!-- Write Styles <style>In Here</style> -->
@section('styles')
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
		<li class="breadcrumb-item"><a href="{{ route('admin.purchase_item.index') }}">{{ __('backend/purchase_item.purchase_item') }}</a></li>
		<li class="breadcrumb-item active">{{ __('backend/default.edit') }}</li>
	</ul>
</div>

<!-- Edit Form Part -->
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h2><i class="{{ 'fa fa-pencil-square' }}"></i> {{ __('backend/purchase_item.edit_purchase') }}</h2></div>
					<div class="col-md-6"><a href="{{ route('admin.purchase.index') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="card-body">
				@include('backend.partials.error_message')
				<form class="form-horizontal" action="{{ route('admin.purchase.update',$purchase_history->id) }}" method="post" enctype="multipart/form-data">
					@csrf


	                <div class="form-row">
	                    <div class="col-md-6">
	                        <label for="purchase_item_id" class="label">Purchase Item</label>
	                        <div>
	                        	<select name="purchase_item_id" id="purchase_item_id" class="form-control" required="">
	                        		<option selected="" disabled="">--Select Item--</option>
	                        		@foreach($rows as $row)
	                        			<option value="{{ $row->id }}" {{ $row->id == $purchase_history->purchase_item_id ? 'selected':'' }} data-regular_price_{{ $row->id }}="{{ $row->regular_price }}">{{ $row->title }}</option>
	                        		@endforeach
	                        	</select>
	                        </div>
	                    </div>
	                    <div class="col-md-6 mb-2">
	                        <label for="price" class="label">Purchase Price</label>
	                        <div>
	                            <input value="{{ $purchase_history->price }}" type="number" step="any" class="form-control mb-2" name="price" id="price" required>
	                        </div>
	                    </div>
	                </div>
	                <div class="form-row">
	                    <div class="col-md-6">
	                        <label for="purchase_date" class="label">Purchase Date</label>
	                        <div>
	                            <input value="{{ $purchase_history->purchase_date }}" autocomplete="off" type="text" class="form-control mb-2" name="purchase_date" id="purchase_date" required>
	                        </div>
	                    </div>
	                    <div class="col-md-6 mb-2">
	                        <label for="quantity" class="label">Quantity</label>
	                        <div>
	                            <input value="{{ $purchase_history->quantity }}" type="number" step="any" class="form-control mb-2" name="quantity" id="quantity" required>
	                        </div>
	                    </div>
	                    {{-- <div class="col-md-1 mb-2">
	                        <label for="unit" class="label">Unit</label>
	                        <div>
	                            <input value="{{ $purchase_history->unit }}" type="text" class="form-control mb-2" name="unit" id="unit" required>
	                        </div>
	                    </div> --}}
	                </div>


					<button type="submit" class="btn btn-primary float-right">{{ __('backend/default.update') }}</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

<!-- Write Scripts <script fileType="text/javascript">In Here</script> -->
@section('scripts')
	<script type="text/javascript">

		$("#purchase_date").val("{{ date('Y-m-d') }}")
		$(document).ready(function() {
			$("#purchase_item_id").on('change', function(event) {
				$('#price').val($('option:selected', this).data('regular_price_'+$(this).val()));
				event.preventDefault();
			});

			$("#purchase_item_id").select2();
			$("#purchase_date").datepicker({
			    format: 'yyyy-mm-dd',
			    todayHighlight:'TRUE',
			    autoclose: true,
			});
		});
	</script>
@endsection
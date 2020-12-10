<!-- Full Structure -->
@extends('backend.layouts.master')

@section('fav_title', __('backend/purchase_item.add_purchase') )

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
		<li class="breadcrumb-item active">{{ __('backend/default.add_new') }}</li>
	</ul>
</div>

<!-- Add Form Part -->
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h2><i class="{{ 'fa fa-plus-square' }}"></i> {{ __('backend/purchase_item.add_purchase') }}</h2></div>
					<div class="col-md-6"><a href="{{ route('admin.purchase.index') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/purchase_item.history') }}</a></div>
					<div class="clearfix"></div>

				</div>
			</div>
			<div class="card-body">
				@include('backend.partials.error_message')
				<form class="form-horizontal" action="{{ route('admin.purchase.store') }}" method="post" enctype="multipart/form-data">
					@csrf

	                <div class="form-row alert-info br-2 p-2 pt-3 mb-3">
	                    <div class="col-md-6">
	                        {{-- <label for="purchase_date" class="label">Purchase Date</label> --}}
	                        <div>
	                            <input autocomplete="off" type="text" class="form-control mb-2 purchase_date" name="purchase_date" id="purchase_date" required>
	                        </div>
	                    </div>
	                    {{-- <div class="col-md-6 btn btn-success" id="add_prepand_button" style="height: 37px;">Add Another</div> --}}

	                    <div class="col-md-6">
	                    	<a class="btn alert-warning w-100" id="add_prepand_button">Add Another</a>
	                    </div>

	                </div>
	                <div id="prepand_in">
		                <div class="form-row alert-warning br-2 p-2 pt-3 prepand_me" id="prepand_me">
		                    <div class="col-md-4 item_container">
		                        <label for="purchase_item_id" class="label">Purchase Item</label>
		                        <div>
		                        	<select name="purchase_item_id[]" id="purchase_item_id" class="form-control purchase_item_id" required="">
		                        		<option selected="" disabled="">--Select Item--</option>
		                        		@foreach($rows as $row)
		                        			<option value="{{ $row->id }}" data-regular_price_{{ $row->id }}="{{ $row->regular_price }}">{{ $row->title }}</option>
		                        		@endforeach
		                        	</select>
		                        </div>
		                    </div>
		                    <div class="col-md-3 mb-2 price_container">
		                        <label for="price" class="label">Purchase Price</label>
		                        <div>
		                        	<input type="number" step="any" class="form-control mb-2 price" name="price[]" id="price" required>
		                        </div>
		                    </div>
		                    <div class="col-md-3 mb-2 quantity_container">
		                        <label for="quantity" class="label">Quantity</label>
		                        <div>
		                            <input type="number" step="any" class="form-control mb-2 quantity" name="quantity[]" id="quantity" required>
		                        </div>
		                    </div>
		                    <div class="col-md-2 mb-2 quantity_container">
		                        <label for="quantity" class="label">Purchase Price &times; Quantity</label>
		                        <div>
		                    		<input type="text" class="form-control mb-2 price_quantities" id="price_quantities">
		                        </div>
		                    </div>
		                </div>
					</div>
		            {{-- <input type="hidden" class="form-control mb-2 grand_price_quantities" id="grand_price_quantities"> --}}
					<div class="text-right pt-2 grand_container h3 w-100">
						{{ __('backend/default.total') }}: 
						<span class="grand_price_quantities" id="grand_price_quantities">0.00</span>
					</div>
					<button type="submit" class="btn btn-primary float-right">{{ __('backend/default.submit') }}</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

<!-- Write Scripts <script fileType="text/javascript">In Here</script> -->
@section('scripts')
	<script type="text/javascript">
		
		var $prepend_html = $('#prepand_in').html();

		$(".purchase_date").val("{{ date('Y-m-d') }}");
		$(document).ready(function() {


			getValueOfItem();

			$('.price').on('change', function(event) {
				var grand_price_quantities = 0;

				var quantity = $(this).val();
				var price = $(this).closest('.prepand_me').find('.quantity').val();
				var this_total_cost = quantity*price;

				$(this).closest('.prepand_me').find('.price_quantities').val(this_total_cost);

				$('input.price_quantities').each(function(){
					if ($(this).val().length > 0) {
				    	grand_price_quantities += parseFloat($(this).val());
					}
				});
				$('.grand_price_quantities').text(parseFloat(grand_price_quantities).toFixed(2));
			});
			$('.quantity').on('change', function(event) {

				var grand_price_quantities = 0;

				var price = $(this).val();
				var quantity = $(this).closest('.prepand_me').find('.price').val();
				var this_total_cost = quantity*price;

				$(this).closest('.prepand_me').find('.price_quantities').val(this_total_cost);

				$('input.price_quantities').each(function(){
					if ($(this).val().length > 0) {
				    	grand_price_quantities += parseFloat($(this).val());
					}
				});
				$('.grand_price_quantities').text(parseFloat(grand_price_quantities).toFixed(2));
			});

			$("#add_prepand_button").on('click', function(event) {

				$("#prepand_in").prepend($prepend_html);
				$(".purchase_item_id").select2();
				getValueOfItem();

				$('.price').on('change', function(event) {

					var grand_price_quantities = 0;

					var quantity = $(this).val();
					var price = $(this).closest('.prepand_me').find('.quantity').val();
					var this_total_cost = quantity*price;

					$(this).closest('.prepand_me').find('.price_quantities').val(this_total_cost);

					$('input.price_quantities').each(function(){
						if ($(this).val().length > 0) {
					    	grand_price_quantities += parseFloat($(this).val());
						}
					});
					$('.grand_price_quantities').text(parseFloat(grand_price_quantities).toFixed(2));
				});
				$('.quantity').on('change', function(event) {

					var grand_price_quantities = 0;

					var price = $(this).val();
					var quantity = $(this).closest('.prepand_me').find('.price').val();
					var this_total_cost = quantity*price;

					$(this).closest('.prepand_me').find('.price_quantities').val(this_total_cost);

					$('input.price_quantities').each(function(){
						if ($(this).val().length > 0) {
					    	grand_price_quantities += parseFloat($(this).val());
						}
					});
					$('.grand_price_quantities').text(parseFloat(grand_price_quantities).toFixed(2));
				});

			});


			$(".purchase_item_id").select2();
			$(".purchase_date").datepicker({
			    format: 'yyyy-mm-dd',
			    todayHighlight:'TRUE',
			    autoclose: true,
			});

		});

		function getValueOfItem() {
			$(".purchase_item_id").on('change', function(event) {
				$(this).closest('.item_container').next().find('.price').val($('option:selected', this).data('regular_price_'+$(this).val()));
			});
		}
	</script>
@endsection
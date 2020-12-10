@extends('backend.layouts.master')

@section('fav_title', 'Due Collect')

@section('content')
<div class="app-title">
  <div>
    <h1><i class="fa fa-pie-chart"></i> {{ __('backend/due.due_collect') }}</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg fa-fw"></i><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{-- route('') --}}">{{ __('backend/due.due_list') }}</a></li>
    <li class="breadcrumb-item active">{{ __('backend/due.due_collect') }}</li>
  </ul>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6"><h2><i class="fa fa-plus-square"></i> {{ __('backend/due.due') }}</h2></div>
          <div class="col-md-6"><a href="{{ route('admin.sale.index') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>
          <div class="clearfix"></div>
        </div>
      </div>

      <div class="card-body">
        @include('backend.partials.error_message')
        <form class="form-horizontal" id="myform" action="{{ route('admin.sale.due.collect.store', $sale->id) }}#paid" method="post" enctype="multipart/form-data">
          @csrf
            <div class="row">
                
                <div class="col-md-10">
                    <div class>
                        <div class="row">
                            <div class="col-md-2 text-right"><strong>{{ __('backend/default.date') }} : </strong></div>
                            <div class="col-md-4">{{ date('Y-m-d') }}</div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2 text-right"><strong>{{ __('backend/sale.sale_date') }}</strong> : </strong></div>
                            <div class="col-md-4">{{ $sale->pickdate }}</div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2 text-right"><strong>{{ __('backend/due.customer') }}</strong> : </strong></div>
                            <div class="col-md-4">{{ $sale->customer_name ? $sale->customer_name : 'N/A' }}</div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2 text-right"><strong>{{ __('backend/default.mobile') }}</strong> : </strong></div>
                            <div class="col-md-4">{{ $sale->customer_name ? $sale->customer_mobile : 'N/A' }}</div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-2 text-right"><strong>{{ __('backend/default.price') }} :</strong></div>
                        <div class="col-md-3"><input type="text" value="{{ $sale->total_price }}" id="total_price" class="form-control" type="text" name="total_price"  readonly="true" required="true"></div>
                        
                        <div class="col-md-2 text-right"><strong>{{ __('backend/due.old_due') }} :</strong></div>
                        <div class="col-md-3"><input type="text" value="{{ $sale->total_due }}" id="total_due" class="form-control" type="text" name="total_due"  readonly="true"></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2 text-right"><strong>Given Money :</strong></div>
                        <div class="col-md-3"><input type="text" value="{{ $sale->given_money }}" id="given_money" class="form-control" type="text" name="given_money"  readonly="true" required="true"></div>
                        
                        
                        <div class="col-md-2 text-right"><strong>{{ __('backend/due.current_due') }} :</strong></div>
                        <div class="col-md-3"><input type="text" value="{{ $sale->total_due }}" id="current_due" class="form-control" type="text" name="current_due"  readonly="true" required="true"></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2 text-right"><strong>Discount (%):</strong></div>
                        <div class="col-md-3"><input type="number" min="0" value="{{ $sale->discount_2 }}" id="discount" class="form-control" type="text" name="discount_2" required="true"></div>
                        
                        <div class="col-md-2 text-right"><strong>Discount (TK):</strong></div>
                        <div class="col-md-3"><input type="number" min="0" value="{{ $sale->discount }}" id="discountTk" class="form-control" type="text" name="discount" required="true"></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2 text-right"><strong>{{ __('backend/default.payment') }} :</strong></div>
                        <div class="col-md-3"><input type="number" min="0" id="payment" class="form-control" type="text" name="payment" required="true" autocomplete="off" autofocus="true"></div>
                        
                        <div class="col-md-2 text-right"><strong>{{ __('backend/default.return') }} :</strong></div>
                        <div class="col-md-3"><input type="number" min="0" id="return_money" class="form-control" type="text" name="return_money" required="true" autocomplete="off" readonly="true"></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-7 text-right"></div>
                        <div class="col-md-3"><button type="submit" class="btn btn-primary float-right">{{ __('backend/default.collect') }}</button></div>
                    </div>
                    
                    <div style="display: none;">
                        <input type="hidden" name="date" value="{{ date('Y-m-d') }}">
                        <input type="hidden" name="price_after_discount" id="price_after_discount">
                    </div>
                    <br>
                    <br>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
	<script>
		window.onload=()=>{
            
            
            const main_due         = "{{ $sale->total_due }}";
            const main_total_price = "{{ $sale->total_price }}";
            const main_given_money = given_money.value;
            const main_discount    = discount.value;
            const main_discountTk  = discountTk.value;
            
            
            
            payment.oninput=function()
            {
                if(this.value == '' && this.value < 0){
                    this.value = 0;
                }
                payments();
            }
            
            discount.oninput=function()
            {
                if(this.value == '' && this.value < 0){
                    this.value = 0;
                }
                payments();
            }
            discountTk.oninput=function()
            {
                if(this.value == '' && this.value < 0){
                    this.value = 0;
                }
                payments();
                
            }
            function payments(){
                let discount_taka = (main_total_price/100) * discount.value;
                price_after_discount.value = main_total_price - (((main_total_price/100) * discount.value) - discountTk.value);
                let total_due = (((main_total_price - discountTk.value) - discount_taka) - payment.value) - main_given_money ;
                current_due.value = Math.floor(total_due);
                if(current_due.value < 0){
                    return_money.value = Math.abs(total_due) || 0;
                    current_due.value = 0;
                }
            }
		}
	</script>
@endsection

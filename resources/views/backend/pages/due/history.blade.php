@extends('backend.layouts.master')

@section('fav_title', 'Due History')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6"><h2><i class="fa fa-plus-square"></i> {{ __('backend/due.history') }}</h2></div>
          <div class="col-md-6"><a href="{{ route('admin.sale.due') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>
          <div class="clearfix"></div>
        </div>
      </div>

      <div class="card-body">
        @include('backend.partials.error_message')


        <div class="toggle-table-column alert-info br-2 p-2 mb-2 none">
          <strong>{{ __('backend/default.table_toggle_message') }} </strong>
          <br>
          <a href="#" class="toggle-vis" data-column="0"><b>{{ __('backend/default.sl') }}</b></a> | 
          <a href="#" class="toggle-vis" data-column="1"><b>{{ __('backend/default.date') }}</b></a> |  
          <a href="#" class="toggle-vis" data-column="2"><b>{{ __('backend/due.payment') }}</b></a> | 
          <a href="#" class="toggle-vis" data-column="3"><b>{{ __('backend/sale.sale') }}</b></a> 
        </div>
        
        <div class="table-responsive">
	        <table id="datatable" class="table table-bordered table-hover display">
	            <thead>
	              <th>{{ __('backend/default.sl') }}</th>
	              <th>{{ __('backend/default.date') }}</th>
	              <th>{{ __('backend/default.payment') }}</th>
	              <th>{{ __('backend/default.customer') }}</th>
	              <th>{{ __('backend/default.mobile') }}</th>
	            </thead>

	            <tbody>
	            	@foreach($histories as $key=>$history)
	            	<tr>
	            		<td>{{ $key+1 }}</td>
	            		<td>{{ $history->date }}</td>
	            		<td>{{ $history->payment }}</td>
	            		<td>{{ $history->sale ? ($history->sale->customer_name ? $history->sale->customer_name : "N/A") : "N/A" }}</td>
	            		<td>{{ $history->sale ? ($history->sale->customer_mobile ? $history->sale->customer_mobile : "N/A") : "N/A" }}</td>
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

@section('scripts')

@endsection

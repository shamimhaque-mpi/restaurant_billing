@extends('backend.layouts.master')

@section('fav_title', __('backend/default.dashboard') )

@section('content')

<div class="app-title">
    <div>
        <h1><i class="fa fa-dashboard"></i> {{ __('backend/default.dashboard') }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i> {{ __('backend/default.dashboard') }}</li>
    </ul>
</div>


<div class="row">
    {{-- <div class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon"><i class="icon fa fa fa-archive fa-3x"></i>
            <div class="info">
                <h4>{{ __('backend/product.product') }}</h4>
                <p><b>{{ $product }}</b></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small info coloured-icon"><i class="icon fa fa-pie-chart fa-3x"></i>
            <div class="info">
                <h4>{{ __('backend/category.category') }}</h4>
                <p><b>{{ $category }}</b></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small warning coloured-icon"><i class="icon fa fa-money fa-3x"></i>
            <div class="info">
                <h4>{{ __('backend/default.total_amount') }}</h4>
                <p><b>{{ $totalAmount }} ৳</b></p>
            </div>
        </div>
    </div> --}}
    <div class="col-md-6 col-lg-3">
        <a href="{{ route('admin.sale.index') }}" style="text-decoration: none;">
            <div class="widget-small primary coloured-icon"><i class="icon fa fa-money fa-3x"></i>
                <div class="info">
                    <h4>{{ __('backend/sale.sale') }}</h4>
                    <p><b>{{ sprintf('%0.2f', $today_sale) }} TK</b></p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-lg-3">
        <a href="{{ route('admin.balance_sheet.index') }}" style="text-decoration: none;">
            <div class="widget-small info coloured-icon"><i class="icon fa fa-money fa-3x"></i>
                <div class="info">
                    <h4>{{ __('backend/balance_sheet.due') }}</h4>
                    <p><b>{{ sprintf('%0.2f', $today_due) }} TK</b></p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-lg-3">
        <a href="{{ route('admin.purchase_item.index') }}" style="text-decoration: none;">
            <div class="widget-small danger coloured-icon"><i class="icon fa fa-money fa-3x"></i>
                <div class="info">
                    <h4>{{ __('backend/default.purchase') }}</h4>
                    <p><b>{{ sprintf('%0.2f', $today_purchase_cost) }} TK</b></p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-lg-3">
        <a href="{{ route('admin.cost.index') }}" style="text-decoration: none;">
            <div class="widget-small warning coloured-icon"><i class="icon fa fa-money fa-3x"></i>
                <div class="info">
                    <h4>{{ __('backend/cost.cost') }}</h4>
                    <p><b>{{ sprintf('%0.2f', $today_other_cost) }} TK</b></p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-lg-3">
        <a href="{{ route('admin.balance_sheet.index') }}" style="text-decoration: none;">
            <div class="widget-small info coloured-icon"><i class="icon fa fa-money fa-3x"></i>
                <div class="info">
                    <h4>{{ __('backend/balance_sheet.balance') }}</h4>
                    <p><b>{{ sprintf('%0.2f', $today_sale - ($today_purchase_cost + $today_other_cost)) }} TK</b></p>
                </div>
            </div>
        </a>
    </div>
    {{-- <div class="col-md-6 col-lg-3">
    <div class="widget-small warning coloured-icon"><i class="icon fa fa-money fa-3x"></i>
    <div class="info">
    <h4>{{ __('backend/default.this_week_sale') }}</h4>
    <p><b> {{ $this_week_sale }} ৳</b></p>
    </div>
    </div>
    </div>
    <div class="col-md-6 col-lg-3">
    <div class="widget-small primary coloured-icon"><i class="icon fa fa-money fa-3x"></i>
    <div class="info">
    <h4>{{ __('backend/default.this_month_sale') }}</h4>
    <p><b>{{ $this_month_sale }} ৳</b></p>
    </div>
    </div>
    </div>
    <div class="col-md-6 col-lg-3">
    <div class="widget-small info coloured-icon"><i class="icon fa fa-money fa-3x"></i>
    <div class="info">
    <h4>{{ __('backend/default.this_year_sale') }}</h4>
    <p><b>{{ $getThisYear }} ৳</b></p>
    </div>
    </div>
    </div> --}}
</div>

@endsection

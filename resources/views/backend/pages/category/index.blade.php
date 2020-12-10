@extends('backend.layouts.master')

@section('fav_title', 'Category List')

@section('styles')
<style>
  .action{
    min-width: 70px;
  }
  .table th, .table td{
    vertical-align: middle;
  }
</style>
@endsection

@section('content')
<div class="app-title">
  <div>
    <h1><i class="fa fa-pie-chart"></i> {{ __('backend/category.category_management') }}</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg fa-fw"></i><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('backend/category.category') }}</li>
  </ul>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6"><h2><i class="fa fa-table"></i> {{ __('backend/category.category') }}</h2></div>
          <div class="col-md-5"><a href="{{ route('admin.category.create') }}" class="float-right btn btn-primary"><i class="fa fa-plus"></i> {{ __('backend/default.add_new') }}</a></div>
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
        <div class="hide col-sm-12 text-center"><h2><i class="{{ 'fa fa-table' }}"></i> All Sale</h2></div>


        @php
        $permissions = \App\Models\Menu::orderBy('id', 'desc')->where('url', substr(url()->current(), 1+strlen(url('/'))))
        ->orWhere('url', substr(url()->current(), strlen(url('/'))))->first();
        if(Auth::guard('admin')->user()->admin_role == 3){
          $bodyMenu = \App\Models\Role::where('admin_id', Auth::guard()->id())->first();
        }
        else{
          $bodyMenu = \App\Models\Role::where('role', Auth::guard()->user()->admin_role)->first();
        }
        @endphp
        <div class="toggle-table-column alert-info br-2 p-2 mb-2 none">
          <strong>{{ __('backend/default.table_toggle_message') }} </strong>
          <br>
          <a href="#" class="toggle-vis" data-column="0"><b>{{ __('backend/default.sl') }}</b></a> | 
          <a href="#" class="toggle-vis" data-column="1"><b>{{ __('backend/form_field.name') }}</b></a> |  
          <a href="#" class="toggle-vis" data-column="2"><b>{{ __('backend/form_field.photo') }}</b></a> | 
          <a href="#" class="toggle-vis" data-column="3"><b>{{ __('backend/form_field.status') }}</b></a> | 
          <a href="#" class="toggle-vis" data-column="4"><b>{{ __('backend/default.action') }}</b></a>
        </div>
        
        <div class="table-responsive">
          <table id="datatable" class="table table-bordered table-hover display">
            <thead>
              <th>{{ __('backend/default.sl') }}</th>
              <th>{{ __('backend/form_field.name') }}</th>
              <th>{{ __('backend/form_field.photo') }}</th>
              <th>{{ __('backend/form_field.status') }}</th>
              <th class="action">{{ __('backend/default.action') }}</th>
            </thead>

            <tbody>
              @foreach ($categories as $key => $row)
              
              <tr class="{{ $row->status == 0 ? 'deactive_':'' }}">
                <td> {{ $key+1 }} </td>
                <td> {{ $row->title }} </td>
                <td> <img src="{{ asset($row->image) }}" class="img-thumbnail" style="height: 62px;"> </td>
                <td> 
                  {{  $row->status=='1' ? 'Active':'Deactive' }}
                </td>
                <td class="action">
                  <div class="btn-group">
                    @foreach($permissions->submenus as $key => $permission)
                    @if(\App\Models\Menu::checkBodyMenu($permission->id, $bodyMenu->in_body))
                    @if($key == 0)
                    <a href="{{ route($permission->route, $row->id) }}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                    @else
                    <button class="btn text-white {{ $row->status == 0? ' btn-secondary disabled':' btn-danger' }}" onClick="deleteMethod({{ json_encode($row->id) }})" {{ $row->status == 0? 'disabled':'' }}><i class="fa fa-minus-circle"></i></button>
                    @endif
                    @endif
                    @endforeach
                  </div>
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

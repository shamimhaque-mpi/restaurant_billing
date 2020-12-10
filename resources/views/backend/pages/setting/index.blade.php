@extends('backend.layouts.master')

@section('fav_title', __('backend/default.site_settings') )

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
    <h1><i class="fa fa-sliders"></i> {{ __('backend/default.setting_management') }}</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg fa-fw"></i><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('backend/default.setting') }}</li>
    <li class="breadcrumb-item active">{{ __('backend/default.edit') }}</li>
  </ul>
</div>
<div class="row mb-3">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6"><h2><i class="fa fa-pencil-square"></i>&nbsp;{{ __('backend/default.edit') }}</h2></div>
          <div class="col-md-6"></div>
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="card-body">


        <div class="row">
          <div class="col-md-3">
            <div class="position-relative p-1 pt-4 mt-4 setting_container col-sm-12">
              <span class="px-2 py-1 position-absolute setting_title l-1">Logo</span>
              <span class="px-2 py-1 position-absolute setting_title r-1">Favicon</span>
              <div class="row">
                <div class="col-sm-6">
                  <img src="{{ asset('public/images/settings/'.$setting->logo) }}" alt="" style="height: 60px" class="img img-thumbnail"><br>
                </div>
                <div class="col-sm-6">
                  <img src="{{ asset('public/images/settings/'.$setting->favicon) }}" alt="" style="height: 60px; width: 60px;" class="img img-thumbnail float-right">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-9">
            @include('backend.partials.error_message')
            <form action="{{ route('admin.setting.store') }}" method="post" enctype="multipart/form-data">
              @csrf

              <div class="position-relative p-4 mt-4 setting_container">
                <span class="px-2 py-1 position-absolute setting_title">Contact</span>
                <div class="form-row">
                  <div class="col-md-6 mt-3" id="address_div">
                    <label for="address" id="address_label">Address <span class="text-danger">*</span></label>
                    <textarea type="text" name="address" id="address" class="form-control" required>{!! $setting->address !!}</textarea> 
                  </div>
                  <div class="col-md-6" id="find_hide">
                    <div class="col-sm-12 mt-3">
                      <label for="title">Site Title <span class="text-danger">*</span></label>
                      <input type="text" name="title" id="title" value="{{ $setting->title }}" class="form-control" required>
                    </div>
                    <div class="col-sm-12 mt-3">
                      <label for="email">Email <span class="text-danger">*</span></label>
                      <input type="email" name="email" id="email" value="{{ $setting->email }}" class="form-control" required>
                    </div>
                    <div class="col-sm-12 mt-3">
                      <label for="mobile">Mobile <span class="text-danger">*</span></label>
                      <input type="text" name="mobile" id="mobile" value="{{ $setting->mobile }}" class="form-control" required>
                    </div>
                  </div>
                </div>
              </div>

              <div class="position-relative p-4 mt-4 setting_container">
                <span class="px-2 py-1 position-absolute setting_title">Social</span>
                <div class="form-row">
                  <div class="col-md-6">
                    <label for="facebook">Facebook <span class="text-danger">*</span></label>
                    <input type="text" name="facebook" id="facebook" value="{{ $setting->facebook }}" class="form-control" required>
                  </div>

                  <div class="col-md-6">
                    <label for="twitter">Twitter <span class="text-danger">*</span></label>
                    <input type="twitter" name="twitter" id="twitter" value="{{ $setting->twitter }}" class="form-control" required>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-6 mt-3">
                    <label for="youtube">Youtube <span class="text-danger">*</span></label>
                    <input type="text" name="youtube" id="youtube" value="{{ $setting->youtube }}" class="form-control" required>
                  </div>

                  <div class="col-md-6 mt-3">
                    <label for="linkedin">Linkedin <span class="text-danger">*</span></label>
                    <input type="linkedin" name="linkedin" id="linkedin" value="{{ $setting->linkedin }}" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="position-relative p-4 mt-4 setting_container">
                <span class="px-2 py-1 position-absolute setting_title">Other</span>
                <div class="form-row">
                  <div class="col-md-6">
                    <label for="logo">Logo </label>
                    <input type="file" name="logo" id="logo" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label for="favicon">Favicon </label>
                    <input type="file" name="favicon" id="favicon" class="form-control">
                  </div>
                </div>
              </div>

              <button class="btn btn-success float-right mt-2" type="submit">{{ __('backend/default.submit') }}</button>
            </form>
          </div>
        </div>


      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
  $(document).ready(function() {
    $('#address').css({
      'min-height': $('#find_hide').height() - $('label').outerHeight() - 24
    });
  });
</script>
@endsection

@extends('backend.layouts.master')

@section('fav_title', 'Edit Subcategory')

@section('content')
<div class="app-title">
  <div>
    <h1><i class="fa fa-yelp"></i> {{ __('backend/subcategory.subcategory_management') }}</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg fa-fw"></i><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.subcategory.index') }}">{{ __('backend/subcategory.subcategory') }}</a></li>
    <li class="breadcrumb-item active">{{ __('backend/default.edit') }}</li>
  </ul>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6"><h2><i class="fa fa-pencil-square"></i> {{ __('backend/subcategory.edit_subcategory') }}</h2></div>
          <div class="col-md-6"><a href="{{ route('admin.subcategory.index') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>
          <div class="clearfix"></div>
        </div>
      </div>

      <div class="card-body">
        @include('backend.partials.error_message')

        <form class="form-horizontal" id="myform" action="{{ route('admin.subcategory.update', $subcategory->slug) }}" method="post" enctype="multipart/form-data">
          @csrf

          <input type="hidden" name="id" value="{{ $subcategory->id }}">

          <div class="form-group row">
            <label class="control-label col-md-3 text-right"> 
            <strong>{{ __('backend/form_field.name') }}</strong> 
            </label>
            <div class="col-md-5">
              <input id="title" class="form-control" type="text" value="{{  $subcategory->title }}" name="title"  >
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3 text-right"> 
            <strong>{{ __('backend/category.category') }}</strong> 
            </label>
            <div class="col-md-5">
              <select id="category_id" class="form-control" type="text" name="category_id"  >
                <option value="" selected disabled><strong>{{ __('backend/form_field.select_category') }}</strong> </option>
                @foreach($category as $key => $row)
                <option value="{{ $row->id }}" {{ $row->id == $subcategory->category_id ? 'selected' : '' }}>{{ $row->title }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3 text-right"><strong>{{ __('backend/form_field.status') }}</strong>  </label>
            <div class="col-md-5">
              <select id="status" class="form-control"  name="status">
                <option value="1" {{ $subcategory->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $subcategory->status == 0 ? 'selected' : '' }}>Deactive</option>
              </select>
            </div>
          </div>
          
          <div class="form-row">
            <div class="col-md-8 mt-3">
              <button type="submit" name="save" class="btn btn-success float-right">{{ __('backend/default.submit') }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')

@endsection

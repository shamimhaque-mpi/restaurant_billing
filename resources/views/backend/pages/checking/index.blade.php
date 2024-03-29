<!-- Full Structure -->
@extends('backend.layouts.master')

@section('fav_title', __('backend/checking.checking') )

<!-- Write Styles <style>In Here</style> -->
@section('styles')
@endsection

<!-- This Section Will Shown <body>In Here</body> -->
@section('content')
<!-- Top Management Part -->
<div class="app-title">
  <div>
    <h1><i class="{{ 'fa fa-eye' }}"></i> {{ __('backend/color.color') }} {{ __('backend/default.management') }}</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('backend/color.color') }}</li>
  </ul>
</div>

<!-- Table Part -->
<div class="row">
  <div class="col-md-12">
    <div class="card">

      <div class="card-header">
        <div class="row">
          @if ('model' == 'model')
          <div class="col-md-6"><h2><i class="{{ 'fa fa-table' }}"></i> {{ __('backend/checking.checking_list') }}</h2></div>
          <div class="col-md-6"><button data-toggle="modal" data-target="#add_new" class="float-right btn btn-primary"><i class="fa fa-plus"></i> {{ __('backend/default.add_new') }}</button></div>

          @elseif ('model' == 'index')
          <div class="col-md-6"><h2><i class="{{ 'fa fa-table' }}"></i> {{ __('backend/checking.checking_list') }}</h2></div>
          <div class="col-md-6"><a href="{{ route('admin.checking.add') }}" class="float-right btn btn-primary"><i class="fa fa-plus"></i> {{ __('backend/default.add_new') }}</a></div>

          @elseif ('model' == 'add')
          <div class="col-md-6"><h2><i class="{{ 'fa fa-table' }}"></i> {{ __('backend/checking.add_checking') }}</h2></div>
          <div class="col-md-6"><a href="{{ route('admin.checking.index') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>

          @elseif ('model' == 'edit')
          <div class="col-md-6"><h2><i class="{{ 'fa fa-table' }}"></i> {{ __('backend/checking.edit_checking') }}</h2></div>
          <div class="col-md-6"><a href="{{ route('admin.checking.index') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>
          @endif
          <div class="clearfix"></div>
        </div>
      </div>

      <div class="card-body">
        @include('backend.partials.error_message')
        @php
        $permissions = \App\Models\Menu::orderBy('id', 'desc')->where('url', substr(url()->current(), 1+strlen(url('/'))))
        ->orWhere('url', substr(url()->current(), strlen(url('/'))))->first();
        $bodyMenu = \App\Models\Role::where('role', Auth::guard('admin')->user()->admin_role)->first();
        @endphp
        <div class="toggle-table-column alert-info br-2 p-2 mb-2">
          <strong>{{ __('backend/default.table_toggle_message') }} </strong>
          <br>

          <a href="#" class="toggle-vis" data-column="0"><b>{{ __('backend/default.sl') }}</b></a> |

          <!--<a></a>
          .
          .
          . 
          <a></a>-->

          <a href="#" class="toggle-vis" data-column="3"><b>{{ __('backend/default.status') }}</small></b></a> |
          <a href="#" class="toggle-vis" data-column="4"><b>{{ __('backend/default.action') }}</small></b></a>

        </div>

        <div class="table-responsive pt-1">
          <table id="datatable" class="table table-bordered table-hover display">

            <thead>
              <th>{{ __('backend/default.sl') }}</th>

              <!--<th></th>
              .
              .
              .
              <th></th>-->

              <th>{{ __('backend/default.status') }}</th>
              <th class="action">{{ __('backend/default.action') }}</th>
            </thead>

            <tbody>

              {{-- @foreach($rows as $row)
              <tr class="{{ $row->status == 0 ? 'deactive_':'' }}">
                <td>{{ $loop->index + 1 }}</td>


                <!--<td></td>
                .
                .
                .
                <td></td>-->

                <td>{{ $row->status == 1 ? 'Active' : 'Deactive' }}</td>
                <td class="action">
                  <div class="btn-group">
                    @foreach($permissions->submenus as $key => $permission)
                    @if(\App\Models\Menu::checkBodyMenu($permission->admin_role, $bodyMenu->in_body))
                    @if($key == 0)
                    <button data-toggle="modal" data-target="#edit_page{{ $row->id }}" class="btn btn-info text-white"><i class="fa fa-edit"></i></button>
                    @else
                    <button class="btn text-white {{ $row->status == 0? ' btn-secondary disabled':' btn-danger' }}" onClick="deleteMethod({{ $row->id }})" role="button" {{ $row->status == 0? 'disabled':'' }}><i class="fa fa-minus-circle"></i></button>
                    @endif
                    @endif
                    @endforeach
                  </div>
                  <!-- Edit Modal -->
                  <div class="modal fade" id="edit_page{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-pencil-square"></i> {{ __('backend/color.color') }} {{ __('backend/default.update') }}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form action="{{ route('admin.checking.update', $row->id) }}" method="POST">
                            @csrf

                            <div class="form-group row">
                              <!--Inputs / TextAreas / Selects ... -->
                            </div>
                            
                            <div class="button-group pull-right">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('backend/default.close') }}</button>
                              <button type="submit" class="btn btn-primary">{{ __('backend/default.update') }}</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              @endforeach --}}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Add Modal -->
<div class="modal fade" id="add_new" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-square"></i> {{ __('backend/color.add_color') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.checking.store') }}" method="POST">
          @csrf
          <div class="form-group">
            <label class="col-form-label" for="title">{{ __('backend/default.title') }}<span class="text-danger">*</span></label>
            <div>
              <input type="text" class="form-control" name="title" id="title" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-form-label" for="status">{{ __('backend/default.status') }} <span class="text-danger">*</span></label>
            <div>
              <select class="form-control" name="status" id="status" required>
                <option value="1">Active</option>
                <option value="0">Deactive</option>
              </select>
            </div>
          </div>
          <div class="button-group pull-right">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('backend/default.close') }}</button>
            <button type="submit" class="btn btn-primary">{{ __('backend/default.submit') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

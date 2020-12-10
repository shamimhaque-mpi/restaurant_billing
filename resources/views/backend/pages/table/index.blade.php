@extends('backend.layouts.master')

@section('fav_title', 'Add Category')

@section('content')
<div class="app-title">
  <div>
    <h1><i class="fa fa-pie-chart"></i> {{ __('backend/default.table_management') }}</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg fa-fw"></i><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.sale.table') }}">{{ __('backend/table.table') }}</a></li>
    <li class="breadcrumb-item active">{{ __('backend/default.add_new') }}</li>
  </ul>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6"><h2><i class="fa fa-plus-square"></i> {{ __('backend/default.table_list') }}</h2></div>
          {{-- <div class="col-md-6"><a href="{{ route('admin.category.index') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div> --}}
          <div class="clearfix"></div>
        </div>
      </div>

      	<div class="card-body">
	        @include('backend.partials.error_message')
			
			<!-- ============================ Form_start ============================== -->
	        <form class="form-horizontal" id="myform" action="{{ route('admin.sale.table.add') }}" method="post" enctype="multipart/form-data">
	          @csrf
	          	<div class="col-md-6">
	          		<div class="row">
	          			<div class="col-md-9 pr-0">
			          		<div class="form-group">
			          			<input type="text" name="name" class="form-control" required="true" placeholder="{{ __('backend/form_field.new_table_name') }}">
			          		</div>
			          	</div>
	          			<div class="col-md-2 pl-0">
	          				<button type="submit" class="btn btn-primary">{{ __('backend/default.add') }}</button>
	          			</div>
	          		</div>
	          	</div>
	        </form>
        <!-- ============================ End Form_start ============================== -->

        <!-- ============================ Categories List ============================= -->
			<hr>
			@php
		        $permissions = \App\Models\Menu::orderBy('id', 'desc')
		        ->where('url', substr(url()->current(), 1+strlen(url('/'))))
		        ->orWhere('url', substr(url()->current(), strlen(url('/'))))->first();

		        // dd(substr(url()->current(), 1+strlen(url('/'))));

		        if(Auth::guard('admin')->user()->admin_role == 3){
		          $bodyMenu = \App\Models\Role::where('admin_id', Auth::guard()->id())->first();
		        }
		        else{
		          $bodyMenu = \App\Models\Role::where('role', Auth::guard()->user()->admin_role)->first();
		        }
        	@endphp
			<div class="table-responsive">
		        <table id="datatable" class="table table-bordered table-hover display">
		            <thead>
		              	<th width="5%">{{ __('backend/default.sl') }}</th>
		              	<th>{{ __('backend/form_field.name') }}</th>
             			<th width="7%" class="action">{{ __('backend/default.action') }}</th>
		            </thead>

		            <tbody>
		              @foreach ($tables as $key => $table)
			              	<tr class="{{ $table->status == 0 ? 'deactive_':'' }}">
				                <td> {{ $key+1 }}</td>
				                <td> {{ $table->name }} </td>
				                <td>
				                	<div class="btn-group">
					                    @foreach($permissions->submenus as $key => $permission)
						                    @if(\App\Models\Menu::checkBodyMenu($permission->id, $bodyMenu->in_body))
							                    @if($key == 0)
							                    	<button type="button" class="btn text-white {{ $table->status == 0? ' btn-secondary disabled':' btn-danger' }}" onClick="deleteMethod({{ json_encode($table->id) }})" {{ $table->status == 0? 'disabled':'' }}><i class="fa fa-trash"></i></button>
							                   	@endif
							                    @if($key == 1)
							                    	<a data-toggle="modal" data-target="#exampleModal{{ $table->id }}" class="btn text-white {{ $table->status == 0? ' btn-secondary disabled':' btn-primary' }}" {{ $table->status == 0? 'disabled':'' }}><i class="fa fa-pencil-square-o"></i></a>
							                   	@endif
						                    @endif
					                    @endforeach
					                </div> 

									{{-- bootstrap modal --}}
									<div class="modal fade" id="exampleModal{{ $table->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									  <div class="modal-dialog" role="document">
									    <div class="modal-content">
									      <div class="modal-header">
									        <h5 class="modal-title" id="exampleModalLabel">Edit Table Name</h5>
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									          <span aria-hidden="true">&times;</span>
									        </button>
									      </div>
									      	<form action="{{ route('admin.sale.table.edit', $table->id) }}" method="post">
									      		@csrf
										      	<div class="modal-body">
										        	<input type="text" name="table" class="form-control" value="{{ $table->name }}">
										      	</div>
										      	<div class="modal-footer">
										        	<button type="submit" class="btn btn-primary">Save</button>
										      	</div>

									      	</form>
									    </div>
									  </div>
									</div>
									{{-- end bootstrap modal --}}

				                </td>
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

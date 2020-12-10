@extends('backend.layouts.master')

@section('fav_title', __('backend/default.profile') )

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
		<h1><i class="fa fa-user-secret"></i> {{ __('backend/default.admin_management') }}</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg fa-fw"></i><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
		<li class="breadcrumb-item">{{ __('backend/all.my_admins') }}</li>
	</ul>
</div>
<div class="row mb-3">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h2><i class="fa fa-table"></i>&nbsp;{{ __('backend/all.my_admins') }}</h2></div>
					@if(Auth::guard('admin')->user()->admin_role == 1)
					<div class="col-md-6"><a href="{{ route('admin.myadmin.add') }}" class="float-right btn btn-primary"><i class="fa fa-plus"></i> {{ __('backend/all.add_admin') }}</a></div>
					<div class="clearfix"></div>
					@endif
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive pt-1">
					<table id="datatable" class="table table-bordered table-hover display">
						<thead>
							<th>{{ __('backend/default.sl') }}</th>
							<th>{{ __('backend/form_field.name') }}</th>
							<th>{{ __('backend/form_field.email') }}</th>
							<th>{{ __('backend/form_field.username') }}</th>
							<th>{{ __('backend/form_field.role') }}</th>
							<th>{{ __('backend/form_field.photo') }}</th>
							<th>{{ __('backend/form_field.status') }}</th>
							<th class="action">{{ __('backend/default.action') }}</th>
						</thead>

						<tbody>
							@foreach ($myAdmines as $myAdmin)
							<tr class="{{ $myAdmin->status == 0 ? 'deactive_':'' }}">
								<td>{{ $loop->index+1 }}</td>
								<td>{{ $myAdmin->name }}</td>
								<td>{{ $myAdmin->email }}</td>
								<td>{{ $myAdmin->username }}</td>
								<td>
									@if($myAdmin->admin_role == 1)
									{{ 'Super Admin' }}
									@elseif($myAdmin->admin_role == 2)
									{{ 'Admin' }}
									@else
									{{ 'User' }}	
									@endif
								</td>
								<td>
									<img src="{{ asset($myAdmin->photo) }}" alt="" width="50" height="50">
								</td>
								<td>{{ $myAdmin->status == 1 ? 'Active' : 'Deactive' }}</td>
								<td class="action">
									@if(Auth::guard('admin')->user()->admin_role == 1)
									<div class="btn-group">
										<a class="btn btn-info" href="{{ route('admin.myadmin.edit', $myAdmin->id) }}"><i class="fa fa-edit"></i></a>
										<button class="btn text-white {{ $myAdmin->status == 0? ' btn-secondary disabled':' btn-danger' }}" onClick="deleteMethod({{ $myAdmin->id }})" {{ $myAdmin->status == 0? 'disabled':'' }}><i class="fa fa-minus-circle"></i></button>
									</div>
									@endif
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

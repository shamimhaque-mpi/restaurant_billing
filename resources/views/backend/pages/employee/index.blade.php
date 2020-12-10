<!-- Full Structure -->
@extends('backend.layouts.master')

@section('fav_title', __('backend/employee.employee') )

<!-- Write Styles <style>In Here</style> -->
@section('styles')
@endsection

<!-- This Section Will Shown <body>In Here</body> -->
@section('content')
<!-- Top Management Part -->
<div class="app-title">
	<div>
		<h1><i class="{{ 'fa fa-male' }}"></i> {{ __('backend/employee.employee_management') }}</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
		<li class="breadcrumb-item active">{{ __('backend/employee.employee') }}</li>
	</ul>
</div>

<!-- Table Part -->
<div class="row">
	<div class="col-md-12">
		<div class="card">

			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h2><i class="{{ 'fa fa-table' }}"></i> {{ __('backend/employee.employee_list') }}</h2></div>
					{{-- <div class="col-md-6"><a href="{{ route('admin.employee.add') }}" class="float-right btn btn-primary"><i class="fa fa-plus"></i> {{ __('backend/default.add_new') }}</a></div> --}}
					<div class="col-md-6">
						<a href="#" onclick="print_method()" class="btn btn-primary alert-primary text-center float-right">
							<i class="fa fa-print"></i> {{ __('backend/default.print') }}
						</a>
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
							<tr>
							    <th class="text-center p-0 border-0">All Employees</th>
							</tr>
						</table>
					</div>
				</div>

				<!-- Permission for Admin Access -->
				@php
				$permissions = \App\Models\Menu::orderBy('id', 'desc')->where('url', substr(url()->current(), 1+strlen(url('/'))))
				->orWhere('url', substr(url()->current(), strlen(url('/'))))->first();
				if(Auth::guard('admin')->user()->admin_role == 3){
					$bodyMenu = \App\Models\Role::where('admin_id', Auth::guard('admin')->id())->first();
				}
				else{
					$bodyMenu = \App\Models\Role::where('role', Auth::guard()->user()->admin_role)->first();
				}

				@endphp

				<div class="toggle-table-column alert-info br-2 p-2 mb-2 none">
					<strong>{{ __('backend/default.table_toggle_message') }} </strong>

					<a href="#" class="toggle-vis" data-column="0"><b>{{ __('backend/default.sl') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="1"><b>{{ __('backend/form_field.name') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="2"><b>{{ __('backend/form_field.photo') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="3"><b>{{ __('backend/form_field.mobile') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="4"><b>{{ __('backend/form_field.pre_address') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="5"><b>{{ __('backend/form_field.per_address') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="6"><b>{{ __('backend/form_field.nid_no') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="7"><b>{{ __('backend/form_field.designation') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="8"><b>{{ __('backend/form_field.salary') }}</b></a> |
					<a href="#" class="toggle-vis" data-column="9"><b>{{ __('backend/default.action') }}</small></b></a>

				</div>
				<div class="table-responsive pt-1">
					<table id="datatable" class="table table-bordered table-hover display">

						<thead>
							<th>{{ __('backend/default.sl') }}</th>
							<th>{{ __('backend/form_field.name') }}</th>
							<th>{{ __('backend/form_field.photo') }}</th>
							<th>{{ __('backend/form_field.mobile') }}</th>
							<th>{{ __('backend/form_field.pre_address') }}</th>
							<th>{{ __('backend/form_field.per_address') }}</th>
							<th>{{ __('backend/form_field.nid_no') }}</th>
							<th>{{ __('backend/form_field.designation') }}</th>
							<th>{{ __('backend/form_field.salary') }}</th>
							<th class="action">{{ __('backend/default.action') }}</th>
						</thead>
						<tbody>

							<!--Remove from Comment {{--...--}} -->

						  
							@foreach ($rows as $row)
							<tr class="{{ $row->status == 0 ? 'deactive_':'' }}">
								<td>{{ $loop->index+1 }}</td>

								<td>{{ $row->name }}</td>
								<td><img src="{{ asset($row->photo) }}" height="30" alt=""></td>
								<td>{{ $row->mobile }}</td>
								<td>{{ $row->pre_address }}</td>
								<td>{{ $row->per_address }}</td>
								<td>{{ $row->nid_no }}</td>
								<td>{{ $row->designation }}</td>
								<td>{{ $row->salary }}</td>
								<td class="action">
									<div class="btn-group">

										<!-- Checking Admin Access -->
										@foreach($permissions->submenus as $key => $permission)
										@if(\App\Models\Menu::checkBodyMenu($permission->id, $bodyMenu->in_body))

                                        @if($key == 0)
                                        <a href="{{route($permission->route, $row->id)}}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                        @elseif($key == 1)
                                        <a href="{{route($permission->route, $row->id)}}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                        @else
                                        <button class="btn {{ $row->status == 0 ? 'btn-secondary disabled':' btn-danger' }}" onClick="deleteMethod({{ json_encode($row->id) }})" role="button" {{ $row->status == 0? 'disabled':'' }}><i class="fa fa-trash"></i></button>
                                        @endif

										@endif
										@endforeach
									</div>
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

<!-- Write Scripts <script fileType="text/javascript">In Here</script> -->
@section('scripts')
@endsection
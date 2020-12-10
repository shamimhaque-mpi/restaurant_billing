<!-- Full Structure -->
@extends('backend.layouts.master')

@section('fav_title', __('backend/#fileDirectory#.#fileDirectory#') )

<!-- Write Styles <style>In Here</style> -->
@section('styles')
@endsection

<!-- This Section Will Shown <body>In Here</body> -->
@section('content')
<!-- Top Management Part -->
<div class="app-title">
	<div>
		<h1><i class="{{ '#fafaOfSideMenu#' }}"></i> {{ __('#langFolderDirectory#/#fileDirectory#.#tagManagement#') }}</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><a href="{{ route('#dashboardRoute#') }}">{{ __('#langFolderDirectory#/default.dashboard') }}</a></li>
		@if ('#fileType#' == 'index')
		<li class="breadcrumb-item active">{{ __('#langFolderDirectory#/#fileDirectory#.#fileDirectory#') }}</li>
		@elseif ('#fileType#' == 'add')
		<li class="breadcrumb-item"><a href="{{ route('#indexFileRoute#') }}">{{ __('#langFolderDirectory#/#fileDirectory#.#fileDirectory#') }}</a></li>
		<li class="breadcrumb-item active">{{ __('#langFolderDirectory#/default.add_new') }}</li>
		@elseif ('#fileType#' == 'edit')
		<li class="breadcrumb-item"><a href="{{ route('#indexFileRoute#') }}">{{ __('#langFolderDirectory#/#fileDirectory#.#fileDirectory#') }}</a></li>
		<li class="breadcrumb-item active">{{ __('#langFolderDirectory#/default.edit') }}</li>
		@endif
	</ul>
</div>

<!-- Table Part -->
<div class="row">
	<div class="col-md-12">
		<div class="card">

			<div class="card-header">
				<div class="row">
					@if ('#fileType#' == 'index')
					<div class="col-md-6"><h2><i class="{{ '#fafaCardHeader#' }}"></i> {{ __('#langFolderDirectory#/#fileDirectory#.#fileDirectory#_list') }}</h2></div>
					<div class="col-md-6"><a href="{{ route('#addNewButtonRoute#') }}" class="float-right btn btn-primary"><i class="fa fa-plus"></i> {{ __('#langFolderDirectory#/default.add_new') }}</a></div>

					@elseif ('#fileType#' == 'add')
					<div class="col-md-6"><h2><i class="{{ '#fafaCardHeader#' }}"></i> {{ __('#langFolderDirectory#/#fileDirectory#.add_#fileDirectory#') }}</h2></div>
					<div class="col-md-6"><a href="{{ route('#indexFileRoute#') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('#langFolderDirectory#/default.list') }}</a></div>

					@elseif ('#fileType#' == 'edit')
					<div class="col-md-6"><h2><i class="{{ '#fafaCardHeader#' }}"></i> {{ __('#langFolderDirectory#/#fileDirectory#.edit_#fileDirectory#') }}</h2></div>
					<div class="col-md-6"><a href="{{ route('#indexFileRoute#') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('#langFolderDirectory#/default.list') }}</a></div>
					@endif
					<div class="clearfix"></div>
				</div>
			</div>

			<div class="card-body">

				<!-- Permission for Admin Access -->
				@php
				$permissions = \App\Models\Menu::where('url', substr(url()->current(), 1+strlen(url('/'))))
				->orWhere('url', substr(url()->current(), strlen(url('/'))))->first();
				$bodyMenu = \App\Models\Role::where('role', Auth::guard()->user()->admin_role)->first();
				@endphp

				<div class="toggle-table-column">
					<strong>{{ __('#langFolderDirectory#/default.table_toggle_message') }} </strong>

					<a href="#" class="toggle-vis" data-column="0"><b>{{ __('#langFolderDirectory#/default.sl') }}</b></a> |

					<!--<a></a>
					.
					.
					.	
					<a></a>-->

					<a href="#" class="toggle-vis" data-column="1"><b>{{ __('#langFolderDirectory#/default.status') }}</small></b></a> |
					<a href="#" class="toggle-vis" data-column="2"><b>{{ __('#langFolderDirectory#/default.action') }}</small></b></a>

				</div>
				<div class="table-responsive pt-1">
					<table id="datatable" class="table table-bordered table-hover display">

						<thead>
							<th>{{ __('#langFolderDirectory#/default.sl') }}</th>

							<!--<th></th>
							.
							.
							.
							<th></th>-->

							<th>{{ __('#langFolderDirectory#/default.status') }}</th>
							<th class="action">{{ __('#langFolderDirectory#/default.action') }}</th>
						</thead>
						<tbody>

							<!--Remove from Comment {{--...--}} -->

						    {{--
							@foreach ($rows as $row)
							<tr class="{{ $row->status == 0 ? 'deactive_':'' }}">
								<td>{{ $loop->index+1 }}</td>

								<!--<td></td>
								.
								.
								.
								<td></td>-->

								<td>{{ $row->status == 1 ? 'Actived' : 'Deactived' }}</td>
								<td class="action">
									<div class="btn-group">

										<!-- Checking Admin Access -->
										@foreach($permissions->submenus as $key => $permission)
										@if(\App\Models\Menu::checkBodyMenu($permission->admin_role, $bodyMenu->in_body))


										<!--
										  --
										  -- Without View 
										  --
										  -->
										@if($key == 0)
										<a class="btn btn-info" href="{{ route($permission->route, $row->id) }}"><i class="fa fa-edit"></i></a>
										@else
										<button class="btn text-white {{ $row->status == 0? ' btn-secondary disabled':' btn-danger' }}" onClick="deleteMethod({{ $row->id }})" {{ $row->status == 0? 'disabled':'' }}><i class="fa fa-minus-circle"></i></button>
										@endif
										<!-- Without View -->



										<!--
										  --
										  -- With View
										  --
										  -->
                                        @if($key == 0)
                                        <a href="{{route($permission->route, $row->slug)}}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                        @elseif($key == 1)
                                        <a href="{{route($permission->route, $row->slug)}}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                        @else
                                        <button class="btn {{ $row->status == 0 ? 'btn-secondary disabled':' btn-danger' }}" onClick="deleteMethod({{ json_encode($row->slug) }})" role="button" {{ $row->status == 0? 'disabled':'' }}><i class="fa fa-minus-circle"></i></button>
                                        @endif
										<!-- With View -->

										@endif
										@endforeach
									</div>
								</td>
							</tr>
							@endforeach
							--}}
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
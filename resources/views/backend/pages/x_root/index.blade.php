@extends('backend.layouts.master')

@section('fav_title', __('backend/default.root') )

@section('styles')
<style type="text/css">
{{--
	only for "/root/index.blade.php"
	--}}
	input::-webkit-input-placeholder {
		color: #eee !important;
	}
	input:focus::-webkit-input-placeholder {
		color: #aaa !important;
	}
	/* Firefox > 19 */
	input::-moz-placeholder {
		color: #eee !important;
	}
	input:focus::-moz-placeholder {
		color: #aaa !important;
	}
	/* Internet Explorer 10 */
	input:-ms-input-placeholder {
		color: #eee !important;
	}
	input:focus:-ms-input-placeholder {
		color: #aaa !important;
	}
	kbd {
		padding: 0 2px;
	}
</style>
@endsection

@section('content')
<div class="app-title">
	<div>
		<h1 class="shortKey_container"><i class="fa fa-free-code-camp"></i> {{ __('backend/default.root_management') }} <code>v1.19.04-21<small></small></code></h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-code-fork fa-lg"></i> {{ __('backend/default.developer') }}</li>
		<li class="breadcrumb-item">{{ __('backend/default.root') }}</li>
		<li class="breadcrumb-item active">{{ __('backend/default.add') }}</li>
	</ul>
</div>
{{-- ==Create Tag== --}}
<div class="row mb-3">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h2><i class="fa fa-plus-square"></i> {{ __('backend/default.add_file') }}</h2></div>
					<div class="col-md-6">
						<div class="btn-group float-right">
							<a class="btn btn-info " href="{{ route('admin.menu.create') }}"><i class="fa fa-laptop"></i><i class="fa fa-arrow-right text-slash text-sm-center"></i><i class="fa fa-plus"></i></a>
							<a class="btn btn-primary" href="{{ route('admin.language.bn_en') }}"><i class="fa fa-globe"></i></a>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="card-body">

				<form onkeypress="return event.keyCode != 13;" action="{{ route('admin.root.create') }}" method="post">
					@csrf
					<div class="container-fluid">
						<div class="row">

							@if (Session::has('root_done_'))
							@php
							$created = Session::get('root_done_');
							$type_ = Session::get('type_');
							$controller__ = Session::get('controller__');
							$tab = '&nbsp;&nbsp;&nbsp;&nbsp;';
							@endphp
							<div class="col-lg-12">
								<div id="created_" class="alert alert-success alert-dismissible fade show position-relative" role="alert">
									<h3 class="text-center"><code><span class="text-secondary">Copy from below and paste it in "</span>web.php<span class="text-secondary">"</span></code></h3>
									@if($controller__ == 'no' )
									<span style="display: block;" class="text-center alert alert-info">run: <kbd>php artisan make:controller Backend\{{ ucfirst($created) }}Controller</kbd></span>
									@endif
									<hr>
									<i class="fa fa-clipboard r-4 position-absolute text-secondary clipboard_" style="display: none; font-size: x-large;" aria-hidden="true"></i>
									<p class="right-side-header cursor-copy alert alert-secondary" title="Click to Copy Text" id="text_" onclick="copyElementText(this.id)">
										<tt>
											@include('backend.pages.root.route')
										</tt>
									</p>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							</div>
							@if($controller__ == 'yes' )
							<div class="col-lg-12 text_2-container">
								<div id="created_" class="alert alert-success alert-dismissible fade show position-relative" role="alert">
									<h3 class="text-center"><code><span class="text-secondary">Copy from below and paste it in "</span><code>Backend\{{ ucfirst($created) }}Controller.php</code><span class="text-secondary">"</span></code></h3>

									<span style="display: block;" class="text-center alert alert-info">Check in <code>Controllers\Backend</code> for <kbd class="bg-success">{{ ucfirst($created) }}Controller.php</kbd><br>run: <kbd>php artisan make:model Models\{{ ucfirst(str_singular($created)) }}</kbd> <i class="text-info" style="font-size: smaller;"><br>[Note: Model Name Must be Singular]</i></span>
									<hr>
									<i class="fa fa-clipboard r-4 position-absolute text-secondary clipboard_2" style="display: none; font-size: x-large;" aria-hidden="true"></i>
									<p class="right-side-header cursor-copy alert alert-secondary" title="Click to Copy Text" id="text_2" onclick="copyElementText(this.id)">
										<tt>
											@include('backend.pages.root.controller')
										</tt>
									</p>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							</div>
							@endif
							@endif
							<div class="col-lg-8 form-group">

								<div class="row">

									<div class="col-lg-6 position-relative mt-4">
										<label class="col-form-label position-absolute root_form">File Folder Name</label>
										<input required class="form-control fileDirectory" type="text" name="fileDirectory" placeholder="views/backend/pages/[folderName]">
									</div>
									<div class="col-md-6 position-relative mt-4">
										<label class="col-form-label position-absolute root_form bg-done">File Type</label>
										<select required class="form-control fileType" name="fileType">
											<option value="oneClickAll">Index, Add & Edit</option>
											<option value="oneClickAllWithView">Index, Add, Edit & View</option>
											<option value="model">Model</option>
											<option value="index">Index</option>
											<option value="add">Add</option>
											<option value="edit">Edit</option>
											<option value="view">View</option>
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 position-relative mt-4">
										<label class="col-form-label position-absolute root_form bg-done">Make Controller</label>
										<select required class="form-control makeController" name="makeController">
											<option value="no">No</option>
											<option value="yes">Yes</option>
										</select>
									</div>

									<div class="col-md-6 position-relative mt-4">
										<label class="col-form-label position-absolute root_form bg-done">Make Migration</label>
										<select required class="form-control makeMigration" name="makeMigration" disabled="">
											<option value="no">No</option>
											<option value="yes">Yes</option>
										</select>
									</div>
								</div>
								<div class="row">

									<div class="col-md-6 position-relative mt-4">
										<label class="col-form-label position-absolute root_form">File Name</label>
										<input required class="form-control fileName" type="text" name="fileName" placeholder="[fileName].blade.php" disabled>
									</div>

									<div class="col-md-6 position-relative mt-4">
										<label class="col-form-label position-absolute root_form">Language Folder Name</label>
										<input required class="form-control" type="text" name="langFolderDirectory" placeholder="lang/(bn/en)/[folderName]" value="backend">
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 position-relative mt-4">
										<label class="col-form-label position-absolute root_form">Side Menu Icon</label>
										<input required class="form-control fafaOfSideMenu" type="text" name="fafaOfSideMenu" placeholder="[fa fa-#iconName#]">
									</div>
									<div class="col-md-6 position-relative mt-4">
										<label class="col-form-label position-absolute root_form">Card Header Icon</label>
										<input required class="form-control fafaCardHeader" type="text" name="fafaCardHeader" placeholder="[fa fa-#iconName#]" disabled>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 position-relative mt-4">
										<label class="col-form-label position-absolute root_form auto_done">Management Name</label>
										<input required class="form-control tagManagement" type="text" name="tagManagement" placeholder="[fileName Management]">
									</div>
									<div class="col-md-6 position-relative mt-4">
										<label class="col-form-label position-absolute root_form auto_done">Route of Dashboard</label>
										<input required class="form-control" type="text" name="dashboardRoute" placeholder="[dashboardRoute]" value="admin.home" readonly="">
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 position-relative mt-4">
										<label class="col-form-label position-absolute root_form auto_done">Route of Index File</label>
										<input required class="form-control indexFileRoute" type="text" name="indexFileRoute" placeholder="Route of [indexFile]">
									</div>
									<div class="col-md-6 position-relative mt-4">
										<label class="col-form-label position-absolute root_form auto_done">Route of Add New Button</label>
										<input required class="form-control addNewButtonRoute" type="text" name="addNewButtonRoute" placeholder="Route of [addNewButtonRoute] Button">
									</div>
								</div>
								<button id="save_file" type="submit" class="btn btn-success px-4 float-right ml-3 mt-2">Create</button>
							</div>
							<div class="col-lg-4 pt-4 pb-3">
								@include('backend.pages.root.descriptions')
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')

<script type="text/javascript">
	$(document).ready(function() {

		$('#detail_container').html($('.description_container').html());
		$('input, select').blur(function() {
			if ($(this).val() !== '') {
				$(this).siblings().addClass('bg-done');
			}
			$('#detail_container').html($('.description_container').html());
		});
		$('input, select').focus(function() {
			//$('.description_container').fadeOut();
			$('#detail_container').html($('.description_'+$(this).attr('name')).html());
			$(this).keyup(function(){

				if ($(this).attr('name') == 'fileDirectory') {
					$('.fileDirectoryText').text($(this).val().replace(/ /g, '_').replace(/-/g, '_'));
					$('.getFileName').text($(this).val().toLowerCase().replace(/ /g, '_').replace(/-/g, '_').replace(/\b[a-z]/g, function(letter) {
						return letter.toUpperCase();
					}));
					$('.getFileName_').text($(this).val().toLowerCase().replace(/ /g, '_').replace(/-/g, '_').plural());

				} else if ($(this).attr('name') == 'langFolderDirectory') {
					$('.langFolderDirectory').text($(this).val());
				} else if ($(this).attr('name') == 'tagManagement') {
					$('.tagManagement_').text($(this).val());
				}

			});
			if ($(this).attr('name') == 'tagManagement') {
				$('.fafa-fafaOfSideMenu').addClass($('.fafaOfSideMenu').val());
			} else if ($(this).attr('name') == 'fileDirectory') {
				$(this).on('change', function() {
					if ($(this).val().length > 0) {
						// ucwords()
						var str_ = $('.fileDirectory').val().toLowerCase();
						var str = str_+' management';
						str = str.replace(/-/g, ' ').replace(/_/g, ' ');
						str = str.replace(/\b[a-z]/g, function(letter) {
							return letter.toUpperCase();
						});

						$('.tagManagement').val(str);
						$('.indexFileRoute').val('admin.'+str_+'.index');
						$('.addNewButtonRoute').val('admin.'+str_+'.add');
						$('.fileDirectoryText').text(str_);
						$('.auto_done').addClass('bg-done');

					}
				});
			}
		});
		$('.fileType').on('change', function() {
			if ($('.fileType').find(":selected").val() == 'oneClickAll' || $('.fileType').find(":selected").val() == 'oneClickAllWithView') {
				$('.fileName').attr('disabled','disabled').val('');
				$('.fafaCardHeader').attr('disabled','disabled').val('');
			} else {
				$('.fileName').removeAttr('disabled');
				$('.fafaCardHeader').removeAttr('disabled');				
			}

			// Helping
			if ($('.fileType').find(":selected").val() == 'index' || $('.fileType').find(":selected").val() == 'model') {
				$('.fileName').val('index');
				$('.fafaCardHeader').val('fa fa-table');

			} else if ($('.fileType').find(":selected").val() == 'add') {
				$('.fileName').val($('.fileType').find(":selected").val());
				$('.fafaCardHeader').val('fa fa-plus-square');

			} else if ($('.fileType').find(":selected").val() == 'edit') {
				$('.fileName').val($('.fileType').find(":selected").val());
				$('.fafaCardHeader').val('fa fa-pencil-square');

			} else if ($('.fileType').find(":selected").val() == 'view') {
				$('.fileName').val($('.fileType').find(":selected").val());
				$('.fafaCardHeader').val('fa fa-eye');

			}
		});
		//Copy Text
		$('#text_').hover(function() {
			$('.clipboard_').fadeIn();
		}, function() {
			$('.clipboard_').fadeOut();
		});
		$('#text_').click(function() {
			$('.clipboard_').removeClass('fa-clipboard text-secondary').addClass('fa-check text-success');
			$(this).attr('title', 'Text Copied');
			// setTimeout(function() {
			// 	$('#created_').fadeOut();
			// }, 10000);
		});
		//Copy Text
		$('#text_2').hover(function() {
			$('.clipboard_2').fadeIn();
		}, function() {
			$('.clipboard_2').fadeOut();
		});
		$('#text_2').click(function() {
			$('.clipboard_2').removeClass('fa-clipboard text-secondary').addClass('fa-check text-success');
			$(this).attr('title', 'Text Copied');
			// setTimeout(function() {
			// 	$('#created_').fadeOut();
			// }, 10000);
		});
	});
	function copyElementText(id) {
		var text = document.getElementById(id).innerText;
		var elem = document.createElement("textarea");
		document.body.appendChild(elem);
		elem.value = text;
		elem.select();
		document.execCommand("copy");
		document.body.removeChild(elem);
	}
</script>
@endsection

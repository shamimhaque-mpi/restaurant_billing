<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  @php
    $site_setting = \App\Models\Setting::first();
  @endphp
  <title>{{ ucwords($site_setting->title) }} - @yield('fav_title')</title>
  
  {{-- <title>{{ __('backend/default.site_name') }} - @yield('fav_title')</title> --}}

  <link rel="icon" href="{!!  asset('public/images/settings/'.$site_setting->favicon)  !!}" type="image/gif" sizes="16x16"> 


  @include('backend.partials.styles')

  <style>
    .preloader {
     position: absolute;
     top: 0;
     left: 0;
     width: 100%;
     height: 100%;
     z-index: 9999;
     background-image: "{{ asset('public/5.gif')  }}";
     background-repeat: no-repeat; 
     background-color: #FFF;
     background-position: center;
   }
   [v-cloak] .v-cloak--block {
    display: block;
  }
  [v-cloak] .v-cloak--inline {
    display: inline;
  }
  [v-cloak] .v-cloak--inlineBlock {
    display: inline-block;
  }
  [v-cloak] .v-cloak--hidden {
    display: none;
  }
  [v-cloak] .v-cloak--invisible {
    visibility: hidden;
  }
  .v-cloak--block,
  .v-cloak--inline,
  .v-cloak--inlineBlock {
    display: none;
  }
  i.fa.fa-spinner.fa-pulse.fa-3x.fa-fw {
    margin-left: 46%;
    bottom: 50%;
    margin-top: 11%;
  }
  .toast-top-right {
    top: 50px !important;
    right: 31px !important;
  }
</style>

@section('styles')
@show

</head>
<body class="app sidebar-mini rtl">
<script type="text/javascript">
  @if(Route::is('admin.sale.add'))
    $('body').addClass('sidenav-toggled');
  @endif
</script>

  {{-- <div class="preloader"></div> --}}

  @include('backend.partials.nav')

  @include('backend.partials.sidebar')

  <div id="main-wrapper">

    @include('backend.partials.message')

    <main class="app-content" id="app">
      <div v-cloak>
        <div class="v-cloak--inline">
          <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
          <span class="sr-only">Loading...</span>
        </div>

        <div class="v-cloak--hidden"> 
          @section('content')
          @show  
        </div>
      </div>
    </main>

  </div>

  @include('backend.partials.scripts')

  @section('scripts')
  @show

  
</body>
</html>
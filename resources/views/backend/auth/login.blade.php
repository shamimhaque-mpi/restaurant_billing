<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="{{ asset('public/admins/css/main.css') }}">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  @php
  $site_setting = \App\Models\Setting::first();
  @endphp
  <title>{{ ucwords($site_setting->title) }} - {{ __('backend/default.sign_in') }}</title>
  <style>
    .login-content .login-box,
    .login-content .logo {
      min-width: 360px !important;
    }
    .monospace {
      font-family: monospace;
    }
    .logo {
      margin-bottom: 0!important;
      text-align: center;
    }
    .br-4 {
      border-radius: 4px;
    }
  </style>
</head>


<body>
  <section class="material-half-bg">
    <div class="cover"></div>
  </section>
  <section class="login-content">
    <div class="logo">
      <h1>{{ env('APP_NAME') }}</h1>
      @if ( Session::has('login_error') )
        <div class="alert alert-danger monospace text-left">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          {!! Session::get('login_error') !!}
        </div>
      @endif
    </div>
    <div class="login-box br-4">
      <form class="login-form" action="{!! route('admin.login.submit') !!}" method="post">
        @csrf
        <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>{{ __('backend/default.sign_in') }}</h3>

        @if (session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
        @endif
        <div class="form-group">
          <label class="control-label">{{ __('backend/default.username') }}</label>
          <input class="form-control" type="text" value="{{ (request()->token) ? \App\Helpers\LoginHelper::get_username(request()->token) : '' }}" placeholder="User Name" name="username" autofocus required>
        </div>
        <div class="form-group">
          <label class="control-label">{{ __('backend/default.password') }}</label>
          <input class="form-control" type="password" value="{{ (request()->token) ? \App\Helpers\LoginHelper::get_password(request()->token) : '' }}" placeholder="Password" name="password" required>
        </div>
        <div class="form-group">
          <div class="utility">
            <div class="animated-checkbox">
              <label>
                {{--<input type="checkbox"><span class="label-text">Stay Signed in</span>--}}
                <button class="btn btn-primary" type="submit"><i class="fa fa-sign-in fa-lg fa-fw"></i>{{ __('backend/default.sign_in') }}</button>
              </label>
            </div>
            <p class="semibold-text mb-2"><a href="#" data-toggle="flip">{{ __('backend/default.forgot_password') }} ?</a></p>
          </div>
        </div>
      </form>
      <form class="forget-form" action="{{ route('admin.password.email') }}" method="post">
        @csrf
        <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>{{ __('backend/default.forgot_password') }} ?</h3>
        <div class="form-group">
          <label class="control-label">{{ __('backend/default.email') }}</label>
          <input class="form-control" type="text" placeholder="Email" name="email" required>
        </div>
        <div class="form-group btn-container">
          <button class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>{{ __('backend/default.reset') }}</button>
        </div>
        <div class="form-group mt-3">
          <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> {{ __('backend/default.back_to_login') }}</a></p>
        </div>
      </form>
    </div>
  </section>

  <script src="{{ asset('public/admins/js/jquery-3.2.1.min.js') }}"></script>
  <script src="{{ asset('public/admins/js/popper.min.js') }}"></script>
  <script src="{{ asset('public/admins/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('public/admins/js/main.js') }}"></script>
  <script src="{{ asset('public/admins/js/plugins/pace.min.js') }}"></script>
  <script type="text/javascript">
    $('.login-content [data-toggle="flip"]').click(function() {
      $('.login-box').toggleClass('flipped');
      return false;
    });
    @if(request()->token)
      if (!$('.logo div.alert-danger').children('a').hasClass('close')) {
        $(".utility button").text("Logging in...");
        $(".utility button").click();
      } else {
        $(".utility button").text("{{ __('backend/default.sign_in') }}");
      }
    @endif
  </script>
</body>
</html>

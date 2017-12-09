@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.login') }}
@endsection

@section('content')
    <body class="hold-transition login-page off-canvas-sidebar">
    <div id="app" class="wrapper wrapper-full-page">
        <div class="full-page login-page" filter-color="carcoin-secondary-1">
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                                <div class="card card-login">
                                    <div class="card-header text-center">
                                        <div class="logo">
                                            <a href="{{ url('/home') }}">
                                                <img src="{{asset('Carcoin/img/zcoin-id-final_logo-rev.svg')}}">
                                            </a>
                                        </div>
                                    </div>
                                    <form action="{{ route('password.request') }}" method="post">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="token" value="{{ $token }}">
                                        <div class="card-content">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">account_circle</i>
                                                </span>
                                                <div class="form-group label-floating has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                                                    <label class="control-label">Email</label>
                                                    <input type="email" name="email" class="form-control"  value="{{ old('email') }}" placeholder="">
                                                    @if ($errors->has('name'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </span>
                                                    @endif
                                                    @if ($errors->has('email'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">lock_outline</i>
                                                </span>
                                                <div class="form-group label-floating has-feedback {{ $errors->has('password') ? 'has-error' : '' }}" >
                                                    <label class="control-label">Password</label>
                                                    <input type="password" name="password" class="form-control">
                                                    @if ($errors->has('password'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">lock_outline</i>
                                                </span>
                                                <div class="form-group label-floating has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}" >
                                                    <label class="control-label">Password</label>
                                                    <input type="password" name="password_confirmation" class="form-control">
                                                    @if ($errors->has('password_confirmation'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @if (Config::get('app.enable_captcha'))
                                                <div class="form-group">
                                                    {!! app('captcha')->display()!!}
                                                    @if ($errors->has('g-recaptcha-response'))
                                                        <span class="help-block">
                                                            {{ $errors->first('g-recaptcha-response') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                        <div class="footer text-center">
                                            <button type="submit" class="btn btn-fill btn-primary btn-round" btn-sign-in>Reset Password</button>
                                            <div class="clearfix"></div>
                                            <div class="my-3"><a href="{{ url('/login') }}">Log in</a></div>
                                        </div>
                                    </form>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @include('adminlte::layouts.partials.footer')

        </div>
    </div>
    @include('adminlte::layouts.partials.scripts_footer')
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>


    </body>

@endsection

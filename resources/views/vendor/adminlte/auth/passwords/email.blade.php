@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    {{trans('adminlte_lang::message.passwordreset')}}
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
                                    <form action="{{ route('password.email') }}" method="post">
                                    <h4 class="text-center">{{trans('adminlte_lang::message.passwordreset')}}</h4>
                                    
                                        {!! csrf_field() !!}
                                        <div class="card-content">
                                        @if (session('status'))
                                            <div class="alert alert-info">
                                                <span class="text-center">{{ session('status') }}</span>
                                            </div>
                                            
                                        @endif

                                        
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">email_circle</i>
                                                </span>
                                                
                                                <div class="form-group label-floating has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                                                    <label class="control-label">Email</label>
                                                    <input type="email" name="email" class="form-control"  value="{{ old('email') }}" placeholder="">
                                                    @if ($errors->has('email'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('email') }}</strong>
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
                                            <button type="submit" class="btn btn-fill btn-primary btn-round" btn-sign-in>{{ trans('adminlte_lang::message.sendpassword') }}</button>
                                            
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
@endsection

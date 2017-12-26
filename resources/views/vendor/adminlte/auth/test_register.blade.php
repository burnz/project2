@extends('adminlte::layouts.auth')


@section('htmlheader_title')
    Register
@endsection

@section('content')
    <link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}"/>
    <style type="text/css">
        .intl-tel-input.allow-dropdown .flag-container, .intl-tel-input.separate-dial-code .flag-container
        {
            left:auto !important;
            right:0 !important;
        }
        .is-focused input[id="phone"]{
            padding-left:0px !important;
        }
    </style>

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
                                    <div class="card-content">
                                        <div class="col-lg-12 m-0 p-0">@include('flash::message')</div>
                                        <form role="form" method="POST" action="{{ route('test.registerAction') }}">
                                            {!! csrf_field() !!}

                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">account_circle</i>
                                                </span>
                                                <div class="form-group label-floating has-feedback{{ $errors->has('name') ? ' has-error' : '' }}">
                                                    <label class="control-label">&nbsp;</label>
                                                    <input type="text" name="name" placeholder="Username" value="{{ old('name') }}" autofocus="autofocus" class="form-control">
                                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                            {{ $errors->first('name') }}
                                                        </span>
                                                @endif
                                                </div>
                                                

                                            </div>

                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">account_circle</i>
                                                </span>
                                                <div class="form-group label-floating has-feedback">
                                                    <input type="text" value="{{ $referrerId }}" name="refererId" id="refererId" class="form-control" placeholder="Id Sponsor">
                                                    <span class="help-block" id="refererIdError"></span>
                                                </div>
                                            </div>

                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">account_circle</i>
                                                </span>
                                                <div class="form-group label-floating has-feedback">
                                                    <input type="text" value="{{ $referrerName }}" name="referrerName" id="referrerName" class="form-control" placeholder="Username Sponsor">
                                                    <span class="help-block" id="refererNameError"></span>
                                                </div>
                                            </div>
                                            
                                            @if (Config::get('app.enable_captcha'))
                                            <div class="form-group{{ $errors->has('terms') ? ' has-error' : '' }}">
                                                {!! app('captcha')->display()!!}
                                                @if ($errors->has('g-recaptcha-response'))
                                                    <span class="help-block">
                                                        {{ $errors->first('g-recaptcha-response') }}
                                                    </span>
                                                @endif
                                            </div>
                                            @endif
                                            <div class="row">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('adminlte_lang::user.btn_register') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </div>
    @include('adminlte::layouts.partials.scripts_auth')
    @include('adminlte::auth.terms')
    <script>
        $(document).ready(function(){
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%'
            });
            var mytimer;
            $('#refererId').keyup(function(){
                clearTimeout(mytimer);
                var search = $(this).val();
                if(search.length >= 1){
                    mytimer = setTimeout(function(){
                        $.ajax({
                            type: "GET",
                            url: "/users/search",
                            data: {id : search}
                        }).done(function(data){
                            if(data.err) {
                                $('#refererId').parent().addClass('has-error');
                                $('#refererIdError').text(data.err);
                                $('#referrerName').val('');
                            }else{
                                $('#referrerName').parent().removeClass('has-error');
                                $('#refererNameError').text('');
                                $('#refererId').parent().removeClass('has-error');
                                $('#refererIdError').text('');
                                $('#referrerName').val(data.username);
                            }
                        });
                    }, 1000);
                }
            });
            $('#referrerName').keyup(function(){
                clearTimeout(mytimer);
                var search = $(this).val();
                if(search.length >= 3){
                    mytimer = setTimeout(function(){
                        $.ajax({
                            type: "GET",
                            url: "/users/search",
                            data: {username : search}
                        }).done(function(data){
                            if(data.err) {
                                $('#referrerName').parent().addClass('has-error');
                                $('#refererNameError').text(data.err);
                                $('#refererId').val('');
                            }else{
                                $('#refererId').parent().removeClass('has-error');
                                $('#refererIdError').text('');
                                $('#referrerName').parent().removeClass('has-error');
                                $('#refererNameError').text('');
                                $('#refererId').val(data.id);
                            }
                        });
                    }, 1000);
                }
            });
        });
    </script>
    </body>

@endsection
@include('adminlte::layouts.partials.scripts_footer')
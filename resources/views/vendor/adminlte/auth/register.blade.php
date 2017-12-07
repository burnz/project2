@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.register') }}
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
<body class="off-canvas-sidebar">
    <div class="wrapper wrapper-full-page">
        <div class="full-page register-page" filter-color="carcoin-secondary-1">
            <div class="container">
                <div class="row d-flex">
                    <div class="col-md-12">
                        <div class="card-signup p-0">
                            <div class="row d-flex">
                                <div class="col-md-3 col-md-offset-1 align-self-center">
                                    <div class="card-content" sign-up-step>
                                        <div class="info info-horizontal">
                                            <div class="icon active">
                                                <i class="material-icons">done</i>
                                            </div>
                                            <div class="description">
                                                <h4 class="info-title">Register</h4>
                                            </div>
                                        </div>
                                        
                                        <div class="info info-horizontal">
                                            <div class="icon"></div>
                                            <div class="description">
                                                <h4 class="info-title">Active</h4>
                                            </div>
                                        </div>
                                        
                                        <div class="info info-horizontal">
                                            <div class="icon end"></div>
                                            <div class="description">
                                                <h4 class="info-title">Complete</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card">
                                        <form class="form" method="post" action="{{ URL::to("/register") }}">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="refererId" value="{{$refererId}}" />
                                            <input type="hidden" name="referrerName" value="{{$referrerName}}" />
                                            <div class="card-header text-center">
                                                <div class="logo"><img src="{{asset('Carcoin/img/zcoin-id-final_logo-rev.svg')}}"></div>
                                            </div>
                                                <div class="card-content">

                                                    <div class="row">
                                                        <div class="col-md-12 p-0">
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons">account_circle</i>
                                                                    </span>
                                                                    <div class="form-group label-floating has-feedback{{ $errors->has('firstname') ? ' has-error' : '' }}">
                                                                        <label class="control-label">{{ trans('adminlte_lang::user.firstname') }}</label>
                                                                        <input type="text" class="form-control" name="firstname" value="{{ old('firstname') }}">
                                                                        @if ($errors->has('firstname'))
                                                                            <span class="help-block">
                                                                                    {{ $errors->first('firstname') }}
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons">account_circle</i>
                                                                    </span>
                                                                    <div class="form-group label-floating has-feedback{{ $errors->has('lastname') ? ' has-error' : '' }}">
                                                                        <label class="control-label">{{ trans('adminlte_lang::user.lastname') }}</label>
                                                                        <input type="text" class="form-control" name="lastname" value="{{ old('lastname') }}">
                                                                        @if ($errors->has('lastname'))
                                                                            <span class="help-block">
                                                                                    {{ $errors->first('lastname') }}
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons">account_circle</i>
                                                                    </span>
                                                                    <div class="form-group label-floating has-feedback{{ $errors->has('name') ? ' has-error' : '' }}">
                                                                        <label class="control-label">{{ trans('adminlte_lang::user.username') }}</label>
                                                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                                                        @if ($errors->has('name'))
                                                                            <span class="help-block">
                                                                                    {{ $errors->first('name') }}
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons">contact_phone</i>
                                                                    </span>
                                                                    <div class="form-group label-floating has-feedback{{ $errors->has('phone') ? ' has-error' : '' }}">
                                                                        <label class="control-label">Phone</label>
                                                                        <input type="text" id="phone" name="phone" class="form-control" hidden="">
                                                                        <input type="text" id="country" name="country" class="form-control" style="display: none">
                                                                        <input type="text" id="name_country" name="name_country" class="form-control" style="display: none">
                                                                        @if ($errors->has('phone'))
                                                                            <span class="help-block">
                                                                                {{ $errors->first('phone') }}
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div style="clear:fix"></div>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons">mail_outline</i>
                                                                    </span>
                                                                    <div class="form-group label-floating has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                                                                        <label class="control-label">{{ trans('adminlte_lang::user.email') }}</label>
                                                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                                                        @if ($errors->has('email'))
                                                                            <span class="help-block">
                                                                                {{ $errors->first('email') }}
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons">lock_outline</i>
                                                                    </span>
                                                                    <div class="form-group label-floating has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                                                                        <label class="control-label">Password</label>
                                                                        <input type="password" class="form-control" name="password">
                                                                        @if ($errors->has('password'))
                                                                            <span class="help-block">
                                                                                {{ $errors->first('password') }}
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons">lock_outline</i>
                                                                    </span>
                                                                    <div class="form-group label-floating has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                                                        <label class="control-label">Retype Password</label>
                                                                        <input type="password" class="form-control" name="password_confirmation">
                                                                        @if ($errors->has('password_confirmation'))
                                                                            <span class="help-block">
                                                                                {{ $errors->first('password_confirmation') }}
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            

                                                        </div>
                                                    </div>
                                                    <div class="row d-flex my-4">
                                                        <div class="col-xs-12 align-self-center">
                                                            <div class="checkbox form-horizontal-checkbox has-feedback{{ $errors->has('terms') ? ' has-error' : '' }}">
                                                                <label>
                                                                    <input type="checkbox" name="terms" > <a href="/term-condition.html" class="text-danger" target="_blank">{{ trans('adminlte_lang::user.terms_text') }}</a>
                                                                </label>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    @if (Config::get('app.enable_captcha'))
                                                        <div class="col-md-12 p-0">
                                                            <div class="form-group{{ $errors->has('terms') ? ' has-error' : '' }}">
                                                            {!! app('captcha')->display()!!}
                                                            @if ($errors->has('g-recaptcha-response'))
                                                                <span class="help-block">
                                                                    {{ $errors->first('g-recaptcha-response') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="footer text-center">
                                                    <button type="submit" class="btn btn-fill btn-primary btn-round" btn-sign-up>{{ trans('adminlte_lang::user.btn_register') }}</button>
                                                    <div class="clearfix"></div>
                                                    <div class="my-3"><a href="{{URL::to('login')}}">{{ trans('adminlte_lang::user.membreship') }}</a></div>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('adminlte::layouts.partials.footer')
        </div>
    </div>
</body>

@include('adminlte::layouts.partials.scripts_footer')


<script src="{{ URL::to('js/intlTelInput.js')}}"></script>
<script src="{{ URL::to('js/utils.js')}}"></script>

<script>
        function changeUrl(){
            var URL = window.location.href;
            if (URL.split('/')[3] == 'ref') {
                window.history.pushState("object or string", "Title", "/register");
            }
        }
        $(document).ready(function(){
            var changurl = changeUrl();
            $("#phone").intlTelInput({
            });
            
            $('form').submit(function(){
                $("#phone").val($("#phone").intlTelInput("getNumber"));
                $("#country").val($("#phone").intlTelInput("getSelectedCountryData").dialCode);
                $("#name_country").val($("#phone").intlTelInput("getSelectedCountryData").name);
            });
            
            // $('input').iCheck({
            //     checkboxClass: 'icheckbox_square-blue',
            //     radioClass: 'iradio_square-blue',
            //     increaseArea: '20%'
            // });
            var mytimer;
            $('#refererId').on('blur onmouseout', function () {
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
            $('#referrerName').on('blur onmouseout', function () {
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
    <script type="text/javascript">
        jQuery(document).on('click',function(){
            var phone=$('input#phone');
            if(phone.val()!='')
            {
                phone.css('padding-left','0px');
            }
            else
            {
                phone.css('padding-left','52px');
            }
        });
    </script>
@endsection

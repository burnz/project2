@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    Authentication
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
                                <form action="/authenticator" method="post">
                                <h4 class="text-center">2FA Authenticator</h4>
                                    {!! csrf_field() !!}
                                    <div class="card-content">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">email_circle</i>
                                            </span>
                                            
                                            <div class="form-group label-floating has-feedback{{ $valid ? '' : ' has-error' }}">
                                                <label class="control-label">2FA Code</label>
                                                <input type="text" name="code" class="form-control"  value="{{ old('code') }}" placeholder="">
                                                @if ($errors->has(''))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('code') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    <div class="footer text-center">
                                        <button type="submit" class="btn btn-fill btn-primary btn-round" btn-sign-in>{{ trans('adminlte_lang::default.submit') }}</button>
                                        
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
@endsection

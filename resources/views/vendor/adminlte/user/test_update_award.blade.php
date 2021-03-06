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
                                        <form role="form" method="POST" action="{{ route('test.saveAward') }}">
                                            {!! csrf_field() !!}

                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">account_circle</i>
                                                </span>
                                                <div class="form-group label-floating has-feedback{{ $errors->has('name') ? ' has-error' : '' }}">
                                                    <label class="control-label">&nbsp;</label>
                                                    <input type="text" name="name" placeholder="Username" value="" autofocus="autofocus" class="form-control">
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
                                                    <input type="text" value="" name="award" id="award" class="form-control" placeholder="Value of award">
                                                    <span class="help-block" id="refererIdError"></span>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
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
    </body>

@endsection
@include('adminlte::layouts.partials.scripts_footer')
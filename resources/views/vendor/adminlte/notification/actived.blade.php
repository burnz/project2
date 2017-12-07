@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    
@endsection

@section('content')

<body class="off-canvas-sidebar">
<div class="wrapper wrapper-full-page">
    <div class="full-page register-page" filter-color="carcoin-secondary-1">
        <div class="container">
            <div class="row d-flex">
                <div class="col-md-10 col-md-offset-1">
                    <div class="card-signup">
                        <div class="row d-flex">
                            <div class="col-md-5 col-md-offset-1 align-self-center">
                                <div class="card-content" sign-up-step>
                                    <div class="info info-horizontal">
                                        <div class="icon"></div>
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
                                        <div class="icon active end">
                                            <i class="material-icons">done</i>
                                        </div>
                                        <div class="description">
                                            <h4 class="info-title">Complete</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 align-self-center">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <div class="logo"><img src="{{asset('Carcoin/img/zcoin-id-final_logo-rev.svg')}}"></div>
                                    </div>
                                    <form class="form" method="" action="register.html">
                                        <div class="card-content text-center">
                                            <div class="h3 mb-2">This account has been activated!</div>
                                        </div>
                                        <div class="footer text-center">
                                            <div class="clearfix"></div>
                                            <div class="my-3"><a href="{{URL::to('login')}}">Go to Sign in</a></div>
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

@endsection

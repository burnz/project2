<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('/favicon.ico') }}">
    <title>Monster Admin Template - The Most Complete & Trusted Bootstrap 4 Admin Template</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="css/colors/blue.css" id="theme" rel="stylesheet">
    <link href="{{ URL::to('css/intlTelInput.css')}}" rel="stylesheet">
    <style>
        .iti-flag {background-image: url("{{ URL::to('img/flags.png')}}");}

        @media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2 / 1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx) {
            .iti-flag {background-image: url("{{ URL::to('img/flags@2x.png')}}");}
        }
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        window.trans = @php
            // copy all translations from /resources/lang/CURRENT_LOCALE/* to global JS variable
            $lang_files = File::files(resource_path() . '/lang/' . App::getLocale());
            $trans = [];
            foreach ($lang_files as $f) {
                $filename = pathinfo($f)['filename'];
                $trans[$filename] = trans($filename);
            }
            $trans['adminlte_lang_message'] = trans('adminlte_lang::message');
            echo json_encode($trans);
        @endphp
    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-107989535-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-107989535-1');
    </script>
</head>

<body>
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<section id="wrapper">
    <div class="login-register" style="background-image:url({{asset('assets/images/background/login-register.jpg')}});">
        <div class="login-box card">
            <div class="card-body">
                <form class="form-horizontal form-material input-form" id="loginform" method="POST" action="{{ URL::to("/register") }}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="refererId" value="{{$refererId}}" />
                    <input type="hidden" name="referrerName" value="{{$referrerName}}" />
                    <h3 class="box-title m-b-20">Sign Up</h3>
                    <div class="form-group has-feedback{{ $errors->has('firstname') ? ' has-error' : '' }}">
                        <div class="col-xs-12">
                            <input class="form-control" name="firstname" type="text" placeholder="{{ trans('adminlte_lang::user.firstname') }} " autofocus="autofocus" >
                            @if ($errors->has('firstname'))
                                <span class="help-block">
                                    {{ $errors->first('firstname') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group has-feedback{{ $errors->has('lastname') ? ' has-error' : '' }}">
                        <div class="col-xs-12">
                            <input class="form-control" name="lastname" type="text" placeholder="{{ trans('adminlte_lang::user.lastname') }}">
                            @if ($errors->has('lastname'))
                                <span class="help-block">
                                    {{ $errors->first('lastname') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group has-feedback{{ $errors->has('name') ? ' has-error' : '' }}">
                        <div class="col-xs-12">
                            <input type="text" placeholder="{{ trans('adminlte_lang::user.username') }}" name="name" value="{{ old('name') }}" class="form-control">
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="" >
                        <div class="col-xs-12">
                            <input type="text" id="phone" name="phone" class="" style="width: 100%">
                            <input type="text" id="country" name="country" class="form-control" style="display: none;">
                            <input type="text" id="name_country" name="name_country" class="form-control" style="display: none;">
                        </div>
                    </div>
                    <br>
                    <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                        <div class="col-xs-12">
                            <input type="email" placeholder="{{ trans('adminlte_lang::user.email') }}" name="email" value="{{ old('email') }}" class="form-control">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="password" placeholder="Password">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <div class="col-xs-12">
                            <input class="form-control" name="password_confirmation" type="password"  placeholder="Confirm Password">
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    {{ $errors->first('password_confirmation') }}
                                </span>
                            @endif
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
                    <br>
                    <div class="form-group">
                        <div class="col-md-12 has-feedback{{ $errors->has('terms') ? ' has-error' : '' }}">
                            <div class="checkbox checkbox-success p-t-0 p-l-10">
                                <input id="checkbox-signup" type="checkbox" name="terms">
                                <label for="checkbox-signup"> I agree to all <a href="/term-condition.html">Terms</a></label>
                            </div>
                            @if ($errors->has('terms'))
                                <span class="help-block">
                                    {{ $errors->first('terms') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Sign Up</button>
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <div class="col-sm-12 text-center">
                            <p>Already have an account? <a href="{{URL::to('login')}}" class="text-info m-l-5"><b>Sign In</b></a></p>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

</section>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{asset('assets/plugins/bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{asset('js/jquery.slimscroll.js')}}"></script>
<!--Wave Effects -->
<script src="{{asset('js/waves.js')}}"></script>
<!--Menu sidebar -->
<script src="{{asset('js/sidebarmenu.js')}}"></script>
<!--stickey kit -->
<script src="{{asset('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
<!--Custom JavaScript -->
<script src="{{asset('js/custom.min.js')}}"></script>
<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->
<script src="{{asset('assets/plugins/styleswitcher/jQuery.style.switcher.js')}}"></script>
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
</body>

</html>
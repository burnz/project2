<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Car Coin Admin Template</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{asset('v1')}}/img/favicon.png">
    <!-- Bootstrap core CSS     -->
    <link href="{{asset('v1')}}/css/bootstrap.min.css" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="{{asset('v1')}}/css/material-dashboard.css" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="{{asset('v1')}}/css/demo.css" rel="stylesheet" />
    <!--  Custom CSS    -->
    <link href="{{asset('v1')}}/css/custom.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @yield('css')
</head>

<body>
<div class="wrapper">
    <div class="sidebar" data-active-color="carcoin" data-background-color="carcoin" data-image="http://carcoin.wan2save.vn/wp-content/uploads/2017/10/illu2.svg">
        <!--
    Tip 1: You can change the color of active element of the sidebar using: data-active-color="purple | blue | green | orange | red | rose"
    Tip 2: you can also add an image using data-image tag
    Tip 3: you can change the color of the sidebar with data-background-color="white | black"
-->
        <div class="logo">
            <a href="http://www.bigin.vn" class="simple-text logo-mini">
                <img src="http://carcoin.wan2save.vn/wp-content/uploads/2016/11/zcoin-id-final_logo-rev.svg">
            </a>
            <a href="http://www.bigin.vn" class="simple-text logo-normal">
                Car Coin
            </a>
        </div>
        <div class="sidebar-wrapper">
            <div class="user">
                <div class="photo">
                    <img src="{{asset('v1')}}/img/user/avatar.jpg" />
                </div>
                <div class="info">
                    <span>Tania Andrew</span>
                    <span>ID: 123456</span>
                    <span>Loyalty: Diadmond</span>
                </div>
            </div>
            <ul class="nav">
                <li class="active">
                    <a href="dashboard.html">
                        <i class="material-icons">dashboard</i>
                        <p> Dashboard </p>
                    </a>
                </li>
                <li>
                    <a href="dashboard.html">
                        <i class="material-icons">shopping_basket</i>
                        <p> Presale </p>
                    </a>
                </li>
                <li>
                    <a href="dashboard.html">
                        <i class="material-icons">supervisor_account</i>
                        <p> Manager Member </p>
                    </a>
                </li>
                <li>
                    <a href="dashboard.html">
                        <i class="material-icons">card_giftcard</i>
                        <p> My Bonus </p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-panel">
        <nav class="navbar navbar-absolute">
            <div class="container-fluid">
                <div class="navbar-header d-flex" style="position: relative;">
                    <button type="button" class="navbar-toggle pull-right align-self-center" data-toggle="collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <ul class="navbar-wallet align-self-center">
                        <li>
                            <a href="#">
                                <div class="icon"><img src="{{asset('v1')}}/img/bitcoin-symbol.svg"></div>
                                <div class="content"><small>Bitcoin Wallet</small>
                                    <br><big class="bitcoin-color">0.0001</big></div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="icon"><img src="{{asset('v1')}}/img/ic_zcoin-pri.svg"></div>
                                <div class="content"><small>Carcoin Wallet</small>
                                    <br><big class="carcoin-color">1050</big></div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="icon"><img src="{{asset('v1')}}/img/ic_zcoin-sec.svg"></div>
                                <div class="content"><small>Reinvest Wallet</small>
                                    <br><big class="reinvest">1050</big></div>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-wallet align-self-center">
                        <li><b class="bitcoin-color">1 BTC </b> = $ 8,400.00</li>
                        <li><b class="carcoin-color">1 CAR </b> = ? $</li>
                        <li><b class="carcoin-color">1 CAR </b> = ? BTC</li>
                    </ul>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="material-icons">person</i>
                                <p class="hidden-lg hidden-md">
                                    Profile
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#">My Profile</a>
                                </li>
                                <li>
                                    <a href="#">Edit Profile</a>
                                </li>
                                <li>
                                    <a href="#">Settings</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">
                                <i class="material-icons">power_settings_new</i>
                                <p class="hidden-lg hidden-md">Logout</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="content">
            @yield('content')
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <!-- <nav class="pull-left">
                        <ul>
                            <li>
                                <a href="dashboard.html#">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="dashboard.html#">
                                    Company
                                </a>
                            </li>
                            <li>
                                <a href="dashboard.html#">
                                    Portofolio
                                </a>
                            </li>
                            <li>
                                <a href="dashboard.html#">
                                    Blog
                                </a>
                            </li>
                        </ul>
                    </nav> -->
                <p class="copyright pull-right">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                    <a href="http://bigin.vn/">BIGIN</a>
                </p>
            </div>
        </footer>
    </div>
</div>
</body>
<!--   Core JS Files   -->
<script src="{{asset('v1')}}/js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="{{asset('v1')}}/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{{asset('v1')}}/js/material.min.js" type="text/javascript"></script>
<script src="{{asset('v1')}}/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script> -->
<!-- Library for adding dinamically elements -->
<script src="{{asset('v1')}}/js/arrive.min.js" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="{{asset('v1')}}/js/jquery.validate.min.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="{{asset('v1')}}/js/moment.min.js"></script>
<!--  Charts Plugin, full documentation here: https://gionkunz.github.io/chartist-js/ -->
<script src="{{asset('v1')}}/js/chartist.min.js"></script>
<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="{{asset('v1')}}/js/jquery.bootstrap-wizard.js"></script>
<!--  Notifications Plugin, full documentation here: http://bootstrap-notify.remabledesigns.com/    -->
<script src="{{asset('v1')}}/js/bootstrap-notify.js"></script>
<!--   Sharrre Library    -->
<script src="{{asset('v1')}}/js/jquery.sharrre.js"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="{{asset('v1')}}/js/bootstrap-datetimepicker.js"></script>
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="{{asset('v1')}}/js/jquery-jvectormap.js"></script>
<!-- Sliders Plugin, full documentation here: https://refreshless.com/nouislider/ -->
<script src="{{asset('v1')}}/js/nouislider.min.js"></script>
<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1_8C5Xz9RpEeJSaJ3E_DeBv8i7j_p6Aw"></script>
<!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="{{asset('v1')}}/js/jquery.select-bootstrap.js"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="{{asset('v1')}}/js/jquery.datatables.js"></script>
<!-- Sweet Alert 2 plugin, full documentation here: https://limonte.github.io/sweetalert2/ -->
<script src="{{asset('v1')}}/js/sweetalert2.js"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="{{asset('v1')}}/js/jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="{{asset('v1')}}/js/fullcalendar.min.js"></script>
<!-- Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="{{asset('v1')}}/js/jquery.tagsinput.js"></script>
<!-- Material Dashboard javascript methods -->
<script src="{{asset('v1')}}/js/material-dashboard.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="{{asset('v1')}}/js/demo.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        // Javascript method's body can be found in {{asset('v1')}}/js/demos.js
        demo.initDashboardPageCharts();

    });
</script>
@yield('script')
</html>
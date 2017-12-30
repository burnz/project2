
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title> CarCoin - @yield('htmlheader_title', 'Car Sharing Community') </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../Carcoin/img/favicon.png">

    <!-- CSRF Token -->
    <meta name="google-site-verification" content="YoKxcLBO-buCnESjlFmmFeZqaNULyT4Z88cVN4OLqN0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap core CSS     -->
    <link href="{{asset('Carcoin/css/bootstrap.min.css')}}" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="{{asset('Carcoin/css/material-dashboard.css')}}" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="{{asset('Carcoin/css/demo.css')}}" rel="stylesheet" />
    <!--  Custom CSS    -->
    <link href="{{asset('Carcoin/css/custom.css')}}" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="{{asset('Carcoin/js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>

    <script type="text/javascript">
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
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-110960621-1"></script>
    <script type="text/javascript">
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-110960621-1');
    </script>
    <script type="text/javascript">

    var formatter = new Intl.NumberFormat('en-US', {
            style: 'decimal',
            minimumFractionDigits: 2,
        });
    var formatterBTC = new Intl.NumberFormat('en-US', {
            style: 'decimal',
            minimumFractionDigits: 8,
        });
    function doLogout(){
         document.cookie = "open=1";
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    function getRate(){
        $.ajax({
            dataType: "json",
            url: '{{ URL::to("exchange") }}',
            success: function(data){
               $('.btcusd').html(formatter.format(data[1].exchrate));
               $('.clpusd').html(formatter.format(data[2].exchrate));
               $('.clpbtc').html(formatterBTC.format(data[0].exchrate));
               $('.clpbtcsell').html(formatterBTC.format(data[0].exchrate * 0.95));
               globalBTCUSD = data[1].exchrate;
               globalCLPUSD = data[2].exchrate; //clpUSD
               globalCLPBTC = data[0].exchrate;
            }
        });
    }
    getRate();
    setInterval(function(){ getRate() }, {{ config('app.time_interval') }}); 
    
</script>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>@yield('title')</title>
        <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
        <link rel="stylesheet" href="{{asset('css/adminlte-app.css')}}">
        <style type="text/css">
               body{
                    background: #4f4f65 !important;
                    overflow: hidden !important;
               }
               .wrap {
                    width: 1000px;
                    margin: 0 auto;
                }
                .main {
                    text-align: center;
                    background: rgba(255, 255, 255, 0.04);
                    color: #FFF;
                    font-weight: bold;
                    margin-top: 120px;
                    border: 1px solid rgba(102, 102, 102, 0.31);
                    -webkit-border-radius: 5px;
                    -moz-border-radius: 5px;
                    border-radius: 5px;
                }
                .main h3 {
                    font-size: 200px;
                    color: #f44336;
                    text-align: center;
                    margin-bottom: 1px;
                    text-shadow: 1px 1px 6px #fff;
                }
                .main h3 a>img{
                    margin:0 auto;
                }
                .main h1 {
                    font-size: 60px;
                    margin-top: 15px;
                    /*color: #1CD3CB;*/
                    color:#ff9800 !important;
                    text-transform: uppercase;
                    font-family: 'Fenix', serif;
                }
                .main p {
                    font-size: 20px;
                    margin-top: 15px;
                    line-height: 1.6em;
                }
                .main span.error {
                    color: #48C8D3;
                    font-size: 18px;
                }
                .main p span {
                    font-size: 14px;
                    color: #24817A;
                }
        </style>
    </head>
    <body>
        <div class="wrap">
            @yield('content')
        </div>
             
    </body>
</html>
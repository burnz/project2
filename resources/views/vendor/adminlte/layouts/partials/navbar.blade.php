
<nav class="navbar navbar-absolute">
    <div class="container-fluid">
        <div class="navbar-header d-flex" style="position: relative;">
            <button type="button" class="navbar-toggle pull-right align-self-center" data-toggle="collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <ul class="navbar-wallet align-self-center" icon>
                <li>
                    <a href="javascript:;">
                        <div class="icon"><img src="/Carcoin/img/bitcoin-symbol.svg"></div>
                        <div class="content"><small>Bitcoin Wallet</small>
                            <br><big class="bitcoin-color"><span class="btc_bl">{{ number_format($walletAmount['amountBTC'], 5) }}</span></big></div>
                        </a>
                    </li>
                        <li>
                            <a href="#">
                                <div class="icon"><img src="/Carcoin/img/ic_zcoin-pri.svg"></div>
                                <div class="content"><small>Carcoin Wallet</small>
                                    <br><big class="carcoin-color"><span class="carcoin_bl">{{ number_format($walletAmount['amountCLP'], 5) }}</span></big></div>
                            </a>
                        </li>
                            <li class="dropdown hidden">
                                <div class="dropdown-toggle text-white text-center p-0" data-toggle="dropdown" href="#">
                                    <i class="material-icons">arrow_drop_down_circle</i>
                                </div>
                                <ul class="dropdown-menu">
                                </ul>
                            </li>
                        </ul>

                        <ul class="navbar-wallet align-self-center">
                            <li><b class="bitcoin-color">1 BTC </b><span class="btcusd"></span></li>
                            <li><b class="carcoin-color">1 CAR </b><span class="carusd"></span></li>
                            <li><b class="carcoin-color">1 CAR </b><span class="carbtc"></span></li>
                        </ul>
                    </div>
                    <div class="collapse navbar-collapse ">


                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="material-icons">settings</i>
                                <p class="hidden-lg hidden-md">
                                    Profile
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <ul class="dropdown-menu">
                            <li>
                                <a class="d-flex" href="{{url('profile/security')}}">
                                    <i class="material-icons justify-content-center mr-3">build</i>
                                    <p class="align-self-center m-0">Settings</p>
                                </a>
                            </li>
                            <li>
                                <a class="d-flex" href="{{url('profile')}}">
                                    <i class="material-icons justify-content-center mr-3">person</i>
                                    <p class="align-self-center m-0">Profile</p>
                                </a>
                            </li>
                            <li>
                            <a class="d-flex" href="{{ url('/logout') }}" id="logout" onclick="event.preventDefault();
                                    doLogout();
                                    document.getElementById('logout-form').submit();">
                                    <i class="material-icons justify-content-center mr-3">power_settings_new</i>
                                    <p class="align-self-center m-0">Sign out</p>
                                </a>
                            </li>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                                <input type="submit" value="logout" style="display: none;">
                            </form>
                            </ul>
                        </li>
                    </ul>


                </div>
            </div>
        </nav>
        <script>
            var formatter = new Intl.NumberFormat('en-US', {
                style: 'decimal',
                minimumFractionDigits: 5,
            });

            var formatterBTCUSD = new Intl.NumberFormat('en-US', {
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
           var globalBTCUSD = {{ $btcUSDRate }};
           function getRate(){
            $.ajax({
                dataType: "json",
                url: '{{ URL::to("exchange") }}',
                success: function(data){
                 $('.btcusd').html(' = $'+formatterBTCUSD.format(data[1].exchrate));
                 $('.carusd').html('= $ ' + formatter.format(data[2].exchrate));
                 $('.carbtc').html('= ' + formatterBTC.format(data[0].exchrate)+' BTC');
                 globalBTCUSD = data[1].exchrate;
                 globalCARUSD = data[2].exchrate;
                 globalCARBTC = data[0].exchrate;
             }
         });
        }
        
        $(function() {
            getRate();
            setInterval(function(){ getRate() }, {{ config('app.time_interval') }});
        });  
        
    </script>

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
                        <div class="icon"><img src="/Carcoin/img/bitcoin-symbol.svg"></div>
                        <div class="content"><small>Bitcoin Wallet</small>
                            <br><big class="bitcoin-color">0.0001</big></div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="icon"><img src="/Carcoin/img/ic_zcoin-pri.svg"></div>
                            <div class="content"><small>Carcoin Wallet</small>
                                <br><big class="carcoin-color">1050</big></div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="icon"><img src="/Carcoin/img/ic_zcoin-sec.svg"></div>
                                <div class="content"><small>Reinvest Wallet</small>
                                    <br><big class="reinvest-color">1050</big></div>
                                </a>
                            </li>
                        </ul>
                        <ul class="navbar-wallet align-self-center">
                            <li><b class="bitcoin-color">1 BTC </b><span class="btcusd"></span></li>
                            <li><b class="carcoin-color">1 CAR </b><span class="carusd"></span></li>
                            <li><b class="carcoin-color">1 CAR </b><span class="carbtc"></span></li>
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
                                <a href="{{ url('/logout') }}" id="logout" onclick="event.preventDefault();
                                doLogout();
                                document.getElementById('logout-form').submit();">
                                
                                <i class="material-icons">power_settings_new</i>
                                <p class="hidden-lg hidden-md">Logout</p>

                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                                <input type="submit" value="logout" style="display: none;">
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <script>
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
                 $('.btcusd').html('= $ ' + formatter.format(data[1].exchrate));
                 $('.carusd').html('= $ ' + formatter.format(data[2].exchrate));
                 $('.carbtc').html('= BTC ' + formatterBTC.format(data[0].exchrate));
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
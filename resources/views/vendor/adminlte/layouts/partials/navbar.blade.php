
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
                        <li>
                            <a href="#">
                                <div class="icon"><img src="/Carcoin/img/ic_zcoin-sec.svg"></div>
                                <div class="content"><small>Reinvest Wallet</small>
                                    <br><big class="reinvest-color"><span class="reinvest_bl">{{ number_format($walletAmount['amountReinvest'], 5) }}</span></big></div>
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
                        <!-- <ul class="nav navbar-nav navbar-right">
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
                        </ul> -->

                    <ul class="nav navbar-nav navbar-right">
                        <li rel="tooltip" data-placement="bottom" title="Settings">
                            <a href="{{url('profile/security')}}">
                                <i class="material-icons">build</i>
                                <p class="hidden-lg hidden-md">Settings</p>
                            </a>
                        </li>
                        <li rel="tooltip" data-placement="bottom" title="Profile">
                            <a href="{{url('profile')}}">
                                <i class="material-icons">person</i>
                                <p class="hidden-lg hidden-md">Profile</p>
                            </a>
                        </li>
                        <li rel="tooltip" data-placement="bottom" title="Sign out">
                        <a href="{{ url('/logout') }}" id="logout" onclick="event.preventDefault();
                                doLogout();
                                document.getElementById('logout-form').submit();">
                                <i class="material-icons">power_settings_new</i>
                                <p class="hidden-lg hidden-md">Sign out</p>
                            </a>
                        </li>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            <input type="submit" value="logout" style="display: none;">
                        </form>
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
                 $('.btcusd').html(' = $'+formatter.format(data[1].exchrate));
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
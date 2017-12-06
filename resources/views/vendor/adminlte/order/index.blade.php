@extends('adminlte::layouts.backend')
@section('htmlheader')
    @parent
    <link rel="icon" href="assets/img/favicon.png">
    <!-- Bootstrap core CSS     -->
    <link href="/presale/assets/css/bootstrap.min.css" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="/presale/assets/css/material-dashboard.css" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="/presale/assets/css/demo.css" rel="stylesheet" />
    <!--  Custom CSS    -->
    <link href="/presale/assets/css/custom.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row d-flex" section="dashboard-status">
            <div class="col-md-8 align-self-center">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="carcoin-primary-1">
                                <i class="material-icons">label</i>
                            </div>
                            <div class="card-content">
                                <p class="category">Today's Price</p>
                                <h4 class="card-title">$ {{ $price }}</h4>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">update</i> Just Updated
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="carcoin-primary-2">
                                <i class="material-icons">content_paste</i>
                            </div>
                            <div class="card-content">
                                <p class="category">Order Total</p>
                                <h4 class="card-title">$ {{ $totalValueOrder }}</h4>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">date_range</i> Last 24 Hours
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="carcoin-primary-3">
                                <i class="material-icons">gavel</i>
                            </div>
                            <div class="card-content">
                                <p class="category">Online Auction</p>
                                <h4 class="card-title countdow">24:00</h4>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">update</i> 2017/11/25
                                </div>
                                <span class="badge badge-primary">Closed</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="carcoin-primary-1">
                                <i class="material-icons">trending_up</i>
                            </div>
                            <div class="card-content">
                                <p class="category">Auction <br> Step</p>
                                <h4 class="card-title">$ 0.01</h4>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">update</i> Just Updated
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="carcoin-primary-2">
                                <i class="material-icons">av_timer</i>
                            </div>
                            <div class="card-content">
                                <p class="category">Auction Order Volume</p>
                                <h4 class="card-title"><img src="{{asset('v1')}}/img/ic_zcoin-pri.svg" style="width: 24px" > <span class="totalOrderInDay">{{ number_format($totalOrderInDay) }}</span></h4>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">update</i> Just Updated
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="carcoin-primary-3">
                                <i class="material-icons">access_time</i>
                            </div>
                            <div class="card-content">
                                <p class="category">Auction <br>Orders</p>
                                <h4 class="card-title totalValueOrderInDay">{{ number_format($totalValueOrderInday) }}</h4>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">update</i> Closed 6 hours 54 mins ago
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 align-self-center">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Create An Order (BTC/CAR)</h4>
                    </div>
                    <div class="card-content text-center">
                        <form method="#" action="regular.html#">
                            <p class="text-primary">You have {{ number_format($amountBTC, 5) }} BTC / <span class="amountUSD"></span>USD</p>
                            <div class="input-group form-group">
                            <span class="input-group-addon">
                                <img src="{{asset('v1')}}/img/ic_zcoin-pri.svg" style="width: 24px;">
                            </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">You'll receive</label>
                                    <input name="amount" type="text" class="form-control" id="total">
                                    <span class="material-input"></span>
                                </div>
                            </div>

                            <div class="input-group form-group">
                            <span class="input-group-addon">
                                <img src="{{asset('v1')}}/img/bitcoin-symbol.svg" style="width: 24px;">
                            </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Price per CAR</label>
                                    <input
                                            name="price"
                                            type="number"
                                            class="form-control"
                                            id="price"
                                            min="{{ $price }}"
                                            step="0.01"
                                            required
                                    >
                                    <span class="material-input"></span></div>
                            </div>

                            <div class="input-group form-group">
                            <span class="input-group-addon">
                                <img src="{{asset('v1')}}/img/bitcoin-symbol.svg" style="width: 24px;">
                            </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">You'll pay</label>
                                    <input type="number"
                                           class="form-control"
                                           id="amount"
                                           autofocus="autofocus"
                                           step="0.01"
                                           min="0"
                                           max="{{ $amountBTC }}"
                                           required
                                           disabled
                                    >
                                    <span class="help-block" style="display: block;" id="valueInUSD"> </span>
                                    <span class="material-input"></span></div>
                            </div>

                            <button type="button" class="btn btn-fill btn-primary btn-round" id="order">Create Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="carcoin-primary-1">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Command</h4>
                        <div class="table-responsive">
                            <table class="table" id="employee-grid">
                                <thead class="text-primary">
                                <th>Price (USD)</th>
                                <th>Volume (CAR)</th>
                                <th>Total (USD)</th>
                                </thead>
                                @foreach($dataTableRealTime as $data)
                                    <tr>
                                        <td>{{ $data->price }}</td>
                                        <td>{{ $data->amount }}</td>
                                        <td>{{ $data->total }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="carcoin-primary-1">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Market Order History</h4>
                        <div class="table-responsive">
                            <table class="table" id="market-grid" >
                                <thead class="text-primary">
                                <th>Date/Time</th>
                                <th>Volume (CAR)</th>
                                <th>Price (BTC)</th>
                                <th>Total (BTC)</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="carcoin-primary-1">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">My Order - BTC/CAR</h4>
                        <div class="table-responsive">
                            <table id="history-grid" class="table">
                                <thead class="text-primary">
                                <th>Time</th>
                                <th>Status</th>
                                <th>Volume (CAR)</th>
                                <th>Price (USD)</th>
                                <th>Total (USD)</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!--   Core JS Files   -->
    <script src="/presale/assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.1/lodash.min.js"></script>
    <script src="/presale/assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/presale/assets/js/material.min.js" type="text/javascript"></script>

    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script> -->
    <!-- Library for adding dinamically elements -->
    <script src="/presale/assets/js/arrive.min.js" type="text/javascript"></script>
    <!-- Forms Validations Plugin -->
    <script src="/presale/assets/js/jquery.validate.min.js"></script>
    <!--  Plugin for Date Time Picker and Full Calendar Plugin-->
    <script src="/presale/assets/js/moment.min.js"></script>
    <!--  Charts Plugin, full documentation here: https://gionkunz.github.io/chartist-js/ -->
    <script src="/presale/assets/js/chartist.min.js"></script>
    <!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <script src="/presale/assets/js/jquery.bootstrap-wizard.js"></script>
    <!--  Notifications Plugin, full documentation here: http://bootstrap-notify.remabledesigns.com/    -->
    <script src="/presale/assets/js/bootstrap-notify.js"></script>
    <!--   Sharrre Library    -->
    <script src="/presale/assets/js/jquery.sharrre.js"></script>
    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="/presale/assets/js/bootstrap-datetimepicker.js"></script>
    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <script src="/presale/assets/js/jquery-jvectormap.js"></script>
    <!-- Sliders Plugin, full documentation here: https://refreshless.com/nouislider/ -->
    <script src="/presale/assets/js/nouislider.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1_8C5Xz9RpEeJSaJ3E_DeBv8i7j_p6Aw"></script>
    <!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="/presale/assets/js/jquery.select-bootstrap.js"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
    <script src="/presale/assets/js/jquery.datatables.js"></script>
    <!-- Sweet Alert 2 plugin, full documentation here: https://limonte.github.io/sweetalert2/ -->
    <script src="/presale/assets/js/sweetalert2.js"></script>
    <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="/presale/assets/js/jasny-bootstrap.min.js"></script>
    <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
    <script src="/presale/assets/js/fullcalendar.min.js"></script>
    <!-- Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
    <script src="/presale/assets/js/jquery.tagsinput.js"></script>
    <!-- Material Dashboard javascript methods -->

    <script src="/presale/assets/js/jquery.countdown.min.js"></script>
    <!-- Material Dashboard Countdown -->

    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="/presale/assets/js/demo.js"></script>
    <script type="text/template" id="main-example-template">

        <div class="time <%= label %>">
      <span class="count curr top"><%= curr %></span>
      <span class="count next top"><%= next %></span>
      <span class="count next bottom"><%= next %></span>
      <span class="count curr bottom"><%= curr %></span>
      <span class="label"><%= label.length < 6 ? label : label.substr(0, 3)  %></span>
    </div>

</script>
<script type="text/javascript">
$(document).ready(function() {

    // Javascript method's body can be found in assets/js/demos.js
    demo.initDashboardPageCharts();
    demo.initCoutdown();

});
</script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
    <script>
        $(document).ready(function () {
            $('#employee-grid').DataTable({
                "ordering": false,
                "searching":false,
                "bLengthChange": false,
                paging: false
            });

            var globalBTCUSD = 8600;
            $('#amount').on('keyup change mousewheel', function () {
                var value = $(this).val();
                var result = value * globalBTCUSD;
                $("#valueInUSD").html('USD ' + result.toFixed(2));
            });

            $('#order').click(function (event) {
                event.preventDefault();

                swal({
                    title: 'Are you sure?',
                    buttons: {
                        cancel: true,
                        confirm: true,
                    },
                }).then(function (result) {
                    if(result){
                        $.ajax({
                            beforeSend:function () {

                                if( $('#amount').val() == ''){
                                    swal ( "Oops" ,  "Not order , Please fill amount BTC !" ,  "error" );
                                    return false;
                                }

                                if( $('#amount').val() > {{ $amountBTC }}){
                                    swal ( "Oops" ,  "Not order , max price {{ $amountBTC }} !" ,  "error" );
                                    return false;
                                }

                                if( $('#price').val() == ''){
                                    swal ( "Oops" ,  "Not order , Please fill price !" ,  "error" )
                                    return false;
                                }

                                if( parseFloat($('#price').val()) < {{ $price }} ){
                                    swal ( "Oops" ,  "Not order , min price {{ $price }} !" ,  "error" )
                                    return false;
                                }

                                if( $('#total').val() == 0 ||
                                    ( +$("#amount").val() * globalBTCUSD ) / (+$("#price").val()) <= 0
                                ){
                                    swal ( "Oops" ,  "Not order , Total Value must greater than 0  !" ,  "error" )
                                    return false;
                                };

                            },
                            url : "{{ URL::to('/order') }}",
                            type : "post",
                            data : {
                                _token : "{{ csrf_token() }}",
                                amount : $("#total").val(),
                                price  : $("#price").val()
                            },
                            success : function (result){
                                swal ( "Done!" ,  "Order success" ,  "success" );
                                dataTableHistory.ajax.reload();
                            },
                            error: function(xhr) { // if error occured
                                swal ( "Oops" ,  "Not order , Please come back later !" ,  "error" )
                            },
                            complete: function() {
                                //end loading
                            }
                        });
                    }
                });
            });

            var dataTableTradeMarket = $('#market-grid').DataTable( {
                "processing": true,
                'language':{
                    "loadingRecords": "&nbsp;",
                    "processing": "Updating..."
                },
                "serverSide": true,
                "searching": false,
                "ordering": false,
                "ajax":{
                    url :"gethistorydatatrademarket", // json datasource
                    type: "get",  // method  , by default get
                    error: function(){  // error handling
                        $(".market-grid-error").html("");
                        $("#market-grid").append('<tbody class="market-grid-error"><tr><th colspan="3">No data available in table</th></tr></tbody>');
                        $("#market-grid_processing").css("display","none");
                    },
                    complete : function (dataTableHistory) {

                    }
                }
            } );

            var dataTableHistory = $('#history-grid').DataTable( {
                "processing": true,
                'language':{
                    "loadingRecords": "&nbsp;",
                    "processing": "Updating..."
                },
                "serverSide": true,
                "searching": false,
                "ordering": false,
                "ajax":{
                    url :"gethistorydataorderuser", // json datasource
                    type: "get",  // method  , by default get
                    error: function(){  // error handling
                        $(".history-grid-error").html("");
                        $("#history-grid").append('<tbody class="history-grid-error"><tr><th colspan="3">No data available in table</th></tr></tbody>');
                        $("#history-grid_processing").css("display","none");
                    },
                    complete : function (dataTableHistory) {

                    }
                }
            } );

            var socket = io.connect('{{config("app.api_app_url")}}');
            socket.on('message', function (data) {
                var result = JSON.parse(data);
                $(".totalOrderInDay").html(result.totalOrderInDay);
                $(".totalValueOrderInDay").html(result.totalValueOrderInday);
                var html = '';
                result.tableCommand.forEach(function (element) {
                    html += '<tr>' + '<td>' + element.price + '</td>' + '<td>' + element.amount + '</td>' + '<td>' + element.total + '</td>' + '</tr>';
                });
                $('#employee-grid tbody').html(html);
            });

            $('#total').on('keyup change mousewheel', function() {
                if( +$("#total").val() > 0 && +$("#price").val() >= {{ $price }} ){
                    var result = ( +$("#total").val() * (+$("#price").val()) ) / globalBTCUSD;
                    $('#amount').val( result.toFixed(5) );
                }else {
                    $('#amount').val('');
                }
            });

            $('#price').on('keyup change mousewheel', function() {
                if( +$("#total").val()  > 0 && +$("#price").val() >= {{ $price }} ){
                    var result = ( +$("#total").val() * (+$("#price").val()) ) / globalBTCUSD;
                    $('#amount').val( result.toFixed(5) );
                }else{
                    $('#amount').val('');
                }
//                $(this).val(parseFloat(Math.round($(this).val() * 100) / 100).toFixed(2))
            });

            $('.amountUSD').html( ({{ $amountBTC }}* globalBTCUSD).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') );
        });

        $(document).ready(function() {
            function ShowTime() {
                var now = new Date();
                var diff = 0;
                var nowTwo = new Date(now.getTime() + diff*60000);
                var hour = 23-nowTwo.getHours();
                var mins = 59-nowTwo.getMinutes();
                var secs = 59-nowTwo.getSeconds();
                timeLeft = hour +"h "+ "" +mins+'m '+secs+'s';
                $(".countdow").html(timeLeft);
                if ($(".countdow").html() === "0m 1s") {
                    location.reload(true)
                };
            };
            function StopTime() {
                clearInterval(countdown);
            }
            ShowTime();
            var countdown = setInterval(ShowTime ,1000);
        });

    </script>
@endsection
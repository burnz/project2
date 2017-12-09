@extends('adminlte::layouts.backend')
@section('htmlheader')
    @parent
    <!--  CSS for Demo Purpose, don't include it in your project     -->

    <!--  Custom CSS    -->
    <link href="/presale/assets/css/custom.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="content">
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
                                    <p class="category">Max Price Now </p>
                                    <h4 class="card-title countdow"><max-price>{{ isset($dataTableRealTime[0]) ? $dataTableRealTime[0]->price : 0}}</max-price></h4>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">update</i> Just Updated
                                    </div>
                                    <span class="badge badge-primary"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="carcoin-primary-1">
                                    <i class="material-icons">trending_up</i>
                                </div>
                                <div class="card-content">
                                    <p class="category">Auction
                                        <br> Step</p>
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
                                    <h4 class="card-title totalOrderInDay" >{{ number_format($totalOrderInDay) }}</h4>
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
                                    <p class="category">Auction
                                        <br>Orders</p>
                                    <h4 class="card-title totalValueOrderInDay">{{ number_format($totalValueOrderInday) }}</h4>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">update</i> Just Updated
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 align-self-center">
                    <div class="card card-countdown">
                        <div class="card-header text-center">
                            <h3>HURRY UP!</h3>
                        </div>
                        <div class="card-content">
                            <h4>Token Sale Registration ends in:</h4>
                            <div class="countdown">
                                <div class="countdown-container" id="countdown"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">gavel</i> CARCOIN is only sold with a limit of 200,000 coins/day.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex" section="create-an-order">
                <div class="col-md-4 align-self-center">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title text-center m-0">Create An Order (BTC/CAR)</h4>
                        </div>
                        <div class="card-content text-center">
                            <form method="#" action="regular.html#">
                                <p class="text-thirdary">You have <span class="btcAmount">{{ number_format($amountBTC, 5) }}</span> BTC / <span class="amountUSD"></span>USD</p>
                                <div class="input-group form-group">
                                            <span class="input-group-addon">
                                                <img src="/presale/assets/img/ic_zcoin-pri.svg" style="width: 24px;">
                                            </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">You'll receive</label>
                                        <input name="amount" type="text" class="form-control" id="total">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="input-group form-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">attach_money</i>
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
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="input-group form-group">
                                            <span class="input-group-addon">
                                                <img src="/presale/assets/img/bitcoin-symbol.svg" style="width: 24px;">
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
                                <button type="button" class="btn btn-fill btn-primary btn-round"  id="order">Create Order</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 align-self-center">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="carcoin-primary-1">
                            <i class="material-icons">assignment</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">Command</h4>
                            <div class="table-responsive table-scroll-y">
                                <table class="table" id="employee-grid">
                                    <thead class="text-thirdary">
                                    <th>Price (USD)</th>
                                    <th>Volume (CAR)</th>
                                    <th>Value (USD)</th>
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
            </div>

            <div class="row">
                <div class="col-md-12">
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
                                    <th>Price (USD)</th>
                                    <th>Value (USD)</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="carcoin-primary-1">
                            <i class="material-icons">assignment</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">My Order - BTC/CAR</h4>
                            <div class="table-responsive">
                                <table class="table" id="history-grid">
                                    <thead class="text-thirdary">
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Volume (CAR)</th>
                                    <th>Price (USD)</th>
                                    <th>Value (BTC)</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="/presale/assets/js/jquery.countdown.min.js"></script>
    <script src="{{asset('Carcoin/js/lodash.min.js')}}"></script>
    <script src="/presale/assets/js/demo.js"></script>

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
                                    swal ( "Oops" ,  "Cannot order , Please fill amount BTC !" ,  "error" );
                                    return false;
                                }

                                if( $('#amount').val() > {{ $amountBTC }}){
                                    swal ( "Oops" ,  "Cannot order , max price {{ $amountBTC }} !" ,  "error" );
                                    return false;
                                }

                                if( $('#price').val() == ''){
                                    swal ( "Oops" ,  "Cannot order , Please fill price !" ,  "error" )
                                    return false;
                                }

                                if( parseFloat($('#price').val()) < {{ $price }} ){
                                    swal ( "Oops" ,  "Cannot order , min price {{ $price }} !" ,  "error" )
                                    return false;
                                }

                                if( $('#total').val() == 0 ||
                                    ( +$("#amount").val() * globalBTCUSD ) / (+$("#price").val()) <= 0
                                ){
                                    swal ( "Oops" ,  "Cannot order , Total Value must greater than 0  !" ,  "error" )
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
                                $('.btcAmount').html(result.btcAmountLeft);
                                dataTableHistory.ajax.reload();
                            },
                            error: function(xhr) { // if error occured
                                swal ( "Oops" ,  "Cannot order , Please come back later !" ,  "error" )
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
                    url :"/gethistorydatatrademarket", // json datasource
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
                    url :"/gethistorydataorderuser", // json datasource
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
                var max = result.tableCommand
                $('max-price').html(max[0].price);
            });

            $('#total').on('keyup change mousewheel', function() {
                if( +$("#total").val() > 0 && +$("#price").val() >= {{ $price }} ){
                    var result = ( +$("#total").val() * (+$("#price").val()) ) / globalBTCUSD;
                    $('#amount').val( result.toFixed(5) );
                }else {
                    $('#amount').val('');
                }

                var amount=$('#amount');
                amount.trigger('change');

            });

            $('#price').on('keyup change mousewheel', function() {


                if( +$("#total").val()  > 0 && +$("#price").val() >= {{ $price }} ){
                    var result = ( +$("#total").val() * (+$("#price").val()) ) / globalBTCUSD;
                    $('#amount').val( result.toFixed(5) );
                }else{
                    $('#amount').val('');
                }

                var amount=$('#amount');
                amount.trigger('change');
                
//                $(this).val(parseFloat(Math.round($(this).val() * 100) / 100).toFixed(2))
            });


            $('.amountUSD').html( ({{ $amountBTC }}* globalBTCUSD).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') );
        });

    </script>
    <script type="text/template" id="main-example-template">

        <div class="time <%= label %>">
          <span class="count curr top"><%= curr %></span>
          <span class="count next top"><%= next %></span>
          <span class="count next bottom"><%= next %></span>
          <span class="count curr bottom"><%= curr %></span>
          <span class="label"><%= label.length < 6 ? label : label.substr(0, 3)  %></span>
        </div>

    </script>
@endsection
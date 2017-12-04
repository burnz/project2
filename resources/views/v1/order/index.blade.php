@extends('v1.layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
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
                        <p class="text-primary">You have {{ number_format($amountBTC, 5) }} BTC</p>
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
                    $('#amount').val(  ( +$("#total").val() * (+$("#price").val()) ) / globalBTCUSD );
                }else {
                    $('#amount').val('');
                }
            });

            $('#price').on('keyup change mousewheel', function() {
                if( +$("#total").val()  > 0 && +$("#price").val() >= {{ $price }} ){
                    $('#amount').val(  ( +$("#total").val() * (+$("#price").val()) ) / globalBTCUSD );
                }else{
                    $('#amount').val('');
                }
//                $(this).val(parseFloat(Math.round($(this).val() * 100) / 100).toFixed(2))
            });

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
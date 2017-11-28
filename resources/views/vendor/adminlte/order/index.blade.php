@extends('adminlte::layouts.member')

@section('contentheader_title')
    {{ trans('adminlte_lang::home.dashboard') }}
@endsection

@section('custome_css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <style>
        .dataTables_filter {
            display: none;
        }
    </style>
@endsection

@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <div class="card clp-home">
                <div class="card-body clp-dashboard">
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3 class="countdow"></h3>
                                    <p>Online Action</p>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>0,01</h3>
                                    <p>Bước Giá</p>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->

                        <!-- fix for small devices only -->
                        <div class="clearfix visible-sm-block"></div>

                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3 class="usd-amount">0,03</h3>
                                    <p>Giá</p>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3 class="totalOrderInDay">{{ $totalOrderInDay }}</h3>
                                    <p>Volume Auction Order</p>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3 class="totalValueOrderInDay">{{ $totalValueOrderInday }}</h3>
                                    <p>Volume Coin Order</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="panel panel-default">
                        <h4 class="card-title">Order form</h4>
                        <form action="" class="form" id="orderForm">
                            <div class="form-group m-t-40 row">
                                <label for="amount" class="col-2 col-form-label">Amount</label>
                                <div class="col-10">
                                    <input class="form-control" type="number"
                                           value="0"
                                           name="amount"
                                           id="amount"
                                           autofocus="autofocus"
                                           min="0"
                                           required
                                    >
                                </div>
                            </div>
                            <div class="form-group m-t-40 row">
                                <label for="price" class="col-2 col-form-label">Price</label>
                                <div class="col-10">
                                    <input class="form-control"
                                           name="price"
                                           type="number"
                                           value="0"
                                           id="price"
                                           min="0.3"
                                           step="0.01"
                                           required
                                    >
                                </div>
                            </div>
                            <div class="form-group m-t-40 row">
                                <label for="total" class="col-2 col-form-label">Total</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" value="" id="total" disabled>
                                </div>
                            </div>
                            <button type="submit" id="order" class="btn btn-success waves-effect waves-light m-r-10">Order</button>
                            <button type="reset" class="btn btn-inverse waves-effect waves-light">Refresh</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="panel panel-default">
                        <h4 class="card-title">Order History</h4>
                        <table id="history-grid"  cellpadding="0" cellspacing="0" border="0" class="table display" width="100%" >
                            <thead>
                                <tr>
                                    <th>Amount</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Ngày</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6" >
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Command</h4>
                    <table id="employee-grid"  cellpadding="0" cellspacing="0" border="0" class="table display" width="100%" >
                        <thead>
                        <tr>
                            <th>Amount</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        @foreach($dataTableRealTime as $data)
                            <tr>
                                <td>{{ $data->amount }}</td>
                                <td>{{ $data->price }}</td>
                                <td>{{ $data->total }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Trade Market</h4>
                    <table id="market-grid"  cellpadding="0" cellspacing="0" border="0" class="table display" width="100%" >
                        <thead>
                        <tr>
                            <th>Amount</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Ngày</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#employee-grid').DataTable({
                "order": [[ 1, 'desc' ]],
                "searching":false,
                "bLengthChange": false,
                paging: false
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
                               if( $('#total').val() == 0){
                                   swal ( "Oops" ,  "Not order , Total Value must great 0  !" ,  "error" )
                                   return false;
                               };
                               if( $('#amount').val() == ''){
                                   swal ( "Oops" ,  "Not order , please fill amount !" ,  "error" )
                                   return false;
                               }

                               if( $('#price').val() == ''){
                                   swal ( "Oops" ,  "Not order , please fill price !" ,  "error" )
                                   return false;
                               }

                               if( parseFloat($('#price').val()) < 0.3 ){
                                   swal ( "Oops" ,  "Not order , min price 0.3 !" ,  "error" )
                                   return false;
                               }
                           },
                           url : "{{ URL::to('/order') }}",
                           type : "post",
//                    dataType:"text",
                           data : {
                               _token : "{{ csrf_token() }}",
                               amount : $('#amount').val(),
                               price  : $('#price').val()
                           },
                           success : function (result){
                               swal ( "Done!" ,  "Order success" ,  "success" );
                               dataTableHistory.ajax.reload();
                           },
                           error: function(xhr) { // if error occured
                               swal ( "Oops" ,  "Not order , please come back later !" ,  "error" )
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
                "aaSorting": [],
//                "orderMulti": true,
//                "ordering": true,
                "searching": false,
                "ajax":{
                    url :"gethistorydatatrademarket", // json datasource
                    type: "get",  // method  , by default get
                    error: function(){  // error handling
                        $(".market-grid-error").html("");
                        $("#market-grid").append('<tbody class="market-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
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
                "order": [[ 3, "desc" ],[ 1, "desc" ]],
                "searching": false,
                "ajax":{
                    url :"gethistorydataorder", // json datasource
                    type: "get",  // method  , by default get
                    error: function(){  // error handling
                        $(".history-grid-error").html("");
                        $("#history-grid").append('<tbody class="history-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#history-grid_processing").css("display","none");
                    },
                    complete : function (dataTableHistory) {

                    }
                }
            } );

            var socket = io.connect('http://test-csc.site:6378');
            socket.on('message', function (data) {
                var result = JSON.parse(data);
                $(".totalOrderInDay").html(result.totalOrderInDay);
                $(".totalValueOrderInDay").html(result.totalValueOrderInday);
                $('#employee-grid tbody').html(result.html);
            });

            $('#amount').on('keyup change mousewheel', function() {
                $('#total').val($(this).val()*$("#price").val());
            });
            $('#price').on('keyup change mousewheel', function() {
                $('#total').val($(this).val()*$("#amount").val());
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
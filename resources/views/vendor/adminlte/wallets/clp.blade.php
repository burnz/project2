@extends('adminlte::layouts.backend') @section('content')
<style type="text/css">
    .help-block{
        display:block !important;
    }
    .trans:hover{
        text-decoration: underline;;
    }
</style>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card" section="wallet-panel">
                    <div class="card-header">
                        <h3 class="card-title text-center" style="position: relative;">
                            My Wallet
                        </h3>
                    </div>
                    <div class="card-content">
                        <div class="nav-center">
                            <ul class="nav nav-pills nav-pills-primary nav-pills-icons" role="tablist">
                                <li class="active">
                                    <a href="panels.html#pill2" role="tab" data-toggle="tab">
                                        <i class="material-icons" icon="img" size="lg"><img
                                                src="/Carcoin/img/ic_zcoin-pri.svg"></i> Carcoin Wallet
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="pill2">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-6 justify-content-center text-center">
                                        @if ( session()->has("errorMessage") )
                                            <div class="alert alert-warning">
                                                <h4>Warning!</h4>
                                                <p>{!! session("errorMessage") !!}</p>
                                            </div>
                                            {{ session()->forget('errorMessage') }}
                                        @elseif ( session()->has("successMessage") )
                                            <div class="alert alert-success">
                                                <h4>Success</h4>
                                                <p>{!! session("successMessage") !!}</p>
                                            </div>
                                            {{ session()->forget('successMessage') }}
                                        @else
                                            <div></div>
                                        @endif

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-12 d-flex justify-content-center mb-3" user-wallet>
                                        <div class="user-wallet">
                                            <div>
                                                <div class="left">
                                                    <i class="material-icons" icon="img" size="lg"><img src="/Carcoin/img/ic_zcoin-pri.svg"></i>
                                                </div>
                                                <div class="right">
                                                    <span>Your Balance</span>
                                                    <div class="content carcoin-color">
                                                    {{ number_format($walletAmount['amountCLP'], 5) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="align-self-center">  
                                            <button class="btn btn-thirdary btn-round" data-toggle="modal" data-target="#carcoin-deposit" id ="btnDeposit">
                                                <span class="btn-label">
                                                    <i class="material-icons">shop</i>
                                                                        </span> Deposit
                                                <div class="ripple-container"></div>
                                            </button>
                                            <!-- <button class="btn btn-thirdary btn-round" data-toggle="modal" data-target="#carcoin-withdraw" id="btnWithdraw">
                                                <span class="btn-label">
                                                    <i class="material-icons reflect">shop</i>
                                                                        </span> Withdraw
                                                <div class="ripple-container"></div>
                                            </button> -->
                                            <button id="btnTransfer" class="btn btn-thirdary btn-round" data-toggle="modal" data-target="#carcoin-transfer">
                                                <span class="btn-label">
                                                    <i class="material-icons">swap_horiz</i>
                                                                        </span> Transfer
                                                <div class="ripple-container"></div>
                                            </button>
                                            <!-- <button id="btnConvert" class="btn btn-thirdary btn-round" data-toggle="modal" data-target="#carcoin-convert">
                                                <span class="btn-label">
                                                    <i class="material-icons">swap_horiz</i>
                                                                        </span> Convert to BTC
                                                <div class="ripple-container"></div>
                                            </button> -->
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card-content p-0">    
                                            <div class="card-filter clearfix">
                                                <div class="col-md-4">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Select Type</label>
                                                        {{ Form::select('wallet_type', $wallet_type, ($requestQuery && isset($requestQuery['type']) ? $requestQuery['type'] : 0), ['class' => 'form-control', 'id' => 'wallet_type']) }}
                                                    <span class="material-input"></span></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-primary btn-round" id="btn_filter">Filter</button>
                                                    <button type="button" class="btn btn-outline-primary btn-round" id="btn_filter_clear">Clear</button>
                                                </div>
                                            </div>                                        
                                            <div class="clearfix"></div>
                                            <!-- <h4 class="card-title">Command</h4> -->

                                            <div class="material-datatables table-responsive">
                                                <table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%;">
                                                    <thead class="text-thirdary">
                                                        <th style="width: 20%;">Date/Time</th>
                                                        <th>Type</th>
                                                        <th>In</th>
                                                        <th>Out</th>
                                                        <th>Info</th>
                                                        <th width="30%">Transaction</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($wallets as $wallet)
                                                            <tr>

                                                                <td>
                                                                    {{ $wallet->created_at }}
                                                                </td>
                                                                <td>{{ $wallet_type && isset($wallet_type[$wallet->type]) ? $wallet_type[$wallet->type] : '' }}</td>
                                                                <td>
                                                                    @if($wallet->inOut=='in')
                                                                        +{{ number_format($wallet->amount, 2) }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($wallet->inOut=='out')
                                                                        -{{ number_format($wallet->amount, 2) }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    {{ $wallet->note }}
                                                                </td>
                                                                <td class="trans" width = "50" style="text-overflow: ellipsis; overflow: hidden">
                                                                    @if($wallet->type == 10 && $wallet->created_at > '2018-07-20')
                                                                    <a href="https://etherscan.io/tx/{{ $wallet->withdraws->transaction_hash }}" target="_blank" title="{{ $wallet->withdraws->transaction_hash }}">{{ str_limit($wallet->withdraws->transaction_hash, 30) }}</a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="text-center">
                                                    {{ $wallets->links() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="carcoin-deposit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="material-icons">close</i> </button>
                <h4 class="modal-title" id="myModalLabel6">Deposit to your wallet</h4>
            </div>
            <div class="modal-body">
                <div class="row d-flex" wallet-deposit>
                    <div class="col-md-7 text-center align-self-center">
                        <h5>Your Carcoin Wallet address</h5>
                        <input type="text" class="form-control" readonly="true" id="wallet-address" value="{{$walletAddress}}">
                        @if(empty($walletAddress))
                        <button class="btn btn-primary btn-round get-wallet">Generate
                            <div class="ripple-container"></div>
                        </button>
                        @endif
                        <button class="btn btn-primary btn-round btnwallet-address" data-clipboard-target="#wallet-address" title="" data-original-title="Copied!"> <span class="btn-label"> <i class="material-icons">content_copy</i> </span> Copy
                            <div class="ripple-container"></div>
                        </button>
                    </div>
                    <div class="col-md-5 text-center">
                        <!-- Trigger -->
                        <h5>Carcoin Wallet link</h5>
                        <a href="https://blockchain.info/address/{{$walletAddress}}" target="_blank">blockchain</a>, <a href="https://blockexplorer.com/address/{{$walletAddress}}" target="_blank">blockexplorer</a>
                        <center>
                            <div id="qrcode"></div>
                        </center>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="carcoin-withdraw" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="material-icons">close</i> </button>
                <h4 class="modal-title" id="myModalLabel7">Withdraw - <b class="carcoin-color" style="vertical-align: bottom;"><img src="/Carcoin/img/ic_zcoin-pri.svg" style="width: 24px;">{{ number_format($walletAmount['amountCLP'], 5) }}</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group form-group"> <span class="input-group-addon"> <img src="/Carcoin/img/ic_zcoin-pri.svg" style="width: 24px;"> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">Carcoin Amount</label>
                                <input type="number" class="form-control" id="withdrawAmount" name="withdrawAmount">
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="input-group form-group"> <span class="input-group-addon"> <i class="material-icons">assignment_ind</i> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">Ethereum address E.g. 0x8f2b05ec6786358e14ace5d4c01d7ee7bf27</label>
                                <input type="text" class="form-control" id="walletAddress" name="walletAddress">
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="input-group form-group"> <span class="input-group-addon"> <i class="material-icons">vpn_key</i> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">2FA code E.g. 123456</label>
                                <input type="number" class="form-control" id="withdrawOTP" name="withdrawOPT">
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group pull-right">
                            <label>{{ trans("adminlte_lang::wallet.fee") }}: <b>{{ config("app.fee_withRaw_CLP")}}</b></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-round" id="withdraw-car">Submit</button>
                <button type="button" class="btn btn-outline-primary btn-round" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="carcoin-transfer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="material-icons">close</i> </button>
                <h4 class="modal-title" id="myModalLabel8">Transfer - <b class="carcoin-color" style="vertical-align: bottom;"><img src="/Carcoin/img/ic_zcoin-pri.svg" style="width: 24px;">{{ number_format($walletAmount['amountCLP'], 5) }}</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group form-group"> <span class="input-group-addon"> <img src="/Carcoin/img/ic_zcoin-pri.svg" style="width: 24px;"> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">Carcoin Amount</label>
                                <input type="number" class="form-control" id="carAmount" name="carAmount">
                                <p class="help-block"></p>
                            </div>
                        </div>

                        <div class="input-group form-group"> <span class="input-group-addon"> <i class="material-icons">person</i> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">User</label>
                                <input type="text" class="form-control" id="carUsername" name="carUsername">
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="input-group form-group"> <span class="input-group-addon"> <i class="material-icons">assignment_ind</i> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">ID</label>
                                <input type="number" class="form-control" id="carUid" name="carUid">
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="input-group form-group"> <span class="input-group-addon"> <i class="material-icons">vpn_key</i> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">2FA code E.g. 123456</label>
                                <input type="number" class="form-control" id="carOTP" name="carOTP">
                                <p class="help-block"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="car-tranfer" class="btn btn-primary btn-round">Submit</button>
                <button type="button" class="btn btn-outline-primary btn-round" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="carcoin-convert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="material-icons">close</i> </button>
                <h4 class="modal-title" id="myModalLabel8">Transfer - <b class="carcoin-color" style="vertical-align: bottom;"><img src="/Carcoin/img/ic_zcoin-pri.svg" style="width: 24px;">{{ number_format($walletAmount['amountCLP'], 5) }}</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group form-group"> <span class="input-group-addon"> <img src="/Carcoin/img/ic_zcoin-pri.svg" style="width: 24px;"> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">Carcoin Amount</label>
                                <input type="number" class="form-control switch-CAR-to-BTC" id="carConvert" name="carConvert">
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <span class="input-group-addon"> <img src="/Carcoin/img/bitcoin-symbol.svg" style="width: 24px;"> </span>
                            <div class="form-group label-floating">
                                <input type="number" class="form-control switch-BTC-to-CAR" id="btcAmount" name="btcAmount" readonly>
                                <p class="help-block"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="car-convert" class="btn btn-primary btn-round">Submit</button>
                <button type="button" class="btn btn-outline-primary btn-round" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="{{asset('Carcoin/js/jquery.qrcode.min.js')}}"></script>
    <script src="{{asset('Carcoin/js/clipboard.min.js')}}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){

            $('#btnTransfer').click(function(){
                if ( window.iOS && window.iOS11 ) {
                    window.location.href='{{URL::to("wallets/car/itransfer")}}';
                    return false;
                }
            });
            $('#btnWithdraw').click(function(){
                if ( window.iOS && window.iOS11 ) {
                    window.location.href='{{URL::to("wallets/car/iwithdraw")}}';
                    return false;
                }
            });
            $('#btnDeposit').click(function(){
                if ( window.iOS && window.iOS11 ) {
                    window.location.href='{{URL::to("wallets/car/ideposit")}}';
                    return false;
                }
            });

            var mytimer;
            var packageId = {{ Auth::user()->userData->packageId }};
            var packageIdPick = packageId;
            var qrcode = $("#qrcode").qrcode({
                    width: 180,
                    height: 180,
                    text: '{{ $walletAddress }}',
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    //correctLevel: qrcode.CorrectLevel.H
                });
            $('.btnwallet-address').tooltip({
                trigger: 'click',
                placement: 'bottom'
            });
            
            function setTooltip(message) {
                $('.btnwallet-address')
                  .attr('data-original-title', message)
                  .tooltip('show');
            }
            
            function hideTooltip() {
                setTimeout(function() {
                  $('button').tooltip('hide');
                }, 1000);
              }
            
            var clipboard = new Clipboard('.btnwallet-address');
            clipboard.on('success', function(e) {
                e.clearSelection();
                setTooltip('Copied!');
                hideTooltip();
            });
            //get address wallet
            $(".get-wallet").click(function(){
                $(".get-wallet").attr("disabled", "disabled");
                var $this = $(this);
                $this.button('loading');
                $.get("{{URL::to('wallets/car/getaddresswallet')}}", function(data, status){
                    if (data.err){
                        alert("{{trans('adminlte_lang::wallet.not_get_address_clp_wallet')}}");
                        $this.button('reset');
                        $(".get-wallet").removeAttr("disabled");
                    }else{
                        $("#wallet-address").val(data.data);
                        $(".get-wallet").hide();
                    }
                }).fail(function () {
                    console.log("Error response!")
                });
            });
            
            $('#withdraw-car').on('click', function () {
                var withdrawAmount = $('#withdrawAmount').val();
                var walletAddress = $('#walletAddress').val();
                var withdrawOTP = $('#withdrawOTP').val();
                if($.trim(withdrawAmount) == ''){
                    $("#withdrawAmount").parents("div.form-group").addClass('has-error');
                    $("#withdrawAmount").parents("div.form-group").find('.help-block').text("{{trans('adminlte_lang::wallet.amount_required')}}");
                }else{
                    $("#withdrawAmount").parents("div.form-group").removeClass('has-error');
                    $("#withdrawAmount").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(walletAddress) == ''){
                    $("#walletAddress").parents("div.form-group").addClass('has-error');
                    $("#walletAddress").parents("div.form-group").find('.help-block').text("Ethereum Address is required");
                }else{
                    if(/^(0x)?[0-9a-fA-F]{40}$/.test(walletAddress) == false) {
                        $("#walletAddress").parents("div.form-group").addClass('has-error');
                        $("#walletAddress").parents("div.form-group").find('.help-block').text("Ethereum Address is not valid");
                    } else {
                        $("#walletAddress").parents("div.form-group").removeClass('has-error');
                        $("#walletAddress").parents("div.form-group").find('.help-block').text('');
                    }
                }
                    
                
                if($.trim(withdrawOTP) == ''){
                    $("#withdrawOTP").parents("div.form-group").addClass('has-error');
                    $("#withdrawOTP").parents("div.form-group").find('.help-block').text("{{trans('adminlte_lang::wallet.otp_required')}}");
                }else{
                    $("#withdrawOTP").parents("div.form-group").removeClass('has-error');
                    $("#withdrawOTP").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(withdrawAmount) != '' && $.trim(walletAddress) != '' && $.trim(withdrawOTP) != ''){
                    $('#withdraw-car').attr('disabled', true);
                    $.ajax({
                        method : 'POST',
                        url: "{{ url('wallets/car/withdraw') }}",
                        data: {withdrawAmount: withdrawAmount, walletAddress: walletAddress, withdrawOTP: withdrawOTP,_token:'{{ csrf_token() }}'}
                    }).done(function (data) {
                        if (data.err) {
                            if(typeof data.msg !== undefined){
                                if(data.msg.withdrawAmountErr !== '') {
                                    $("#withdrawAmount").parents("div.form-group").addClass('has-error');
                                    $("#withdrawAmount").parents("div.form-group").find('.help-block').text(data.msg.withdrawAmountErr);
                                }else {
                                    $("#withdrawAmount").parents("div.form-group").removeClass('has-error');
                                    $("#withdrawAmount").parents("div.form-group").find('.help-block').text('');
                                }
                                if(data.msg.walletAddressErr !== '') {
                                    $("#walletAddress").parents("div.form-group").addClass('has-error');
                                    $("#walletAddress").parents("div.form-group").find('.help-block').text(data.msg.walletAddressErr);
                                }else {
                                    $("#walletAddress").parents("div.form-group").removeClass('has-error');
                                    $("#walletAddress").parents("div.form-group").find('.help-block').text('');
                                }
                                if(data.msg.withdrawOTPErr !== '') {
                                    $("#withdrawOTP").parents("div.form-group").addClass('has-error');
                                    $("#withdrawOTP").parents("div.form-group").find('.help-block').text(data.msg.withdrawOTPErr);
                                }else {
                                    $("#withdrawOTP").parents("div.form-group").removeClass('has-error');
                                    $("#withdrawOTP").parents("div.form-group").find('.help-block').text('');
                                }
                                $('#withdraw-car').attr('disabled', false);
                            }
                        } else {
                            $('#tranfer').modal('hide');
                            location.href = '{{ url()->current() }}';
                        }
                    }).fail(function () {
                        $('#withdraw-car').attr('disabled', false);
                        $('#tranfer').modal('hide');
                        swal("Some things wrong!");
                    });
                }
            });
            
            
            $('#carUsername').on('blur onmouseout onfocusout keyup', function () {
                clearTimeout(mytimer);
                var search = $(this).val();
                if(search.length >= 3){
                    mytimer = setTimeout(function(){
                        $('#carUid').parents("div.form-group").find('.fa-id-card-o').remove();
                        $('#carUid').parents("div.form-group").find('.input-group-addon').append('<i class="fa fa-spinner"></i>');
                        $.ajax({
                            type: "GET",
                            url: "/users/search",
                            data: {username : search}
                        }).done(function(data){
                            $('#carUid').parents("div.form-group").find('.fa-spinner').remove();
                            $('#carUid').parents("div.form-group").find('.input-group-addon').append('<i class="fa fa-id-card-o"></i>');
                            if(data.err) {
                                $("#carUsername").parents("div.form-group").addClass('has-error');
                                $("#carUsername").parents("div.form-group").find('.help-block').text(data.err);
                                $('#carUid').val('');
                            }else{
                                $('#carUsername').parents("div.form-group").removeClass('has-error');
                                $("#carUsername").parents("div.form-group").find('.help-block').text('');
                                $('#carUid').parents("div.form-group").removeClass('has-error');
                                $('#carUid').parents("div.form-group").find('.help-block').text('');
                                $('#carUid').val(data.id);
                                $('#carUid').trigger('change');
                            }
                        }).fail(function (){
                            $('#tranfer').modal('hide');
                            swal("Some things wrong!");
                        });
                    }, 1000);
                }
            });
            $('#car-tranfer').on('click', function () {
                var carAmount = $('#carAmount').val();
                var carUsername = $('#carUsername').val();
                var carOTP = $('#carOTP').val();
                var carUid = $('#carUid').val();
                if($.trim(carAmount) == ''){
                    $("#carAmount").parents("div.form-group").addClass('has-error');
                    $("#carAmount").parents("div.form-group").find('.help-block').text("{{trans('adminlte_lang::wallet.amount_required')}}");
                }else{
                    $("#carAmount").parents("div.form-group").removeClass('has-error');
                    $("#carAmount").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(carUsername) == ''){
                    $("#carUsername").parents("div.form-group").addClass('has-error');
                    $("#carUsername").parents("div.form-group").find('.help-block').text("{{ trans('adminlte_lang::wallet.username_required') }}");
                }else{
                    $("#carUsername").parents("div.form-group").removeClass('has-error');
                    $("#carUsername").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(carUid) == ''){
                    $("#carUid").parents("div.form-group").addClass('has-error');
                    $("#carUid").parents("div.form-group").find('.help-block').text("{{trans('adminlte_lang::wallet.uid_required')}}");
                }else{
                    $("#carUid").parents("div.form-group").removeClass('has-error');
                    $("#carcarUid").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(carOTP) == ''){
                    $("#carOTP").parents("div.form-group").addClass('has-error');
                    $("#carOTP").parents("div.form-group").find('.help-block').text("{{trans('adminlte_lang::wallet.otp_required')}}");
                }else{
                    $("#carOTP").parents("div.form-group").removeClass('has-error');
                    $("#carOTP").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(carAmount) != '' && $.trim(carUsername) != '' && $.trim(carOTP) != ''){
                    $.ajax({
                        url: "{{ url('wallets/car/transfer') }}",
                        data: {carAmount: carAmount, carUsername: carUsername, carOTP: carOTP, carUid: carUid}
                    }).done(function (data) {
                        if (data.err) {
                            if(typeof data.msg !== undefined){
                                if(data.msg.carAmountErr !== '') {
                                    $("#carAmount").parents("div.form-group").addClass('has-error');
                                    $("#carAmount").parents("div.form-group").find('.help-block').text(data.msg.carAmountErr);
                                }else {
                                    $("#carAmount").parents("div.form-group").removeClass('has-error');
                                    $("#carAmount").parents("div.form-group").find('.help-block').text('');
                                }
                                if(data.msg.carUsernameErr !== '') {
                                    $("#carUsername").parents("div.form-group").addClass('has-error');
                                    $("#carUsername").parents("div.form-group").find('.help-block').text(data.msg.carUsernameErr);
                                }else {
                                    if(data.msg.transferRuleErr !== '') {
                                        $("#carUsername").parents("div.form-group").addClass('has-error');
                                        $("#carUsername").parents("div.form-group").find('.help-block').text(data.msg.transferRuleErr);
                                    } else {
                                        $("#carUsername").parents("div.form-group").removeClass('has-error');
                                        $("#carUsername").parents("div.form-group").find('.help-block').text('');
                                    }
                                }
                                if(data.msg.carUidErr !== '') {
                                    $("#carUid").parents("div.form-group").addClass('has-error');
                                    $("#carUid").parents("div.form-group").find('.help-block').text(data.msg.carUidErr);
                                }else {
                                    $("#carUid").parents("div.form-group").removeClass('has-error');
                                    $("#carUid").parents("div.form-group").find('.help-block').text('');
                                }
                                if(data.msg.carOTPErr !== '') {
                                    $("#carOTP").parents("div.form-group").addClass('has-error');
                                    $("#carOTP").parents("div.form-group").find('.help-block').text(data.msg.carOTPErr);
                                }else {
                                    $("#carOTP").parents("div.form-group").removeClass('has-error');
                                    $("#carOTP").parents("div.form-group").find('.help-block').text('');
                                }
                            }
                        } else {
                            $('#tranfer').modal('hide');
                            location.href = '{{ url()->current() }}';
                        }
                    }).fail(function () {
                        $('#tranfer').modal('hide');
                        swal("Some things wrong!");
                    });
                }
            });
            $('#car-convert').on('click', function () {
                var carConvert = $('#carConvert').val();
                var btcAmount = $('#btcAmount').val();

                if($.trim(carConvert) == ''){
                    $("#carConvert").parents("div.form-group").addClass('has-error');
                    $("#carConvert").parents("div.form-group").find('.help-block').text("{{trans('adminlte_lang::wallet.amount_required')}}");
                }else{
                    $("#carConvert").parents("div.form-group").removeClass('has-error');
                    $("#carConvert").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(btcAmount) == ''){
                    $("#btcAmount").parents("div.form-group").addClass('has-error');
                    $("#btcAmount").parents("div.form-group").find('.help-block').text("BTC Amount is required");
                }else{
                    $("#btcAmount").parents("div.form-group").removeClass('has-error');
                    $("#btcAmount").parents("div.form-group").find('.help-block').text('');
                }
                
                if($.trim(carConvert) != '' && $.trim(btcAmount) != ''){
                    $.ajax({
                        url: "{{ url('wallets/car/convert') }}",
                        data: {carConvert: carConvert}
                    }).done(function (data) {
                        if (data.err) {
                            if(typeof data.msg !== undefined){
                                if(data.msg.carConvertErr !== '') {
                                    $("#carConvert").parents("div.form-group").addClass('has-error');
                                    $("#carConvert").parents("div.form-group").find('.help-block').text(data.msg.carConvertErr);
                                }else {
                                    $("#carConvert").parents("div.form-group").removeClass('has-error');
                                    $("#carConvert").parents("div.form-group").find('.help-block').text('');
                                }
                            }
                        } else {
                            $('#tranfer').modal('hide');
                            location.href = '{{ url()->current() }}';
                        }
                    }).fail(function () {
                        $('#tranfer').modal('hide');
                        swal("Some things wrong!");
                    });
                }
            });

            $(".switch-CAR-to-BTC").on('keyup change mousewheel', function () {
                var value = $(this).val();
                var result = value * globalCARBTC;
                $(".switch-BTC-to-CAR").val(result.toFixed(5));
            });

            //filter
            $('#btn_filter').on('click', function () {
                var wallet_type = parseInt($('#wallet_type option:selected').val());
                if (wallet_type > 0) {
                    location.href = '{{ url()->current() }}?type=' + wallet_type;
                } else {
                    alert('Please choose a type!');
                    return false;
                }
            });
            $('#btn_filter_clear').on('click', function () {
                location.href = '{{ url()->current() }}';
            });
        });
    </script>
@endsection
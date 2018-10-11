@extends('adminlte::layouts.backend')
@section('content')
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
                                    <a href="panels.html#pill1" role="tab" data-toggle="tab">
                                        <i class="material-icons" icon="img" size="lg"><img src="/Carcoin/img/bitcoin-symbol.svg"></i> Bitcoin Wallet
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="pill1">
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
                                            <div class="left">
                                                <i class="material-icons" icon="img" size="lg"><img
                                                        src="/Carcoin/img/bitcoin-symbol.svg"></i>
                                            </div>
                                            <div class="right">
                                                <span>Your Balance</span>
                                                <div class="content bitcoin-color">
                                                {{ number_format($walletAmount['amountBTC'], 5) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="align-self-center">
                                            <button id="btnDeposit" class="btn btn-thirdary btn-round" data-toggle="modal"
                                                    data-target="#bitcoin-deposit">
                                                    <span class="btn-label">
                                                        <i class="material-icons">shop</i>
                                                    </span> Deposit
                                                <div class="ripple-container"></div>
                                            </button>
                                            <button id="btnTransferToCSC" class="btn btn-thirdary btn-round" data-toggle="modal"
                                                    data-target="#bitcoin-csc">
                                                    <span class="btn-label">
                                                        <i class="material-icons reflect">swap_horiz</i>
                                                    </span> Transfer to Jackpot
                                                <div class="ripple-container"></div>
                                            </button>
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
                                            <div class="table-responsive">
                                                <table class="table" id="tbBTC" cellspacing="0" width="100%" style="width:100%">
                                                    <thead class="text-thirdary">
                                                        <th>{{ trans('adminlte_lang::wallet.wallet_no') }}</th>
                                                        <th>{{ trans('adminlte_lang::wallet.wallet_date') }}</th>
                                                        <th>{{ trans('adminlte_lang::wallet.wallet_type') }}</th>
                                                        <th>{{ trans('adminlte_lang::wallet.wallet_in') }}</th>
                                                        <th>{{ trans('adminlte_lang::wallet.wallet_out') }}</th>
                                                        <th>{{ trans('adminlte_lang::wallet.wallet_info') }}</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($wallets as $key => $wallet)
                                                            <tr>
                                                                <td>{{ $key+1 }}</td>
                                                                <td>{{ $wallet->created_at }}</td>
                                                                <td>{{ $wallet_type && isset($wallet_type[$wallet->type]) ? $wallet_type[$wallet->type] : '' }}</td>
                                                                <td>
                                                                    @if($wallet->inOut=='in')
                                                                        +{{ number_format($wallet->amount, 6) }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($wallet->inOut=='out')
                                                                        -{{ number_format($wallet->amount, 6) }}
                                                                    @endif
                                                                </td>
                                                                <td>{{ $wallet->note }}</td>
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

@include('adminlte::wallets.wallet-modal')
@endsection

@section('script')
<script src="{{asset('Carcoin/js/jquery.qrcode.min.js')}}"></script>
<script src="{{asset('Carcoin/js/clipboard.min.js')}}"></script>
<script type="text/javascript">
    $('#btnDeposit').on('click',function(){
        if ( window.iOS && window.iOS11 ) {
            window.location.href='{{URL::to("wallets/btc/ideposit")}}';
            return false;
        }
    });

    $('#btnWithdraw').on('click',function(){
        if ( window.iOS && window.iOS11 ) {
            window.location.href='{{URL::to("wallets/btc/iwithdraw")}}';
            return false;
        }
    });

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


            //withdraw action
            $('#btn-withdraw-btc').on('click', function () {
                var btcAmount = $('#withdraw-btc-amount').val();
                var address = $('#withdraw-address').val();
                var btcOTP = $('#withdraw-otp').val();
                if($.trim(btcAmount) == ''){
                    $("#withdraw-btc-amount").parents("div.form-group").addClass('has-error');
                    $("#withdraw-btc-amount").parents("div.form-group").find('.help-block').text('The Amount field is required');
                }else{
                    $("#withdraw-btc-amount").parents("div.form-group").removeClass('has-error');
                    $("#withdraw-btc-amount").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(address) == ''){
                    $("#withdraw-address").parents("div.form-group").addClass('has-error');
                    $("#withdraw-address").parents("div.form-group").find('.help-block').text('The Username field is required');
                }else{
                    $("#withdraw-address").parents("div.form-group").removeClass('has-error');
                    $("#withdraw-address").parents("div.form-group").find('.help-block').text('');
                }
                
                if($.trim(btcOTP) == ''){
                    $("#withdraw-otp").parents("div.form-group").addClass('has-error');
                    $("#withdraw-otp").parents("div.form-group").find('.help-block').text('The OTP field is required');
                }else{
                    $("#withdraw-otp").parents("div.form-group").removeClass('has-error');
                    $("#withdraw-otp").parents("div.form-group").find('.help-block').text('');
                }

                if($.trim(btcAmount) != '' && $.trim(address) != '' && $.trim(btcOTP) != ''){
                    $('#btn-withdraw-btc').attr('disabled', true);
                    $('#form-withdraw-btc').submit();
                }
            });

            //end withdraw action

            $('#tbBTC').DataTable({
                "ordering": false,
                "searching":false,
                "bLengthChange": false,
            });
            
            //fillter grid
            $('#btn_filter').on('click', function () {
                var wallet_type = parseInt($('#wallet_type option:selected').val());
                if(wallet_type > 0){
                    location.href = '{{ url()->current() }}?type='+wallet_type;
                }else{
                    swal("Please choose a type!");
                    return false;
                }
            });
            $('#btn_filter_clear').on('click', function () {
                location.href = '{{ url()->current() }}';
            });

</script>
@stop
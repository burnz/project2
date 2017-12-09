<!-- Bitcoin Wallet -->
<!-- <script src="{{ URL::to("js/qrcode.min.js") }}"></script> -->
@if(isset($walletAddress))
<div class="modal fade" id="bitcoin-deposit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="material-icons">close</i> </button>
                <h4 class="modal-title" id="myModalLabel1">Deposit to your wallet</h4>
            </div>
            <div class="modal-body">
                <div class="row d-flex" wallet-deposit>
                    <div class="col-md-7 text-center align-self-center">
                        <h5>Your BTC Wallet address</h5>
                        <input type="text" value="{{ $walletAddress }}" id="wallet-address" class="form-control wallet-address" readonly="true">
                        <button class="btn btn-primary btn-round btnwallet-address" data-clipboard-target="#wallet-address" title="copy"> <span class="btn-label"> <i class="material-icons">content_copy</i> </span> Copy
                            <div class="ripple-container"></div>
                        </button>
                    </div>
                    <div class="col-md-5 text-center">
                        <!-- Trigger -->
                        <h5>BTC Wallet link</h5>
                        <a href="https://blockchain.info/address/{{ $walletAddress }}" target="_blank">blockchain</a>, <a href="https://blockexplorer.com/address/{{ $walletAddress }}" target="_blank">blockexplorer</a>
                        <center>
                            <div id="qrcode" style="padding-bottom: 10px;"></div>
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
@endif
{!! Form::open(array('url' => 'wallets/btcwithdraw', 'id' => 'form-withdraw-btc')) !!}
<div class="modal fade" id="bitcoin-withdraw" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="material-icons">close</i> </button>
                <h4 class="modal-title" id="myModalLabel2">Withdraw - <b class="bitcoin-color" style="vertical-align: bottom;"><img src="/Carcoin/img/bitcoin-symbol.svg" style="width: 24px;">{{ number_format($walletAmount['amountBTC'], 5) }}</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group form-group"> <span class="input-group-addon"> <img src="/Carcoin/img/bitcoin-symbol.svg" style="width: 24px;"> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">BTC Amount</label>
                                <input type="number" class="form-control btcwithdraw" value id="withdraw-btc-amount" name="withdrawAmount">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="input-group form-group"> <span class="input-group-addon"> <i class="material-icons">assignment_ind</i> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">Bitcoin Address</label>
                                <input type="text" class="form-control" value id="withdraw-address" name="walletAddress">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="input-group form-group"> <span class="input-group-addon"> <i class="material-icons">vpn_key</i> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">2FA Code E.g. 123456</label>
                                <input type="number" class="form-control" value id="withdraw-otp" name="withdrawOPT">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group pull-right">
                            <label>{{ trans("adminlte_lang::wallet.fee") }}: <b>{{ config("app.fee_withRaw_BTC")}}</b></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-round" id="btn-withdraw-btc">{{trans('adminlte_lang::default.submit')}}</button>
                <button type="button" class="btn btn-outline-primary btn-round" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}


<div class="modal fade" id="bitcoin-buy-carcoin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="material-icons">close</i> </button>
                <h4 class="modal-title" id="myModalLabel3">Buy Carcoin - <b class="bitcoin-color" style="vertical-align: bottom;"><img src="/Carcoin/img/bitcoin-symbol.svg" style="width: 24px;">314,675</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group form-group"> <span class="input-group-addon"> <img src="/Carcoin/img/bitcoin-symbol.svg" style="width: 24px;"> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">BTC Amount</label>
                                <input type="text" class="form-control" value>
                            </div>
                        </div>
                        <div class="input-group form-group"> <span class="input-group-addon"> <img src="/Carcoin/img/ic_zcoin-pri.svg" style="width: 24px;"> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">Carcoin Amount</label>
                                <input type="text" class="form-control" value>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-round">Submit</button>
                <button type="button" class="btn btn-outline-primary btn-round" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Carcoin Wallet -->
<div class="modal fade" id="carcoin-sell" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="material-icons">close</i> </button>
                <h4 class="modal-title" id="myModalLabel4">Sell Carcoin - <b class="carcoin-color" style="vertical-align: bottom;"><img src="/Carcoin/img/ic_zcoin-pri.svg" style="width: 24px;">0.00000</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group form-group"> <span class="input-group-addon"> <img src="/Carcoin/img/ic_zcoin-pri.svg" style="width: 24px;"> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">Carcoin Amount</label>
                                <input type="text" class="form-control" value>
                            </div>
                        </div>
                        <div class="input-group form-group"> <span class="input-group-addon"> <img src="/Carcoin/img/bitcoin-symbol.svg" style="width: 24px;"> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">BTC Amount</label>
                                <input type="text" class="form-control" value>
                            </div>
                        </div>
                        <div class="form-group pull-right">
                            <label>Fee: <b>0.0004</b></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-round">Submit</button>
                <button type="button" class="btn btn-outline-primary btn-round" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="carcoin-buy-package" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="material-icons">close</i> </button>
                <h4 class="modal-title" id="myModalLabel5">Pick the best package for you</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-pricing">
                            <div class="card-content p-0">
                                <div class="icon"> <i class="material-icons" pack="tiny">brightness_1</i> </div>
                                <h3 class="card-title">TINY</h3>
                                <div class="card-description"> <span><b>$ 1000</b></span> <span class="carcoin-color"><i class="material-icons" icon="carcoin-primary"></i> <b>0.0857</b></span> </div>
                                <div class="card-action">
                                    <div class="radio" big="md">
                                        <label>
                                            <input type="radio" name="optionsRadios">
                                            Choose </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-pricing card-raised">
                            <div class="card-content p-0">
                                <div class="icon active"> <i class="material-icons" pack="small">brightness_1</i> </div>
                                <h3 class="card-title">SMALL</h3>
                                <div class="card-description"> <span><b>$ 1000</b></span> <span class="carcoin-color"><i class="material-icons" icon="carcoin-primary"></i> <b>0.0857</b></span> </div>
                                <div class="card-action">
                                    <div class="radio" big="md">
                                        <label>
                                            <input type="radio" name="optionsRadios">
                                            Choose </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-pricing">
                            <div class="card-content p-0">
                                <div class="icon"> <i class="material-icons" pack="medium">brightness_1</i> </div>
                                <h3 class="card-title">MEDIUM</h3>
                                <div class="card-description"> <span><b>$ 1000</b></span> <span class="carcoin-color"><i class="material-icons" icon="carcoin-primary"></i> <b>0.0857</b></span> </div>
                                <div class="card-action">
                                    <div class="radio" big="md">
                                        <label>
                                            <input type="radio" name="optionsRadios">
                                            Choose </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-pricing">
                            <div class="card-content p-0">
                                <div class="icon"> <i class="material-icons" pack="large">brightness_1</i> </div>
                                <h3 class="card-title">LARGE</h3>
                                <div class="card-description"> <span><b>$ 1000</b></span> <span class="carcoin-color"><i class="material-icons" icon="carcoin-primary"></i> <b>0.0857</b></span> </div>
                                <div class="card-action">
                                    <div class="radio" big="md">
                                        <label>
                                            <input type="radio" name="optionsRadios">
                                            Choose </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox">
                                <a href="/package-term-condition.html" target="_blank">I agree to the terms and condition.</a> </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-round">Submit</button>
                <button type="button" class="btn btn-outline-primary btn-round" data-dismiss="modal">Close</button>
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
                        <input type="text" class="form-control" readonly="true">
                        <button class="btn btn-primary btn-round">Generate
                            <div class="ripple-container"></div>
                        </button>
                        <button class="btn btn-primary btn-round"> <span class="btn-label"> <i class="material-icons">content_copy</i> </span> Copy
                            <div class="ripple-container"></div>
                        </button>
                    </div>
                    <div class="col-md-5 text-center">
                        <!-- Trigger -->
                        <h5>Carcoin Wallet link</h5>
                        <a href="https://blockchain.info/address/admin" target="_blank">blockchain</a>, <a href="https://blockexplorer.com/address/admin" target="_blank">blockexplorer</a>
                        <center>
                            <img src="data:image/png;base64,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" style="display: block;">
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
                <h4 class="modal-title" id="myModalLabel7">Withdraw - <b class="carcoin-color" style="vertical-align: bottom;"><img src="/Carcoin/img/ic_zcoin-pri.svg" style="width: 24px;">0.00000</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group form-group"> <span class="input-group-addon"> <img src="/Carcoin/img/ic_zcoin-pri.svg" style="width: 24px;"> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">Carcoin Amount</label>
                                <input type="text" class="form-control" value>
                            </div>
                        </div>
                        <div class="input-group form-group"> <span class="input-group-addon"> <i class="material-icons">assignment_ind</i> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">Ethereum address E.g. 0xbHB5XMLmzFVj8ALj6mfBsbifRoD4miY36v</label>
                                <input type="text" class="form-control" value>
                            </div>
                        </div>
                        <div class="input-group form-group"> <span class="input-group-addon"> <i class="material-icons">vpn_key</i> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">2FA code E.g. 123456</label>
                                <input type="text" class="form-control" value>
                            </div>
                        </div>
                        <div class="form-group pull-right">
                            <label>Fee: <b>0.0004</b></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-round">Submit</button>
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
                <h4 class="modal-title" id="myModalLabel8">Transfer - <b class="carcoin-color" style="vertical-align: bottom;"><img src="/Carcoin/img/ic_zcoin-pri.svg" style="width: 24px;">0.00000</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group form-group"> <span class="input-group-addon"> <img src="/Carcoin/img/ic_zcoin-pri.svg" style="width: 24px;"> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">Carcoin Amount</label>
                                <input type="text" class="form-control" value>
                            </div>
                        </div>

                        <div class="input-group form-group"> <span class="input-group-addon"> <i class="material-icons">person</i> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">User</label>
                                <input type="text" class="form-control" value>
                            </div>
                        </div>
                        <div class="input-group form-group"> <span class="input-group-addon"> <i class="material-icons">assignment_ind</i> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">ID</label>
                                <input type="text" class="form-control" value>
                            </div>
                        </div>
                        <div class="input-group form-group"> <span class="input-group-addon"> <i class="material-icons">vpn_key</i> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">2FA code E.g. 123456</label>
                                <input type="text" class="form-control" value>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-round">Submit</button>
                <button type="button" class="btn btn-outline-primary btn-round" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!--  Reinvest Wallet -->
<div class="modal fade" id="reinvest-buy-carcoin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="material-icons">close</i> </button>
                <h4 class="modal-title" id="myModalLabel">Buy Carcoin - <b style="vertical-align: bottom;">$ 0.00000</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group form-group"> <span class="input-group-addon"> <i class="material-icons">attach_money</i> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">USD Amount</label>
                                <input type="text" class="form-control" value>
                            </div>
                        </div>
                        <div class="input-group form-group"> <span class="input-group-addon"> <img src="/Carcoin/img/ic_zcoin-pri.svg" style="width: 24px;"> </span>
                            <div class="form-group label-floating">
                                <label class="control-label">Carcoin Amount</label>
                                <input type="text" class="form-control" value>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-round">Submit</button>
                <button type="button" class="btn btn-outline-primary btn-round" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
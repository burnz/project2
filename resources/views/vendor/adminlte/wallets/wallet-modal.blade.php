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




<!-- Carcoin Wallet -->


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









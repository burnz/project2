@extends('adminlte::layouts.backend') @section('content')
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
                                    <div class="col-md-12 d-flex justify-content-center mb-3" user-wallet>
                                        <div class="user-wallet">
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
                                        <div class="align-self-center">
                                            <!-- <button class="btn btn-thirdary btn-round" data-toggle="modal" data-target="#carcoin-sell">
                                                <span class="btn-label">
                                                                            <i class="material-icons">shopping_basket</i>
                                                                        </span> Sell Carcoin
                                                <div class="ripple-container"></div>
                                            </button>
                                            <button class="btn btn-thirdary btn-round" data-toggle="modal" data-target="#carcoin-buy-package">
                                                <span class="btn-label">
                                                                            <i class="material-icons">card_giftcard</i>
                                                                        </span> Buy Package
                                                <div class="ripple-container"></div>
                                            </button>
                                            <button class="btn btn-thirdary btn-round" data-toggle="modal" data-target="#carcoin-deposit">
                                                <span class="btn-label">
                                                                            <i class="material-icons">shop</i>
                                                                        </span> Deposit
                                                <div class="ripple-container"></div>
                                            </button>
                                            <button class="btn btn-thirdary btn-round" data-toggle="modal" data-target="#carcoin-withdraw">
                                                <span class="btn-label">
                                                                            <i class="material-icons reflect">shop</i>
                                                                        </span> Withdraw
                                                <div class="ripple-container"></div>
                                            </button>
                                            <button class="btn btn-thirdary btn-round" data-toggle="modal" data-target="#carcoin-transfer">
                                                <span class="btn-label">
                                                                            <i class="material-icons">swap_horiz</i>
                                                                        </span> Transfer
                                                <div class="ripple-container"></div>
                                            </button> -->
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card-content p-0">
                                            <!-- <div class="card-filter clearfix">
                                                <div class="col-md-4">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Select Type</label>
                                                        <select class="form-control">
                                                            <option disabled="" selected=""></option>
                                                            <option value="5">Buy CLP By USD</option>
                                                            <option value="6">Transfer From Holding Wallet</option>
                                                            <option value="7">Buy CLP By BTC</option>
                                                            <option value="8">Sell CLP</option>
                                                            <option value="10">Withdraw</option>
                                                            <option value="12">Transfer</option>
                                                            <option value="14">Deposit</option>
                                                            <option value="15">Buy Package</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-primary btn-round">Filter
                                                    </button>
                                                    <button type="button" class="btn btn-outline-primary btn-round">
                                                        Clear
                                                    </button>
                                                </div>
                                            </div> -->
                                            <div class="clearfix"></div>
                                            <!-- <h4 class="card-title">Command</h4> -->
                                            <div class="table-responsive">
                                                <table class="table" cellspacing="0" width="100%" style="width:100%">
                                                    <thead class="text-thirdary">
                                                        <th>No</th>
                                                        <th>Date/Time</th>
                                                        <th>Type</th>
                                                        <th>In</th>
                                                        <th>Out</th>
                                                        <th>Info</th>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>2017/12/30 10:07</td>
                                                            <td>0.399</td>
                                                            <td>54.213</td>
                                                            <td>354.215</td>
                                                            <td>This is Info</td>
                                                        </tr>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>2017/12/30 10:07</td>
                                                            <td>0.368</td>
                                                            <td>54.213</td>
                                                            <td>354.215</td>
                                                            <td>This is Info</td>
                                                        </tr>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>2017/12/30 10:07</td>
                                                            <td>0.366</td>
                                                            <td>54.213</td>
                                                            <td>354.215</td>
                                                            <td>This is Info</td>
                                                        </tr>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>2017/12/30 10:07</td>
                                                            <td>0.325</td>
                                                            <td>54.213</td>
                                                            <td>354.215</td>
                                                            <td>This is Info</td>
                                                        </tr>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>2017/12/30 10:07</td>
                                                            <td>0.315</td>
                                                            <td>54.213</td>
                                                            <td>354.215</td>
                                                            <td>This is Info</td>
                                                        </tr>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>2017/12/30 10:07</td>
                                                            <td>0.312</td>
                                                            <td>54.213</td>
                                                            <td>354.215</td>
                                                            <td>This is Info</td>
                                                        </tr>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>2017/12/30 10:07</td>
                                                            <td>0.312</td>
                                                            <td>54.213</td>
                                                            <td>354.215</td>
                                                            <td>This is Info</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
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
@include('adminlte::wallets.wallet-modal') @endsection
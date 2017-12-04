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
                                    <a href="panels.html#pill3" role="tab" data-toggle="tab">
                                        <i class="material-icons" icon="img" size="lg">
                                            <img src="/Carcoin/img/ic_zcoin-sec.svg">
                                        </i> Reinvest Wallet
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="pill3">
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-center mb-3" user-wallet>
                                        <div class="user-wallet">
                                            <div class="left">
                                                <i class="material-icons" icon="img" size="lg"><img src="/Carcoin/img/ic_zcoin-sec.svg"></i>
                                            </div>
                                            <div class="right">
                                                <span>Your Balance</span>
                                                <div class="content reinvest-color">
                                                    314,675
                                                </div>
                                            </div>
                                        </div>
                                        <div class="align-self-center">
                                            <button class="btn btn-thirdary btn-round" data-toggle="modal" data-target="#reinvest-buy-carcoin">
                                                <span class="btn-label">
                                                    <i class="material-icons">add_shopping_cart</i>
                                                </span> Buy Carcoin
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
                                                        <select class="form-control">
                                                            <option disabled="" selected=""></option>
                                                            <option value="1">Fast start bonus</option>
                                                            <option value="2">Profit</option>
                                                            <option value="3">Binary bonus</option>
                                                            <option value="4">Loyalty bonus</option>
                                                            <option value="5">Buy CLP</option>
                                                            <option value="16">Package Withdraw</option>
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
                                            </div>
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
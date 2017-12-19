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
                                            <button class="btn btn-thirdary btn-round" disabled data-toggle="modal" data-target="#carcoin-deposit">
                                                <span class="btn-label">
                                                                            <i class="material-icons">shop</i>
                                                                        </span> Deposit
                                                <div class="ripple-container"></div>
                                            </button>
                                            <button class="btn btn-thirdary btn-round" disabled data-toggle="modal" data-target="#carcoin-withdraw">
                                                <span class="btn-label">
                                                                            <i class="material-icons reflect">shop</i>
                                                                        </span> Withdraw
                                                <div class="ripple-container"></div>
                                            </button>
                                            <button class="btn btn-thirdary btn-round" disabled data-toggle="modal" data-target="#carcoin-transfer">
                                                <span class="btn-label">
                                                                            <i class="material-icons">swap_horiz</i>
                                                                        </span> Transfer
                                                <div class="ripple-container"></div>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card-content p-0">                                            
                                            <div class="clearfix"></div>
                                            <!-- <h4 class="card-title">Command</h4> -->
                                            <div class="table-responsive">
                                                <table class="table" cellspacing="0" width="100%" style="width:100%">
                                                    <thead class="text-thirdary">
                                                        <th>Date/Time</th>
                                                        <th>Type</th>
                                                        <th>In</th>
                                                        <th>Out</th>
                                                        <th>Info</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($wallets as $wallet)
                                                            <tr>
                                                                <td>
                                                                    {{ $wallet->created_at }}
                                                                </td>
                                                                <td></td>
                                                                @if($wallet->inOut == 'in')
                                                                    <td>
                                                                        {{ $wallet->amount }}
                                                                    </td>
                                                                    <td></td>
                                                                @else
                                                                    <td></td>
                                                                    <td>
                                                                        {{ $wallet->amount }}
                                                                    </td>
                                                                @endif
                                                                <td>
                                                                    {{ $wallet->note }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
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
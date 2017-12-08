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
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card-content p-0">
                                            
                                            <div class="clearfix"></div>
                                            <!-- <h4 class="card-title">Command</h4> -->
                                            <div class="table-responsive">
                                                <table class="table" cellspacing="0" width="100%" style="width:100%">
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
                                                                    +{{ number_format($wallet->amount, 2) }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($wallet->inOut=='out')
                                                                    -{{ number_format($wallet->amount, 2) }}
                                                                @endif
                                                            </td>
                                                            <td>{{ $wallet->note }}</td>
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
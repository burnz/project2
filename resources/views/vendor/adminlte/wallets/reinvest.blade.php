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
                                                {{ number_format($walletAmount['amountReinvest'], 5) }}
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
                                            <div class="clearfix"></div>
                                            <!-- <h4 class="card-title">Command</h4> -->
                                            <div class="table-responsive">
                                                <table class="table" cellspacing="0" width="100%" style="width:100%">
                                                    <thead class="text-thirdary">
                                                        <th>{{ trans('adminlte_lang::wallet.wallet_no') }}</th>
                                                        <th>{{ trans('adminlte_lang::wallet.wallet_date') }}</th>
                                                        <th>{{ trans('adminlte_lang::wallet.wallet_release_date') }}</th>
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
                                                        <td>{{ date('Y-m-d', strtotime("+6 months", strtotime($wallet->updated_at))) }}</td> 
                                                        <td>
                                                            {{ $wallet_type && isset($wallet_type[$wallet->type]) ? $wallet_type[$wallet->type] : '' }}
                                                        </td>
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
@endsection
@section('script')
    <script type="text/javascript">
        jQuery(document).ready(function(){
            
        });
    </script>
@stop
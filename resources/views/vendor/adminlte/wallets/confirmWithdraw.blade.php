@extends('adminlte::layouts.backend')

@section('htmlheader_title')
    Withdraw Confirm
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-center" style="position: relative;">
                            Withdraw {{ ($withdrawConfirm->type == 'btc' ? 'BTC' : 'CAR') }} Confirm
                        </h3>
                    </div>
                    <div class="card-content">
                        <div class="nav-center">
                            <ul class="nav nav-pills nav-pills-primary nav-pills-icons" role="tablist">
                                <li class="active">
                                    <a href="javascript::" role="tab" data-toggle="tab">
                                        <i class="material-icons" icon="img" size="lg"><img src="/Carcoin/img/zcoin-id-final_logo-rev.svg"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="pill2">
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3">
                                        @if (session('error'))
                                            <div class="alert alert-danger text-center">
                                                {{ session('error') }}
                                            </div>
                                        @endif
                                        @if(!$isConfirm)
                                            <form class="form-horizontal" role="form" method="POST" id="withdraw_confirm">
                                                {{ csrf_field() }}
                                                <div class="input-group form-group"> <span class="input-group-addon"> <img src="/Carcoin/img/bitcoin-symbol.svg" style="width: 24px;"> </span>
                                                    <div class="form-group label-floating is-focused">
                                                        <label class="control-label">BTC Amount</label>
                                                        <input type="number" class="form-control btcwithdraw" value="{{$withdrawConfirm->withdrawAmount}}" id="withdraw-btc-amount" name="withdrawAmount" disabled="">
                                                        <span class="help-block"></span>
                                                        <span class="material-input"></span></div>
                                                </div>
                                                <br/>
                                                <div class="input-group form-group"> <span class="input-group-addon"> <i class="material-icons">assignment_ind</i> </span>
                                                    <div class="form-group label-floating is-focused">
                                                        <label class="control-label">Wallet Address</label>
                                                        <input type="text" class="form-control" value="{{$withdrawConfirm->walletAddress}}" id="withdraw-address" name="walletAddress" disabled="">
                                                        <span class="help-block"></span>
                                                    <span class="material-input"></span></div>
                                                </div>


                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-md-6 col-md-offset-3">
                                                            <button type="submit" class="btn btn-primary" id="confirm_submit">
                                                                Confirm
                                                            </button>
                                                            <input type="hidden" value="0" name="status" id="withdraw_status">
                                                            <button type="button" class="btn btn-danger" id="withdraw_cancel">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        @else
                                            <div class="row">
                                                @if (session('status'))
                                                    <div class="alert alert-success">
                                                        {{ session('status') }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#withdraw_cancel').on('click', function () {
            if (confirm("Are you sure?")) {
                $('#withdraw_status').val("1");
                $('#withdraw_confirm').submit();
                return true;
            }
            return false;
        });

        $('#confirm_submit').on('click', function(){
            if (confirm("Are you sure?")) {
                $('#confirm_submit').attr('disabled', true);
                $('#withdraw_confirm').submit();
                return true;
            }
            return false;
        });
    });
</script>
@stop
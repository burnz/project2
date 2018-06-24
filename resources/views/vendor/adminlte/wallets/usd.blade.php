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
                                            <img src="/Carcoin/img/usd-symbol.png">
                                        </i> USD Wallet
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
                                                <i class="material-icons" icon="img" size="lg"><img src="/Carcoin/img/usd-symbol.png"></i>
                                            </div>
                                            <div class="right">
                                                <span>Your Balance</span>
                                                <div class="content reinvest-color">
                                                {{ number_format($user->userCoin->usdAmount, 2) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="align-self-center">  
                                            <button class="btn btn-thirdary btn-round" data-toggle="modal" data-target="#carcoin-convert" id ="btnConvert">
                                                <span class="btn-label">
                                                    <i class="material-icons">shop</i>
                                                                        </span> Convert to CAR
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
                                                <table class="table" id="tbRIV" cellspacing="0" width="100%" style="width:100%">
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
<div class="modal fade" id="carcoin-convert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="material-icons">close</i> </button>
                <h4 class="modal-title" id="myModalLabel">Buy Carcoin - <b style="vertical-align: bottom;"><img src="/Carcoin/img/usd-symbol.png" style="width: 20px;"> {{ number_format($user->userCoin->usdAmount, 2) }}</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group form-group"> <span class="input-group-addon"> <img src="/Carcoin/img/usd-symbol.png" style="width: 24px;"></span>
                            <div class="form-group label-floating">
                                <label class="control-label">USD Amount</label>
                                <input type="text" class="form-control" value id="usd-amount">
                                <span class="help-block">
                                </span>
                            </div>
                        </div>
                        <div class="input-group form-group"> <span class="input-group-addon"> <img src="/Carcoin/img/ic_zcoin-pri.svg" style="width: 24px;"> </span>
                            <div class="form-group label-floating">
                                <input type="text" class="form-control" value disabled="true" id="carcoin-amount">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-round" id="convert">Submit</button>
                <button type="button" class="btn btn-outline-primary btn-round" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script type="text/javascript">
        jQuery(document).ready(function(){
            $('#tbRIV').DataTable({
                "ordering": false,
                "searching":false,
                "bLengthChange": false,
            });

            $( "#usd-amount" ).keyup(function() {
	            var $this = $(this);
	            var value = $(this).val();
	            var result = value / globalCARUSD;

	            $("#carcoin-amount").click();
	            $("#carcoin-amount").val(result.toFixed(5));
	        });

            //filter
            $('#btn_filter').on('click', function () {
                var wallet_type = parseInt($('#wallet_type option:selected').val());
                if(wallet_type > 0){
                    location.href = '{{ url()->current() }}?type='+wallet_type;
                }else{
                    alert('Please choose a type!');
                    return false;
                }
            });
            $('#btn_filter_clear').on('click', function () {
                location.href = '{{ url()->current() }}';
            });

            $('#convert').on('click', function () {
                var usdAmount = $('#usd-amount').val();

                if($.trim(usdAmount) == ''){
                    $("#usd-amount").parents("div.form-group").addClass('has-error');
                    $("#usd-amount").parents("div.form-group").find('.help-block').text("USD Amount is not empty");
                }else{
                    $("#usd-amount").parents("div.form-group").removeClass('has-error');
                    $("#usd-amount").parents("div.form-group").find('.help-block').text('');
                }
                
                $.ajaxSetup({
	                headers: {
	                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                }
	            });

                if($.trim(usdAmount) != ''){
                    $.ajax({
                        method : 'POST',
                        url: "{{ route('wallet.buy-car') }}",
                        data: {usdAmount: usdAmount}
                    }).done(function (data) {
                        if (data.err) {
                            if(typeof data.msg !== undefined){
                                if(data.msg.usdAmountErr !== '') {
                                    $("#usd-amount").parents("div.form-group").addClass('has-error');
                                    $("#usd-amount").parents("div.form-group").find('.help-block').text(data.msg.usdAmountErr);
                                }else {
                                    $("#usd-amount").parents("div.form-group").removeClass('has-error');
                                    $("#usd-amount").parents("div.form-group").find('.help-block').text('');
                                }

                            }
                        } else {
                            $('#tranfer').modal('hide');
                            location.href = '{{ url()->current() }}';
                        }
                    }).fail(function () {
                        $('#tranfer').modal('hide');
                        swal("Some things went wrong");
                    });
                }
            });
        });
    </script>
@stop
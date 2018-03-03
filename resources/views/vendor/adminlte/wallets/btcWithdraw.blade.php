@extends('adminlte::layouts.backend')

@section('content')
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card" section="wallet-panel">
						<div class="card-header">
	                        <h3 class="card-title text-center" style="position: relative;">
	                            Withdraw - <b class="bitcoin-color" style="vertical-align: bottom;"><img src="/Carcoin/img/bitcoin-symbol.svg" style="width: 24px;">{{ number_format($walletAmount['amountBTC'], 5) }}</b>
	                        </h3>
	                    </div>
	                    <div class="card-content">
	                    	<div class="row">
	                    		<div class="col-md-12 justify-content-center text-center">
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
	                    	</div>
							{!! Form::open(array('url' => 'wallets/btcwithdraw', 'id' => 'form-withdraw-btc')) !!}
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
				                        <div class="form-group text-center">
				                        	<button type="button" class="btn btn-primary btn-round" id="btn-withdraw-btc">{{trans('adminlte_lang::default.submit')}}</button>
                							<button type="button" onclick="window.history.go(-1); return false;" class="btn btn-outline-primary btn-round" data-dismiss="modal">Back</button>
				                        </div>
				                    </div>
				                </div>
							{!! Form::close() !!}

	                    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
@section('script')
	<script type="text/javascript">
		jQuery(document).ready(function(){
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
		});
	</script>
@stop
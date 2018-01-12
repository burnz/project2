@extends('adminlte::layouts.backend') 

@section('content')
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card" section="wallet-panel">
						<div class="card-header">
	                        <h3 class="card-title text-center" style="position: relative;">
	                            Withdraw - <b class="carcoin-color" style="vertical-align: bottom;"><img src="/Carcoin/img/ic_zcoin-pri.svg" style="width: 24px;">{{ number_format($walletAmount['amountCLP'], 5) }}</b>
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
	                    	<div class="row">
			                    <div class="col-md-12">
			                        <div class="input-group form-group"> <span class="input-group-addon"> <img src="/Carcoin/img/ic_zcoin-pri.svg" style="width: 24px;"> </span>
			                            <div class="form-group label-floating">
			                                <label class="control-label">Carcoin Amount</label>
			                                <input type="number" class="form-control withdrawclpinput" id="withdrawAmount" name="withdrawAmount">
			                                <p class="help-block"></p>
			                            </div>
			                        </div>
			                        <div class="input-group form-group"> <span class="input-group-addon"> <i class="material-icons">assignment_ind</i> </span>
			                            <div class="form-group label-floating">
			                                <label class="control-label">Ethereum address E.g. 0x8f2b05ec6786358e14ace5d4c01d7ee7bf27</label>
			                                <input type="text" class="form-control" id="walletAddress" name="walletAddress">
			                                <p class="help-block"></p>
			                            </div>
			                        </div>
			                        <div class="input-group form-group"> <span class="input-group-addon"> <i class="material-icons">vpn_key</i> </span>
			                            <div class="form-group label-floating">
			                                <label class="control-label">2FA code E.g. 123456</label>
			                                <input type="number" class="form-control" id="withdrawOTP" name="withdrawOPT">
			                                <p class="help-block"></p>
			                            </div>
			                        </div>
			                        <div class="form-group pull-right">
			                            <label>{{ trans("adminlte_lang::wallet.fee") }}: <b>{{ config("app.fee_withRaw_CLP")}}</b></label>
			                        </div>
			                        <div class="form-group text-center">
			                        	<button type="button" class="btn btn-primary btn-round" id="withdraw-clp">Submit</button>
                						<button type="button" onclick="window.history.go(-1); return false;" class="btn btn-outline-primary btn-round" data-dismiss="modal">Back</button>
			                        </div>
			                    </div>
			                </div>
	                    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
@section('script')
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$('#withdraw-clp').on('click', function () {
                var withdrawAmount = $('#withdrawAmount').val();
                var walletAddress = $('#walletAddress').val();
                var withdrawOTP = $('#withdrawOTP').val();
                if($.trim(withdrawAmount) == ''){
                    $("#withdrawAmount").parents("div.form-group").addClass('has-error');
                    $("#withdrawAmount").parents("div.form-group").find('.help-block').text("{{trans('adminlte_lang::wallet.amount_required')}}");
                }else{
                    $("#withdrawAmount").parents("div.form-group").removeClass('has-error');
                    $("#withdrawAmount").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(walletAddress) == ''){
                    $("#walletAddress").parents("div.form-group").addClass('has-error');
                    $("#walletAddress").parents("div.form-group").find('.help-block').text("Ethereum Address is required");
                }else{
                    if(/^(0x)?[0-9a-fA-F]{40}$/.test(walletAddress) == false) {
                        $("#walletAddress").parents("div.form-group").addClass('has-error');
                        $("#walletAddress").parents("div.form-group").find('.help-block').text("Ethereum Address is not valid");
                    } else {
                        $("#walletAddress").parents("div.form-group").removeClass('has-error');
                        $("#walletAddress").parents("div.form-group").find('.help-block').text('');
                    }
                }
                    
                
                if($.trim(withdrawOTP) == ''){
                    $("#withdrawOTP").parents("div.form-group").addClass('has-error');
                    $("#withdrawOTP").parents("div.form-group").find('.help-block').text("{{trans('adminlte_lang::wallet.otp_required')}}");
                }else{
                    $("#withdrawOTP").parents("div.form-group").removeClass('has-error');
                    $("#withdrawOTP").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(withdrawAmount) != '' && $.trim(walletAddress) != '' && $.trim(withdrawOTP) != ''){
                    $('#withdraw-clp').attr('disabled', true);
                    $.ajax({
                        method : 'POST',
                        url: "{{ url('wallets/car/withdraw') }}",
                        data: {withdrawAmount: withdrawAmount, walletAddress: walletAddress, withdrawOTP: withdrawOTP,_token:'{{ csrf_token() }}'}
                    }).done(function (data) {
                        if (data.err) {
                            if(typeof data.msg !== undefined){
                                if(data.msg.withdrawAmountErr !== '') {
                                    $("#withdrawAmount").parents("div.form-group").addClass('has-error');
                                    $("#withdrawAmount").parents("div.form-group").find('.help-block').text(data.msg.withdrawAmountErr);
                                }else {
                                    $("#withdrawAmount").parents("div.form-group").removeClass('has-error');
                                    $("#withdrawAmount").parents("div.form-group").find('.help-block').text('');
                                }
                                if(data.msg.walletAddressErr !== '') {
                                    $("#walletAddress").parents("div.form-group").addClass('has-error');
                                    $("#walletAddress").parents("div.form-group").find('.help-block').text(data.msg.walletAddressErr);
                                }else {
                                    $("#walletAddress").parents("div.form-group").removeClass('has-error');
                                    $("#walletAddress").parents("div.form-group").find('.help-block').text('');
                                }
                                if(data.msg.withdrawOTPErr !== '') {
                                    $("#withdrawOTP").parents("div.form-group").addClass('has-error');
                                    $("#withdrawOTP").parents("div.form-group").find('.help-block').text(data.msg.withdrawOTPErr);
                                }else {
                                    $("#withdrawOTP").parents("div.form-group").removeClass('has-error');
                                    $("#withdrawOTP").parents("div.form-group").find('.help-block').text('');
                                }
                                $('#withdraw-clp').attr('disabled', false);
                            }
                        } else {
                            $('#tranfer').modal('hide');
                            location.href = '{{ url()->current() }}';
                        }
                    }).fail(function () {
                        $('#withdraw-clp').attr('disabled', false);
                        $('#tranfer').modal('hide');
                        swal("Some things wrong!");
                    });
                }
            });
		});
	</script>
@stop
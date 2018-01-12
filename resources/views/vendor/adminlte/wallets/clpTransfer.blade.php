@extends('adminlte::layouts.backend') 

@section('content')
	<div class="content">
		<div class="container-fluid">
			<div class="row">
                <div class="col-md-12">
					<div class="card" section="wallet-panel">

						<div class="card-header">
	                        <h3 class="card-title text-center" style="position: relative;">
	                            Transfer - <b class="carcoin-color" style="vertical-align: bottom;"><img src="/Carcoin/img/ic_zcoin-pri.svg" style="width: 24px;">{{ number_format($walletAmount['amountCLP'], 5) }}</b>
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

	                    	<div class="input-group form-group"> <span class="input-group-addon"> <img src="/Carcoin/img/ic_zcoin-pri.svg" style="width: 24px;"> </span>
	                        <div class="form-group label-floating">
		                            <label class="control-label">Carcoin Amount</label>
		                            <input type="number" class="form-control amount-clp-tranfer" id="clpAmount" name="clpAmount">
		                            <p class="help-block"></p>
		                        </div>
		                    </div>

		                    <div class="input-group form-group"> <span class="input-group-addon"> <i class="material-icons">person</i> </span>
		                        <div class="form-group label-floating">
		                            <label class="control-label">User</label>
		                            <input type="text" class="form-control" id="clpUsername" name="clpUsername">
		                            <p class="help-block"></p>
		                        </div>
		                    </div>
		                    <div class="input-group form-group"> <span class="input-group-addon"> <i class="material-icons">assignment_ind</i> </span>
		                        <div class="form-group label-floating">
		                            <label class="control-label">ID</label>
		                            <input type="number" class="form-control" id="clpUid" name="clpUid">
		                            <p class="help-block"></p>
		                        </div>
		                    </div>
		                    <div class="input-group form-group"> <span class="input-group-addon"> <i class="material-icons">vpn_key</i> </span>
		                        <div class="form-group label-floating">
		                            <label class="control-label">2FA code E.g. 123456</label>
		                            <input type="number" class="form-control" id="clpOTP" name="clpOTP">
		                        </div>
		                    </div>
	                    	<div class="form-group text-center">
	                    		<button type="button" id="clptranfer" class="btn btn-primary btn-round">Submit</button>
                				<button type="button" onclick="window.history.go(-1); return false;" class="btn btn-outline-primary btn-round" data-dismiss="modal">Back</button>
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
		var mytimer;
		$('#clpUsername').on('blur onmouseout onfocusout keyup', function () {
            clearTimeout(mytimer);
            var search = $(this).val();
            if(search.length >= 3){
                mytimer = setTimeout(function(){
                    $('#clpUid').parents("div.form-group").find('.fa-id-card-o').remove();
                    $('#clpUid').parents("div.form-group").find('.input-group-addon').append('<i class="fa fa-spinner"></i>');
                    $.ajax({
                        type: "GET",
                        url: "/users/search",
                        data: {username : search}
                    }).done(function(data){
                        $('#clpUid').parents("div.form-group").find('.fa-spinner').remove();
                        $('#clpUid').parents("div.form-group").find('.input-group-addon').append('<i class="fa fa-id-card-o"></i>');
                        if(data.err) {
                            $("#clpUsername").parents("div.form-group").addClass('has-error');
                            $("#clpUsername").parents("div.form-group").find('.help-block').text(data.err);
                            $('#clpUid').val('');
                        }else{
                            $('#clpUsername').parents("div.form-group").removeClass('has-error');
                            $("#clpUsername").parents("div.form-group").find('.help-block').text('');
                            $('#clpUid').parents("div.form-group").removeClass('has-error');
                            $('#clpUid').parents("div.form-group").find('.help-block').text('');
                            $('#clpUid').val(data.id);
                            $('#clpUid').trigger('change');
                        }
                    }).fail(function (){
                        $('#tranfer').modal('hide');
                        swal("Some things wrong!");
                    });
                }, 1000);
            }
        });

        $('#clptranfer').on('click', function () {
            var clpAmount = $('#clpAmount').val();
            var clpUsername = $('#clpUsername').val();
            var clpOTP = $('#clpOTP').val();
            var clpUid = $('#clpUid').val();
            if($.trim(clpAmount) == ''){
                $("#clpAmount").parents("div.form-group").addClass('has-error');
                $("#clpAmount").parents("div.form-group").find('.help-block').text("{{trans('adminlte_lang::wallet.amount_required')}}");
            }else{
                $("#clpAmount").parents("div.form-group").removeClass('has-error');
                $("#clpAmount").parents("div.form-group").find('.help-block').text('');
            }
            if($.trim(clpUsername) == ''){
                $("#clpUsername").parents("div.form-group").addClass('has-error');
                $("#clpUsername").parents("div.form-group").find('.help-block').text("{{ trans('adminlte_lang::wallet.username_required') }}");
            }else{
                $("#clpUsername").parents("div.form-group").removeClass('has-error');
                $("#clpUsername").parents("div.form-group").find('.help-block').text('');
            }
            if($.trim(clpUid) == ''){
                $("#clpUid").parents("div.form-group").addClass('has-error');
                $("#clpUid").parents("div.form-group").find('.help-block').text("{{trans('adminlte_lang::wallet.uid_required')}}");
            }else{
                $("#clpUid").parents("div.form-group").removeClass('has-error');
                $("#clpUid").parents("div.form-group").find('.help-block').text('');
            }
            if($.trim(clpOTP) == ''){
                $("#clpOTP").parents("div.form-group").addClass('has-error');
                $("#clpOTP").parents("div.form-group").find('.help-block').text("{{trans('adminlte_lang::wallet.otp_required')}}");
            }else{
                $("#clpOTP").parents("div.form-group").removeClass('has-error');
                $("#clpOTP").parents("div.form-group").find('.help-block').text('');
            }
            if($.trim(clpAmount) != '' && $.trim(clpUsername) != '' && $.trim(clpOTP) != ''){
                $.ajax({
                    url: "{{ url('wallets/car/transfer') }}",
                    data: {clpAmount: clpAmount, clpUsername: clpUsername, clpOTP: clpOTP, clpUid: clpUid}
                }).done(function (data) {
                    if (data.err) {
                        if(typeof data.msg !== undefined){
                            if(data.msg.clpAmountErr !== '') {
                                $("#clpAmount").parents("div.form-group").addClass('has-error');
                                $("#clpAmount").parents("div.form-group").find('.help-block').text(data.msg.clpAmountErr);
                            }else {
                                $("#clpAmount").parents("div.form-group").removeClass('has-error');
                                $("#clpAmount").parents("div.form-group").find('.help-block').text('');
                            }
                            if(data.msg.clpUsernameErr !== '') {
                                $("#clpUsername").parents("div.form-group").addClass('has-error');
                                $("#clpUsername").parents("div.form-group").find('.help-block').text(data.msg.clpUsernameErr);
                            }else {
                                if(data.msg.transferRuleErr !== '') {
                                    $("#clpUsername").parents("div.form-group").addClass('has-error');
                                    $("#clpUsername").parents("div.form-group").find('.help-block').text(data.msg.transferRuleErr);
                                } else {
                                    $("#clpUsername").parents("div.form-group").removeClass('has-error');
                                    $("#clpUsername").parents("div.form-group").find('.help-block').text('');
                                }
                            }
                            if(data.msg.clpUidErr !== '') {
                                $("#clpUid").parents("div.form-group").addClass('has-error');
                                $("#clpUid").parents("div.form-group").find('.help-block').text(data.msg.clpUidErr);
                            }else {
                                $("#clpUid").parents("div.form-group").removeClass('has-error');
                                $("#clpUid").parents("div.form-group").find('.help-block').text('');
                            }
                            if(data.msg.clpOTPErr !== '') {
                                $("#clpOTP").parents("div.form-group").addClass('has-error');
                                $("#clpOTP").parents("div.form-group").find('.help-block').text(data.msg.clpOTPErr);
                            }else {
                                $("#clpOTP").parents("div.form-group").removeClass('has-error');
                                $("#clpOTP").parents("div.form-group").find('.help-block').text('');
                            }
                        }
                    } else {
                        $('#tranfer').modal('hide');
                        location.href = '{{ url()->current() }}';
                    }
                }).fail(function () {
                    $('#tranfer').modal('hide');
                    swal("Some things wrong!");
                });
            }
        });
	</script>
@stop

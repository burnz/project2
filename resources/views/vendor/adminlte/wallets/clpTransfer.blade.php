@extends('adminlte::layouts.backend') 

@section('content')
	<div class="content">
		<div class="container-fluid">
			<div class="row">
                <div class="col-md-12">
                    <div class="input-group form-group"> <span class="input-group-addon"> <img src="/Carcoin/img/ic_zcoin-pri.svg" style="width: 24px;"> </span>
                        <div class="form-group label-floating">
                            <label class="control-label">Carcoin Amount</label>
                            <input type="number" class="form-control" id="carAmount" name="carAmount">
                            <p class="help-block"></p>
                        </div>
                    </div>

                    <div class="input-group form-group"> <span class="input-group-addon"> <i class="material-icons">person</i> </span>
                        <div class="form-group label-floating">
                            <label class="control-label">User</label>
                            <input type="text" class="form-control" id="carUsername" name="carUsername">
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="input-group form-group"> <span class="input-group-addon"> <i class="material-icons">assignment_ind</i> </span>
                        <div class="form-group label-floating">
                            <label class="control-label">ID</label>
                            <input type="number" class="form-control" id="carUid" name="carUid">
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="input-group form-group"> <span class="input-group-addon"> <i class="material-icons">vpn_key</i> </span>
                        <div class="form-group label-floating">
                            <label class="control-label">2FA code E.g. 123456</label>
                            <input type="number" class="form-control" id="carOTP" name="carOTP">
                        </div>
                    </div>
                    <div class="input-group form-group">
                        <div class="form-group">
                            <button type="button" id="car-tranfer" class="btn btn-primary btn-round">Submit</button>
                            <button type="button" id="close-transfer" class="btn btn-outline-primary btn-round" data-dismiss="modal">Close</button>
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

            $("#close-transfer").on('click', function() {
                location.href = "/wallets/car";
            });

            $('#carUsername').on('blur onmouseout onfocusout keyup', function () {
                var search = $(this).val();
                if(search.length >= 3){
                    mytimer = setTimeout(function(){
                        $('#carUid').parents("div.form-group").find('.fa-id-card-o').remove();
                        $('#carUid').parents("div.form-group").find('.input-group-addon').append('<i class="fa fa-spinner"></i>');
                        $.ajax({
                            type: "GET",
                            url: "/users/search",
                            data: {username : search}
                        }).done(function(data){
                            $('#carUid').parents("div.form-group").find('.fa-spinner').remove();
                            $('#carUid').parents("div.form-group").find('.input-group-addon').append('<i class="fa fa-id-card-o"></i>');
                            if(data.err) {
                                $("#carUsername").parents("div.form-group").addClass('has-error');
                                $("#carUsername").parents("div.form-group").find('.help-block').text(data.err);
                                $('#carUid').val('');
                            }else{
                                $('#carUsername').parents("div.form-group").removeClass('has-error');
                                $("#carUsername").parents("div.form-group").find('.help-block').text('');
                                $('#carUid').parents("div.form-group").removeClass('has-error');
                                $('#carUid').parents("div.form-group").find('.help-block').text('');
                                $('#carUid').val(data.id);
                                $('#carUid').trigger('change');
                            }
                        }).fail(function (){
                            $('#tranfer').modal('hide');
                            swal("Some things wrong!");
                        });
                    }, 1000);
                }
            });
            $('#car-tranfer').on('click', function () {
                var carAmount = $('#carAmount').val();
                var carUsername = $('#carUsername').val();
                var carOTP = $('#carOTP').val();
                var carUid = $('#carUid').val();
                if($.trim(carAmount) == ''){
                    $("#carAmount").parents("div.form-group").addClass('has-error');
                    $("#carAmount").parents("div.form-group").find('.help-block').text("{{trans('adminlte_lang::wallet.amount_required')}}");
                }else{
                    $("#carAmount").parents("div.form-group").removeClass('has-error');
                    $("#carAmount").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(carUsername) == ''){
                    $("#carUsername").parents("div.form-group").addClass('has-error');
                    $("#carUsername").parents("div.form-group").find('.help-block').text("{{ trans('adminlte_lang::wallet.username_required') }}");
                }else{
                    $("#carUsername").parents("div.form-group").removeClass('has-error');
                    $("#carUsername").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(carUid) == ''){
                    $("#carUid").parents("div.form-group").addClass('has-error');
                    $("#carUid").parents("div.form-group").find('.help-block').text("{{trans('adminlte_lang::wallet.uid_required')}}");
                }else{
                    $("#carUid").parents("div.form-group").removeClass('has-error');
                    $("#carcarUid").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(carOTP) == ''){
                    $("#carOTP").parents("div.form-group").addClass('has-error');
                    $("#carOTP").parents("div.form-group").find('.help-block').text("{{trans('adminlte_lang::wallet.otp_required')}}");
                }else{
                    $("#carOTP").parents("div.form-group").removeClass('has-error');
                    $("#carOTP").parents("div.form-group").find('.help-block').text('');
                }
                if($.trim(carAmount) != '' && $.trim(carUsername) != '' && $.trim(carOTP) != ''){
                    $.ajax({
                        url: "{{ url('wallets/car/transfer') }}",
                        data: {carAmount: carAmount, carUsername: carUsername, carOTP: carOTP, carUid: carUid}
                    }).done(function (data) {
                        if (data.err) {
                            if(typeof data.msg !== undefined){
                                if(data.msg.carAmountErr !== '') {
                                    $("#carAmount").parents("div.form-group").addClass('has-error');
                                    $("#carAmount").parents("div.form-group").find('.help-block').text(data.msg.carAmountErr);
                                }else {
                                    $("#carAmount").parents("div.form-group").removeClass('has-error');
                                    $("#carAmount").parents("div.form-group").find('.help-block').text('');
                                }
                                if(data.msg.carUsernameErr !== '') {
                                    $("#carUsername").parents("div.form-group").addClass('has-error');
                                    $("#carUsername").parents("div.form-group").find('.help-block').text(data.msg.carUsernameErr);
                                }else {
                                    if(data.msg.transferRuleErr !== '') {
                                        $("#carUsername").parents("div.form-group").addClass('has-error');
                                        $("#carUsername").parents("div.form-group").find('.help-block').text(data.msg.transferRuleErr);
                                    } else {
                                        $("#carUsername").parents("div.form-group").removeClass('has-error');
                                        $("#carUsername").parents("div.form-group").find('.help-block').text('');
                                    }
                                }
                                if(data.msg.carUidErr !== '') {
                                    $("#carUid").parents("div.form-group").addClass('has-error');
                                    $("#carUid").parents("div.form-group").find('.help-block').text(data.msg.carUidErr);
                                }else {
                                    $("#carUid").parents("div.form-group").removeClass('has-error');
                                    $("#carUid").parents("div.form-group").find('.help-block').text('');
                                }
                                if(data.msg.carOTPErr !== '') {
                                    $("#carOTP").parents("div.form-group").addClass('has-error');
                                    $("#carOTP").parents("div.form-group").find('.help-block').text(data.msg.carOTPErr);
                                }else {
                                    $("#carOTP").parents("div.form-group").removeClass('has-error');
                                    $("#carOTP").parents("div.form-group").find('.help-block').text('');
                                }
                            }
                        } else {
                            location.href = "/wallets/car";
                        }
                    }).fail(function () {
                        $('#tranfer').modal('hide');
                        swal("Some things wrong!");
                    });
                }
            });
            
        });
    </script>
@stop

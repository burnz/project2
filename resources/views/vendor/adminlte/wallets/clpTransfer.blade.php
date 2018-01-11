@extends('adminlte::layouts.backend') 

@section('content')
	<div class="content">
		<div class="container-fluid">
			<div class="row">
                <div class="col-md-12">
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
                </div>
            </div>
		</div>
	</div>
@stop
@section('script')
@stop

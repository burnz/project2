@extends('adminlte::layouts.backend')

@section('content')
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card" section="wallet-panel">
						<div class="card-header">
	                        <h3 class="card-title text-center" style="position: relative;">
	                            Deposit To Your Wallet
	                        </h3>
	                    </div>
	                    <div class="card-content">
	                    	<div class="row d-flex" wallet-deposit>
			                    <div class="col-md-7 text-center align-self-center">
			                        <h5>Your BTC Wallet address</h5>
			                        <input type="text" value="{{ $walletAddress }}" id="wallet-address" class="form-control wallet-address" readonly="true">
			                        <button class="btn btn-primary btn-round btnwallet-address" data-clipboard-target="#wallet-address" title="copy"> <span class="btn-label"> <i class="material-icons">content_copy</i> </span> Copy
			                            <div class="ripple-container"></div>
			                        </button>
			                    </div>
			                    <div class="col-md-5 text-center">
			                        <!-- Trigger -->
			                        <h5>BTC Wallet link</h5>
			                        <a href="https://blockchain.info/address/{{ $walletAddress }}" target="_blank">blockchain</a>, <a href="https://blockexplorer.com/address/{{ $walletAddress }}" target="_blank">blockexplorer</a>
			                        <center>
			                            <div id="qrcode" style="padding-bottom: 10px;"></div>
			                        </center>
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
<script src="{{asset('Carcoin/js/jquery.qrcode.min.js')}}"></script>
<script src="{{asset('Carcoin/js/clipboard.min.js')}}"></script>
<script type="text/javascript">
	jQuery(document).ready(function(){
		var qrcode = $("#qrcode").qrcode({
            width: 180,
            height: 180,
            text: '{{ $walletAddress }}',
            colorDark: "#000000",
            colorLight: "#ffffff",
            //correctLevel: qrcode.CorrectLevel.H
        });

	    $('.btnwallet-address').tooltip({
            trigger: 'click',
            placement: 'bottom'
        });
        
        function setTooltip(message) {
            $('.btnwallet-address')
              .attr('data-original-title', message)
              .tooltip('show');
        }
        
        function hideTooltip() {
            setTimeout(function() {
              $('button').tooltip('hide');
            }, 1000);
          }
        
        var clipboard = new Clipboard('.btnwallet-address');
        clipboard.on('success', function(e) {
            e.clearSelection();
            setTooltip('Copied!');
            hideTooltip();
        });
	});
</script>
@stop
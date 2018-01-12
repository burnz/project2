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
	                    	<div class="row d-flex" wallet-deposit>
			                    <div class="col-md-7 text-center align-self-center">
			                        <h5>Your Carcoin Wallet address</h5>
			                        <input type="text" class="form-control" readonly="true" id="wallet-address" value="{{$walletAddress}}">
			                        @if(empty($walletAddress))
			                        <button class="btn btn-primary btn-round get-clpwallet">Generate
			                            <div class="ripple-container"></div>
			                        </button>
			                        @endif
			                        <button class="btn btn-primary btn-round btnwallet-address" data-clipboard-target="#wallet-address" title="" data-original-title="Copied!"> <span class="btn-label"> <i class="material-icons">content_copy</i> </span> Copy
			                            <div class="ripple-container"></div>
			                        </button>
			                    </div>
			                    <div class="col-md-5 text-center">
			                        <!-- Trigger -->
			                        <h5>Carcoin Wallet link</h5>
			                        <a href="https://blockchain.info/address/{{$walletAddress}}" target="_blank">blockchain</a>, <a href="https://blockexplorer.com/address/{{$walletAddress}}" target="_blank">blockexplorer</a>
			                        <center>
			                            <div id="qrcode"></div>
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
			var packageId = {{ Auth::user()->userData->packageId }};
            var packageIdPick = packageId;
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
		$(".get-clpwallet").click(function(){
                $(".get-clpwallet").attr("disabled", "disabled");
                var $this = $(this);
                $this.button('loading');
                $.get("{{URL::to('wallets/car/getaddressclpwallet')}}", function(data, status){
                    if (data.err){
                    	swal("Whoops!","{{trans('adminlte_lang::wallet.not_get_address_clp_wallet')}}","error");
                        //alert("{{trans('adminlte_lang::wallet.not_get_address_clp_wallet')}}");
                        $this.button('reset');
                        $(".get-clpwallet").removeAttr("disabled");
                    }else{
                        $("#wallet-address").val(data.data);
                        $(".get-clpwallet").hide();
                    }
                }).fail(function () {
                    console.log("Error response!")
                });
            });
	</script>
@stop
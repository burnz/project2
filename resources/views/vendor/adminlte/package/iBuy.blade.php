@extends('adminlte::layouts.backend')
@section('htmlheader_title')
	{{ trans('adminlte_lang::package.header_title') }}
@endsection

@section('content')
	<style type="text/css">
        .bootstrap-select{
            margin-top: 18px !important;
            margin-bottom: 0px;
        }
        /*.btn-group.open>.dropdown-toggle.btn.btn-primary, .btn-group-vertical.open>.dropdown-toggle.btn.btn-primary, .btn-primary
        {
            background-color: #9c27b0 !important;
        }*/
        .card-action>.amount{
            width: auto !important;
            margin:0 15px 0 15px !important;
        }
        .termAgree{
            color: #ee2229;
            display: none;
        }
        table.dataTable>thead>tr>th, table.dataTable>tbody>tr>th, table.dataTable>tfoot>tr>th, table.dataTable>thead>tr>td, table.dataTable>tbody>tr>td, table.dataTable>tfoot>tr>td {
            padding: 12px 8px !important;
            outline: 0;
        }
        .table>thead>tr>th {
            vertical-align: bottom;
            border-bottom: 1px solid #ddd !important;
        }
        .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
            background-color: #ee2229;
            border-color: #9c27b0;
            color: #FFFFFF;
            box-shadow: 0 14px 26px -12px rgba(238, 34, 41, 0.42), 0 4px 23px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(238, 34, 41, 0.2);
        }
        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after,
        table.dataTable thead .sorting_asc_disabled:after,
        table.dataTable thead .sorting_desc_disabled:after {
            position: absolute;
            bottom: 8px;
            right: 8px;
            display: block;
            font-family: 'Glyphicons Halflings';
            opacity: 0.5
        }

        table.dataTable thead .sorting:after {
            opacity: 0.2;
            content: "\e150"
        }

        table.dataTable thead .sorting_asc:after {
            content: "\e155"
        }

        table.dataTable thead .sorting_desc:after {
            content: "\e156"
        }
        .card-pricing .icon h3{
            line-height: 1;
            height: auto;
            font-size: 15px;
        }
        .modal-content .modal-body{
            padding-top:0 !important;
        }
        .card .card-title{
            font-size:20px;
        }
        .label {
            display: inline;
            padding: .2em .6em .3em !important;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25em !important;
            color:#fff !important;
        }
        .label-danger {
            background-color: #d9534f;
        }
        .card-action .refund {
            width: auto !important;
            margin: 0 15px 0 15px !important;
        }
        .refund .bootstrap-select{
            margin-top: 0px !important;
        }
        .card-pricing .card-description{
            margin:0 !important;
        }
        .card-action>.amount{
            margin-top: -15px !important;
        }
        .has-error .help-block{
            display: block !important;
        }
    </style>
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					@if ($errors->any())
	                    <div class="col-md-12">
	                        <div class="alert alert-danger">
	                            <ul class="list-unstyled">
	                                @foreach ($errors->all() as $error)
	                                    <li>{{ $error }}</li>
	                                @endforeach
	                            </ul>
	                        </div>
	                    </div>
	                @endif
	                @if(Session::has('flash_success'))
	                    <div class="col-md-12">
	                        <div class="alert alert-success">
	                            {{Session::get('flash_success')}}
	                        </div>
	                    </div>
	                @elseif(Session::has('flash_error'))
	                    <div class="col-md-12">
	                        <div class="alert alert-danger">
	                            {{Session::get('flash_error')}}
	                        </div>
	                    </div>
	                @endif
				</div>
				<div class="col-md-12">
					<div class="card" section="buy-package">
						<div class="card-header">
	                        <h3 class="card-title text-center" style="position: relative;">
	                            Become a CSC Jackpot agency
                                <b id="carcoin-info" class="carcoin-color" style="vertical-align: bottom;"><img src="{{asset('Carcoin/img/ic_zcoin-pri.svg')}}" style="width: 24px;">&nbsp;{{ number_format($walletAmount['amountCLP'], 5) }}</b>
	                        </h3>
	                    </div>
	                    <div class="card-content clearfix">
                            @if(count($dataPack)>0)
                                @foreach($dataPack as $pkey=>$pval)
                                    <div class="col-md-3">
                                        <div class="card card-pricing  <?=$pkey==0?'card-raised':''?>">
                                            <div class="card-content p-0">
                                                <div class="icon <?=$pkey==0?'active':''?>">
                                                    <h3 style="text-transform: uppercase;">{{$pval->name}}</h3>
                                                    <div class="radio" big="md">
                                                        <label>
                                                            <input data-min="{{$pval->min_price}}" data-max="{{$pval->max_price}}" type="radio" name="optionsRadios" <?=$pkey==0?'checked="checked"':'' ?> value="{{$pval->pack_id}}" > 
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="card-description">
                                                    <span>
                                                        <b>${{number_format($pval->min_price)}}</b>
                                                    </span>
                                                    <span class="carcoin-color">
                                                        <i class="material-icons" icon="carcoin-primary"></i>
                                                        <b>{{number_format($pval->min_price_clp,2)}}</b>
                                                    </span>
                                                </div>
                                                <div class="card-action">

												<div class="form-group my-4 refund input-group">
													<span class="input-group-addon pr-0">
													<i class="material-icons">refresh</i>
													</span>
												<div class="form-group label-floating">
													<select class="selectpicker refund-type" name="refundType" id="refund_type" data-style="select-with-transition" title="Refund Type" data-size="2">
														<option value="1">REFUND BY USD</option>
														<option value="2">REFUND BY CAR</option>
													</select>
													<p class="help-block errorRefund"></p>
												</div>
												</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                            <div class="col-md-12">
                                There are no package available
                            </div>
                            @endif


                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        <input id="term" type="checkbox">
                                        <a href="/package-term-condition.html" target="_blank">I agree to the terms and condition.</a>
                                    </label>
                                    <p class="help-block termAgree">Please agree terms and conditions</p>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                            	<button type="button" class="btn btn-primary btn-round" id="btnBuyPackage">Choose</button>
                                    <button type="button" onclick="window.history.go(-1); return false;" class="btn btn-primary btn-round btn-outline-primary" data-dismiss="modal">Back</button>	
                            </div>
							
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>

	{!! Form::open(['action'=>'PackageController@invest','method'=>'post','id'=>'bPackageF','style'=>'display:none']) !!}
        <input type="hidden" id="packageId" name="packageId"/>
        <input type="hidden" name="packageAmount" id="packageAmount"/>
        <input type="hidden" id="walletId" name="walletId" />
        <input type="hidden" name="refundType" id="refundType" />
    {!! Form::close() !!}
@stop
@section('script')
	<script type="text/javascript">
		jQuery(document).ready(function(){

			var url_string = window.location.href;
			var url = new URL(url_string);
			var wid = url.searchParams.get("wid");

			$('#walletId').val(wid);

			jQuery('[section="buy-package"] .amount input[type="text"]').val()
		    jQuery('[name="optionsRadios"]').click(function() {
		        jQuery('[section="buy-package"] .icon').each(function(index, el) {
		            jQuery(el).hasClass('active') ? jQuery(el).removeClass('active') : $(el);
		        });

		        jQuery('[section="buy-package"] .card-pricing').each(function(index, el) {
		            jQuery(el).hasClass('card-raised') ? jQuery(el).removeClass('card-raised') : jQuery(el);
		        });

		        jQuery(this).closest('.card').find('.icon').addClass('active');
		        jQuery(this).closest('.card').addClass('card-raised');
                jQuery('#packageId').val($(this).val());

		    });


		    $('#btnBuyPackage').click(function(){
                var pricing=jQuery('.card-raised');
                let packageId=pricing.children().find('input[type="radio"]').val();
                
                let refund=pricing.children().find('.selectpicker.refund-type').val();
                if(refund=='')
                {
                    pricing.children().find('.errorRefund').text('Choose refund type');
                    pricing.children().find('.refund').children('.label-floating').addClass('has-error');
                    return false;
                }
                
                pricing.children().find('.errorAmount').text('');
                if(!$('#term').is(':checked'))
                {
                    $('.termAgree').css('display','block');
                    return false;
                }
                $('.termAgree').css('display','none');
                $('#modBuyPackage').modal('hide');
                swal({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, Buy Package!',
                  cancelButtonText: 'No, cancel!',
                  confirmButtonClass: 'btn btn-success',
                  cancelButtonClass: 'btn btn-danger',
                  buttonsStyling: false,
                  reverseButtons: true
                }).then(function(result){
                    $('#packageAmount').val(amount);
                    $('#packageId').val(packageId);
                    $('#refundType').val(refund);
                    $('#bPackageF').submit();
                })

            });

		});
	</script>
@stop
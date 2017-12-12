@extends('adminlte::layouts.backend')
@section('htmlheader_title')
	{{ trans('adminlte_lang::package.header_title') }}
@endsection

@section('content')
    <style type="text/css">
        .bootstrap-select{
            width: auto !important;
        }
        .btn-group.open>.dropdown-toggle.btn.btn-primary, .btn-group-vertical.open>.dropdown-toggle.btn.btn-primary, .btn-primary
        {
            background-color: #9c27b0 !important;
        }
        .card-action>.amount{
            width: auto !important;
            margin:0 15px 0 15px !important;
        }
        .termAgree{
            color: #ee2229;
            display: none;
        }
    </style>
	<div class="content">
        <div class="container-fluid">
            <div class="row">

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
                <div class="col-md-12">
                    <div class="card" section="buy-package">
                        <div class="col-md-12 my-4">
                            <!-- Modal -->
                            <div class="modal fade" id="modBuyPackage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Buy Packages
                                        <b id="carcoin-info" class="carcoin-color" style="vertical-align: bottom;"><img src="{{asset('Carcoin/img/ic_zcoin-pri.svg')}}" style="width: 24px;">&nbsp;{{ number_format($walletAmount['amountCLP'], 5) }}</b>
                                        <b id="reinvest-info" class="reinvest-color" style="vertical-align: bottom;"><img src="{{asset('Carcoin/img/ic_zcoin-sec.svg')}}" style="width: 24px;">&nbsp;{{ number_format($walletAmount['amountReinvest'], 5) }}</b>
                                    </h4>
                                  </div>
                                  <div class="modal-body">
                                        <div class="card-header">
                                            <h3 class="card-title text-center">Pick the best package for you</h3>
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
                                                                            <input data-min="{{$pval->min_price_clp}}" data-max="{{$pval->max_price_clp}}" type="radio" name="optionsRadios" <?=$pkey==0?'checked="checked"':'' ?> value="{{$pval->pack_id}}" > 
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="card-description">
                                                                    <span>
                                                                        <b>${{$pval->min_price}} - ${{$pval->max_price}}</b>
                                                                    </span>
                                                                    <span class="carcoin-color">
                                                                        <i class="material-icons" icon="carcoin-primary"></i>
                                                                        <b>{{$pval->min_price_clp}}</b> - <b>{{$pval->max_price_clp}}</b>
                                                                    </span>
                                                                </div>
                                                                <div class="card-action">
                                                                    <div class="input-group form-group my-4 amount">
                                                                        <span class="input-group-addon pr-0">
                                                                            <i class="material-icons">attach_money</i>
                                                                        </span>
                                                                        <div class="form-group label-floating">
                                                                            <label class="control-label">Your Amount</label>
                                                                            <input name="lastname" type="number" class="form-control" min="200" max="1000" step="10">
                                                                            <span class="material-input"></span>
                                                                            <p class="help-block errorAmount"></p>
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
                                        </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btnBuyPackage">Buy Package</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!--end modal-->

                            <select name="wallet_type" id="wallet_type" class="selectpicker" data-style="btn btn-primary btn-round" title="Sellect Wallet" data-size="2">
                                <option value="2">CARCOIN WALLET</option>
                                <option value="3">REINVEST WALLET</option>
                            </select>
                            <button type="button" id="btnBuyPackageS1" class="btn btn-success btn-round">Buy Packages</button>

                        </div>
                        <div class="col-md-12 my-4">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-thirdary">
                                        <th>Date</th>
                                        <th>Package</th>
                                        <th>Lending Amount</th>
                                        <th>Rease Date</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @if(count($userPack)>0)
                                            @foreach($userPack as $upKey=>$upVal)
                                                <tr>
                                                    <td>{{date_format(date_create($upVal->buy_date),'d-m-Y')}}</td>
                                                    <td>{{$upVal->name}}</td>
                                                    <td>{{$upVal->amount_increase}}</td>
                                                    <td>{{date_format(date_create($upVal->release_date),'m-d-Y')}}</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {!! Form::open(['action'=>'PackageController@invest','method'=>'post','id'=>'bPackageF','style'=>'display:none']) !!}
                            <input type="hidden" id="packageId" name="packageId"/>
                            <input type="hidden" name="packageAmount" id="packageAmount"/>
                            <input type="hidden" id="walletId" name="walletId" />
                        {!! Form::close() !!}
                    </div>
                </div>


            </div>
        </div>

        
    </div>

    
@stop
@section('script')
	<script type="text/javascript">
		$(document).ready(function() {
		    
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



            //buyPackage
            $('#btnBuyPackageS1').click(function(){
                var walletType=parseFloat($('#wallet_type').val());
                switch(walletType)
                {
                    case 2:
                        $('#carcoin-info').css('display','inline-block');
                        $('#reinvest-info').css('display','none');
                    break;
                    case 3:
                        $('#carcoin-info').css('display','none');
                        $('#reinvest-info').css('display','inline-block');
                    break;
                    default:
                        swal('','Please select wallet to buy packages!','error');
                        return false;
                    break;
                }
                $('#walletId').val(walletType);
                $('#modBuyPackage').modal('show');
            });

            $('#btnBuyPackage').click(function(){
                var pricing=jQuery('.card-raised');
                let packageId=pricing.children().find('input[type="radio"]').val();
                let minAmount=parseFloat(pricing.children().find('input[type="radio"]').attr('data-min'));
                let maxAmount=parseFloat(pricing.children().find('input[type="radio"]').attr('data-max'));
                let amount=pricing.children().find('input[type="number"]').val();
                if(amount<minAmount || amount>maxAmount)
                {
                    pricing.children().find('.errorAmount').text(''+minAmount+'CAR - '+maxAmount+'CAR');
                    pricing.children().find('.label-floating').addClass('has-error');
                    pricing.children().find('input[type="number"]').focus();
                    return false;
                }
                pricing.children().find('.errorAmount').text('');


                if(!$('#term').is(':checked'))
                {
                    $('.termAgree').css('display','block');
                    return false;
                }
                $('.termAgree').css('display','none');



                //alert(packageId+' - '+minAmount+' - '+maxAmount+' - '+amount);
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
                    $('#bPackageF').submit();
                })


            });

            $('#modBuyPackage').on('hidden.bs.modal', function () {
                jQuery('[section="buy-package"] .amount input[type="number"]').val('');
                $('#term').prop('checked',false);
            });

		});
	</script>
@stop

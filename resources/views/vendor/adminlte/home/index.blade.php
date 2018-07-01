@extends('adminlte::layouts.backend')
@section('contentheader_title')
{{ trans('adminlte_lang::home.dashboard') }}
@endsection

@section('content')
    <style type="text/css">
        .card-marketing{
            padding:8px !important;
        }
        .level-ticket .card {
            /*margin-top: 10px !important;*/
            margin-bottom: -15px !important;
        }
    </style>
	<div class="content">
        <div id="popup" style="display: none">
            <a href="{{ asset('img/popup/Maldives_Incentive_Trip.jpg') }}" data-lightbox="image-1" data-title="Maldives Incentive Trip" class="example-image-link" >Image #1</a>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-earning">
                                <div class="card-header text-center">
                                    <span class="glyphicon glyphicon-restart" aria-hidden="true"></span>
                                </div>
                                <div class="card-content text-center">
                                    <p class="mt-4 mb-0">Last week fast start bonus</p>
                                    <p class="h5 mt-3">${{number_format($data['PreAgencyCommission'],2)}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-earning">
                                <div class="card-header text-center">
                                    <span class="glyphicon glyphicon-money" aria-hidden="true"></span>
                                </div>
                                <div class="card-content text-center">
                                    <p class="mt-4 mb-0">Last week retail / unilevel bonus</p>
                                    <p class="h5 mt-3"><span class="glyphicon glyphicon-bitcoin"></span>{{number_format($data['PreTicketCommission'],2)}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-earning">
                                <div class="card-header text-center">
                                    <span class="glyphicon glyphicon-wallet" aria-hidden="true"></span>
                                </div>
                                <div class="card-content text-center">
                                    <p class="mt-4 mb-0">Last week infinity bonus</p>
                                    <p class="h5 mt-3">${{number_format($data['PreBinaryCommission'],2)}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-earning">
                                <div class="card-header text-center">
                                    <span class="glyphicon glyphicon-wallet" aria-hidden="true"></span>
                                </div>
                                <div class="card-content text-center">
                                    <p class="mt-4 mb-0">Your tickets this week</p>
                                    <p class="h5 mt-3">{{number_format($ticketThisWeek)}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="card card-marketing">
                                <div class="card-header text-center">
                                    <h3>MARKETING</h3>
                                </div>
                                <div class="clearfix"></div>
                                <div class="card-content text-center">
                                    <form>
                                        <div class="input-group form-group">
                                            <div class="form-group label-floating">
                                                <label class="control-label">{{ trans('adminlte_lang::profile.my_referal_link') }}</label>
                                                <input type="text" id="ref_link" class="form-control" value="{{ route('user.ref', Auth::user()->name) }}">
                                                <span class="material-input"></span>
                                            </div>
                                            <span class="input-group-addon">
                                                <button type="button" class="btn btn-primary btn-round btn-fab btn-fab-mini btn_ref_link" data-clipboard-target="#ref_link">
                                                    <i class="material-icons">content_copy</i>
                                                </button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>  
            </div>


            <div class="row">
                <div class="col-md-6 level-ticket">
                    <!-- <div class="row"> -->
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="card card-earning">
                                <div class="card-header text-center">
                                    <span class="glyphicon glyphicon-money" aria-hidden="true"></span>
                                </div>
                                <div class="card-content text-center">
                                    <p class="mt-4 mb-0">Direct ticket</p>
                                    <p class="h5 mt-3">{{number_format($directSale)}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="card card-earning">
                                <div class="card-header text-center">
                                    <span class="glyphicon glyphicon-money" aria-hidden="true"></span>
                                </div>
                                <div class="card-content text-center">
                                    <p class="mt-4 mb-0">Level 1 tickets</p>
                                    <p class="h5 mt-3">{{number_format($levelRevenue['f1'])}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="card card-earning">
                                <div class="card-header text-center">
                                    <span class="glyphicon glyphicon-money" aria-hidden="true"></span>
                                </div>
                                <div class="card-content text-center">
                                    <p class="mt-4 mb-0">Level 2 tickets</p>
                                    <p class="h5 mt-3">{{number_format($levelRevenue['f2'])}}</p>
                                </div>
                            </div>
                        </div>
                    <!-- </div> -->
                    <!-- <div class="row"> -->
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="card card-earning">
                                <div class="card-header text-center">
                                    <span class="glyphicon glyphicon-money" aria-hidden="true"></span>
                                </div>
                                <div class="card-content text-center">
                                    <p class="mt-4 mb-0">Level 3 tickets</p>
                                    <p class="h5 mt-3">{{number_format($levelRevenue['f3'])}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="card card-earning">
                                <div class="card-header text-center">
                                    <span class="glyphicon glyphicon-money" aria-hidden="true"></span>
                                </div>
                                <div class="card-content text-center">
                                    <p class="mt-4 mb-0">Level 4 tickets</p>
                                    <p class="h5 mt-3">{{number_format($levelRevenue['f4'])}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="card card-earning">
                                <div class="card-header text-center">
                                    <span class="glyphicon glyphicon-money" aria-hidden="true"></span>
                                </div>
                                <div class="card-content text-center">
                                    <p class="mt-4 mb-0">Level 5 tickets</p>
                                    <p class="h5 mt-3">{{number_format($levelRevenue['f5'])}}</p>
                                </div>
                            </div>
                        </div>
                    <!-- </div> -->
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="carcoin-primary-1">
                            <i class="material-icons">history</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">Agency information</h4>
                            <div class="table-responsive table-scroll-y">
                                <table class="table" id="tbHLending">
                                    <thead class="text-thirdary">
                                        <th>Date</th>
                                        <th>Package</th>
                                        <!-- <th>Lending</th> -->
                                        <th>Holding Amount</th>
                                        <th>Status</th>

                                    </thead>
                                    <tbody style="height: 179px;">
                                    	@if(count($data['history_package'])>0)
                                    		@foreach($data['history_package'] as $pkey=>$pval)
												<tr>
		                                            <td>{{date_format(date_create($pval->buy_date),'d-m-Y')}}</td>
		                                            <td>{{$pval->name}}</td>
		                                            <td>${{number_format($pval->amount_increase)}}</td>
                                                    <td>
                                                        @if($pval->withdraw==1)
                                                            <button class="btn btn-simple btn-google m-0 p-0">Released</button>
                                                        @else
                                                            <button class="btn btn-simple btn-linkedin m-0 p-0">Holding</button>
                                                        @endif
                                                    </td>
		                                        </tr>
                                    		@endforeach
                                    	@endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop
@section('script')
    @if(config('app.enable_popup'))
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"></script>
    <script>
        $(document).ready(function() {
            lightbox.start($('.example-image-link'));
        });
    </script>
    @endif
	<script type="text/javascript">
		jQuery(document).ready(function($){
			//section ref_link
			$('.btn_ref_link').tooltip({
                trigger: 'click',
                placement: 'left'
            });
            
            function setTooltip(message) {
                $('.btn_ref_link')
                  .attr('data-original-title', message)
                  .tooltip('show');
            }
            
            function hideTooltip() {
                setTimeout(function() {
                  $('button').tooltip('hide');
                }, 1000);
              }
            
            var clipboard = new Clipboard('.btn_ref_link');
            clipboard.on('success', function(e) {
                e.clearSelection();
                setTooltip('Copied!');
                hideTooltip();
            });
            //end section ref_link
            
            $('#tbHLending').DataTable({
                ordering: false,
                searching:false,
                bLengthChange: false,
            });

		});
	</script>
@stop
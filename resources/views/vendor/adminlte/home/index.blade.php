@extends('adminlte::layouts.backend')
@section('contentheader_title')
{{ trans('adminlte_lang::home.dashboard') }}
@endsection

@section('content')
	<div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-earning">
                                <div class="card-header text-center">
                                    <span class="glyphicon glyphicon-restart" aria-hidden="true"></span>
                                </div>
                                <div class="card-content text-center">
                                    <p class="mt-4 mb-0">Today Interest</p>
                                    <p class="h2 mt-3">${{$todayInterest}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-earning">
                                <div class="card-header text-center">
                                    <span class="glyphicon glyphicon-money" aria-hidden="true"></span>
                                </div>
                                <div class="card-content text-center">
                                    <p class="mt-4 mb-0">Today Earning</p>
                                    <p class="h2 mt-3">${{$data['today_earning']}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-earning">
                                <div class="card-header text-center">
                                    <span class="glyphicon glyphicon-wallet" aria-hidden="true"></span>
                                </div>
                                <div class="card-content text-center">
                                    <p class="mt-4 mb-0">Total Earning</p>
                                    <p class="h2 mt-3">${{$data['total_bonus']}}</p>
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
                <div class="col-md-6">
                    <div class="card card-generational">
                        <div class="card-header card-header-icon" data-background-color="carcoin-primary-1">
                            <i class="material-icons">ac_unit</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">Generational Volume</h4>
                            <div class="generational">
                                <div class="row">
                                    <div class="col-sm-6 col-lg-6">
                                        <div class="left">
                                            <div class="icon" rel="tooltip" data-placement="left" title="Left">
                                                L
                                            </div>
                                            <p class="h2 mt-5">${{number_format($ttSale['left'],0)}}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-6">
                                        <div class="right">
                                            <div class="icon" rel="tooltip" data-placement="right" title="Right">
                                                R
                                            </div>
                                            <p class="h2 mt-5">${{number_format($ttSale['right'],0)}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="carcoin-primary-1">
                            <i class="material-icons">history</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">History Lending</h4>
                            <div class="table-responsive table-scroll-y">
                                <table class="table" id="tbHLending">
                                    <thead class="text-thirdary">
                                        <th>Date</th>
                                        <th>Package</th>
                                        <!-- <th>Lending</th> -->
                                        <th>Lending Amount</th>
                                        <th>Release Date</th>
                                        <th>Status</th>
                                    </thead>
                                    <tbody style="height: 179px;">
                                    	@if(count($data['history_package'])>0)
                                    		@foreach($data['history_package'] as $pkey=>$pval)
												<tr>
		                                            <td>{{date_format(date_create($pval->buy_date),'d-m-Y')}}</td>
		                                            <td>{{$pval->name}}</td>
		                                            <td>{{$pval->amount_increase}}</td>
                                                    <td>{{date_format(date_create($pval->release_date),'d-m-Y')}}</td>
                                                    <td>
                                                        @if($pval->withdraw==1)
                                                            <button class="btn btn-simple btn-google m-0 p-0">Withdrawn</button>
                                                        @else
                                                            <button class="btn btn-simple btn-linkedin m-0 p-0">Waiting</button>
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
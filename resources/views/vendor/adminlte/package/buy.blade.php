@extends('adminlte::layouts.backend')
@section('htmlheader_title')
	{{ trans('adminlte_lang::package.header_title') }}
@endsection

@section('content')
	<div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" section="buy-package">
                        <div class="card-header">
                            <h3 class="card-title text-center">Pick the best package for you
                        </h3>
                        </div>
                        <div class="card-content clearfix">
                            @if(count($package)>0)
                                @foreach($package as $pkey=>$pval)
                                    <div class="col-md-3">
                                        <div class="card card-pricing  <?=$pkey==0?'card-raised':''?>">
                                            <div class="card-content p-0">
                                                <div class="icon <?=$pkey==0?'active':''?>">
                                                    <h3 style="text-transform: uppercase;">{{$pval->name}}</h3>
                                                    <div class="radio" big="md">
                                                        <label>
                                                            <input type="radio" name="optionsRadios" <?=$pkey==0?'checked="checked"':'' ?> value="{{$pval->pack_id}}" > 
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="card-description">
                                                    <span>
                                                        <b>${{$pval->min_price}} - ${{$pval->max_price}}</b>
                                                    </span>
                                                    <span class="carcoin-color">
                                                        <i class="material-icons" icon="carcoin-primary"></i>
                                                        <b>0.0857</b> - <b>1.0857</b>
                                                    </span>
                                                </div>
                                                <div class="card-action">
                                                    <div class="input-group form-group my-4 amount">
                                                        <span class="input-group-addon pr-0">
                                                            <i class="material-icons">attach_money</i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Your Amount</label>
                                                            <input name="lastname" type="number" class="form-control" min="200" max="1000">
                                                            <span class="material-input"></span></div>
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
                                        <input type="checkbox">
                                        <a href="/package-term-condition.html" target="_blank">I agree to the terms and condition.</a>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary btn-round">Buy</button>
                        </div>

                        <div class="col-md-12 my-4">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-thirdary">
                                        <th>Date</th>
                                        <th>Package</th>
                                        <th>Lending Amount</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>2017/11/28</td>
                                            <td>Medium</td>
                                            <td>0.399</td>
                                        </tr>
                                        <tr>
                                            <td>2017/11/28</td>
                                            <td>Large</td>
                                            <td>0.368</td>
                                        </tr>
                                        <tr>
                                            <td>2017/11/28</td>
                                            <td>Small</td>
                                            <td>0.366</td>
                                        </tr>
                                        <tr>
                                            <td>2017/11/28</td>
                                            <td>Medium</td>
                                            <td>0.366</td>
                                        </tr>
                                        <tr>
                                            <td>2017/11/28</td>
                                            <td>Medium</td>
                                            <td>0.366</td>
                                        </tr>
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
		$(document).ready(function() {
		    
		    $('[section="buy-package"] .amount input[type="text"]').val()
		    $('[name="optionsRadios"]').click(function() {
		        $('[section="buy-package"] .icon').each(function(index, el) {
		            $(el).hasClass('active') ? $(el).removeClass('active') : $(el);
		        });

		        $('[section="buy-package"] .card-pricing').each(function(index, el) {
		            $(el).hasClass('card-raised') ? $(el).removeClass('card-raised') : $(el);
		        });

		        $(this).closest('.card').find('.icon').addClass('active');
		        $(this).closest('.card').addClass('card-raised');
		    });
		});
	</script>
@stop

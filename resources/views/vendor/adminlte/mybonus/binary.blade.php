@extends('adminlte::layouts.backend')

@section('contentheader_title')
	{{ trans('adminlte_lang::mybonus.binary') }}
@endsection

@section('content')
	<div class="content">
		<div class="container-fluid">
			<div class="col-md-12 align-self-center">
				<div class="card">
					<div class="card-header card-header-icon" data-background-color="carcoin-primary-1">
	                    <i class="material-icons">card_giftcard</i>
	                </div>
	                <div class="card-content">
	                	<h4 class="card-title">Infinity Bonus</h4>
	                	<div class=""><!--table-responsive table-scroll-y-->
	                		<div id="employee-grid_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
	                			<div class="row">
	                                <div class="col-sm-6"></div>
	                                <div class="col-sm-6"></div>
	                            </div>
	                		</div>
	                		<div class="row">
	                			<div class="col-sm-12">
	                				<table class="table dataTable no-footer" id="referrals-grid" role="grid" aria-describedby="employee-grid_info">
	                					<thead class="text-thirdary">
	                						<tr>
	                							<th>{{ trans('adminlte_lang::mybonus.week') }}</th>
												<th>{{ trans('adminlte_lang::mybonus.lopen') }}</th>
												<th>{{ trans('adminlte_lang::mybonus.ropen') }}</th>
												<th>{{ trans('adminlte_lang::mybonus.lnew') }}</th>
												<th>{{ trans('adminlte_lang::mybonus.rnew') }}</th>
												<th>{{ trans('adminlte_lang::mybonus.lover') }}</th>
												<th>{{ trans('adminlte_lang::mybonus.rover') }}</th>
												<th>{{ trans('adminlte_lang::mybonus.settled') }}</th>
												<th>{{ trans('adminlte_lang::mybonus.bonus') }}</th>
												<th>{{ trans('adminlte_lang::mybonus.reinvest') }}</th>
												<th>{{ trans('adminlte_lang::mybonus.transfer_withdraw') }}</th>
	                						</tr>
	                					</thead>
	                					<tbody>
	                						@foreach ($binarys as $binary)
											<tr>
												<td>{{ date( "Y/m/d", strtotime($binary->year."W".$binary->weeked."1")) }} - {{ date( "Y/m/d", strtotime($binary->year."W".$binary->weeked."7")) }}</td>
												<td>{{ number_format($binary->leftOpen, 2) }}</td>
												<td>{{ number_format($binary->rightOpen,2) }}</td>
												<td>{{ number_format($binary->leftNew, 2) }}</td>
												<td>{{ number_format($binary->rightNew, 2) }}</td>
												<td>{{ number_format($binary->leftOpen + $binary->leftNew, 2) }}</td>
												<td>{{ number_format($binary->rightOpen + $binary->rightNew, 2) }}</td>
												<td>{{ number_format($binary->settled, 2) }}</td>
												<td>{{ number_format($binary->bonus, 2) }}</td>
												<td>{{ $binary->bonus > 0 ? number_format(($binary->bonus*40/100), 2) : '' }}</td>
												<td>{{ $binary->bonus > 0 ? number_format(($binary->bonus*60/100), 2) : '' }}</td>
											</tr>
											@endforeach
	                					</tbody>
	                				</table>
	                			</div>
	                		</div>
	                	</div>
	                </div>
				</div>
			</div>
		</div>
	</div>
@endsection
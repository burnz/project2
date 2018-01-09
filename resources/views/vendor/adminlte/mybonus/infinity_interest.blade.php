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
	                	<h4 class="card-title">Infinity Interest Bonus</h4>
	                		<div class="row">
	                				<div class="table-responsive">
	                			<div class="col-sm-12">
	                				<table class="table no-footer" id="referrals-grid" role="grid" aria-describedby="employee-grid_info">
	                					<thead class="text-thirdary">
	                						<tr>
	                							<th>{{ trans('adminlte_lang::mybonus.week') }}</th>
												<th>{{ trans('adminlte_lang::mybonus.lopen') }}</th>
												<th>{{ trans('adminlte_lang::mybonus.ropen') }}</th>
												<th>{{ trans('adminlte_lang::mybonus.lnew') }}</th>
												<th>{{ trans('adminlte_lang::mybonus.rnew') }}</th>
												<th>{{ trans('adminlte_lang::mybonus.bonus') }}</th>
												<th>{{ trans('adminlte_lang::mybonus.reinvest') }}</th>
												<th>{{ trans('adminlte_lang::mybonus.transfer_withdraw') }}</th>
	                						</tr>
	                					</thead>
	                					<tbody>
	                						@foreach ($binarys as $binary)
											<tr>
												<td>{{ date( "Y/m/d", strtotime(substr($binary->weekYear,0,4)."W".substr($binary->weekYear,-2)."1")) }} - {{ date( "Y/m/d", strtotime(substr($binary->weekYear,0,4)."W".substr($binary->weekYear,-2)."7")) }}</td>
												<td>{{ number_format($binary->leftOpen, 2) }}</td>
												<td>{{ number_format($binary->rightOpen,2) }}</td>
												<td>{{ number_format($binary->leftNew, 2) }}</td>
												<td>{{ number_format($binary->rightNew, 2) }}</td>
												
												<td>{{ number_format($binary->bonus, 2) }}</td>
												<td>{{ $binary->bonus >= 0 ? number_format(($binary->bonus*40/100), 2) : '' }}</td>
												<td>{{ $binary->bonus >= 0 ? number_format(($binary->bonus*60/100), 2) : '' }}</td>
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
@section('script')
	<script type="text/javascript">
		$('#referrals-grid').DataTable({
            "ordering": false,
            "searching":false,
            "bLengthChange": false,
        });
	</script>
@stop
@extends('adminlte::layouts.backend')

@section('contentheader_title')
	{{ trans('adminlte_lang::mybonus.binary') }}
@endsection


@section('content')
	<style type="text/css">
		.pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
    background-color: #ee2229;
    border-color: #9c27b0;
    color: #FFFFFF;
    box-shadow: 0 14px 26px -12px rgba(238, 34, 41, 0.42), 0 4px 23px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(238, 34, 41, 0.2);
}
	</style>
	<div class="content">
		<div class="container-fluid">
			<div class="col-md-12 align-self-center">
				<div class="card">
					<div class="card-header card-header-icon" data-background-color="carcoin-primary-1">
	                    <i class="material-icons">card_giftcard</i>
	                </div>
	                <div class="card-content">
	                	<h4 class="card-title">Infinity Bonus</h4>
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
												<th>{{ trans('adminlte_lang::mybonus.lover') }}</th>
												<th>{{ trans('adminlte_lang::mybonus.rover') }}</th>
												<th>{{ trans('adminlte_lang::mybonus.settled') }}</th>
												<th>{{ trans('adminlte_lang::mybonus.bonus') }}</th>
	                						</tr>
	                					</thead>
	                					<tbody>
	                						@foreach ($binarys as $binary)
											<tr>
												<td>{{ date( "Y/m/d", strtotime($binary->year."W".(strlen($binary->weeked)==1?"0".$binary->weeked:$binary->weeked)."1" . "- 1 days")) }} - {{ date( "Y/m/d", strtotime($binary->year."W".(strlen($binary->weeked)==1?"0".$binary->weeked:$binary->weeked)."7" . "- 1 days")) }}</td>
												
												<td>{{ number_format($binary->leftOpen, 2) }}</td>
												<td>{{ number_format($binary->rightOpen,2) }}</td>
												<td>{{ number_format($binary->leftNew, 2) }}</td>
												<td>{{ number_format($binary->rightNew, 2) }}</td>
												<td>{{ number_format($binary->leftOpen + $binary->leftNew, 2) }}</td>
												<td>{{ number_format($binary->rightOpen + $binary->rightNew, 2) }}</td>
												<td>{{ number_format($binary->settled, 2) }}</td>
												<td>{{ number_format($binary->bonus, 2) }}</td>
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
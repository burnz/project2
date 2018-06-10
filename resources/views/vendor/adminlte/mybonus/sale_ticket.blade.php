@extends('adminlte::layouts.backend')

@section('contentheader_title')
	{{ trans('adminlte_lang::mybonus.binary') }}
@endsection


@section('content')
<style type="text/css">
	table a:link, table a:visited {
	    color: #31728F;
	    text-decoration: underline;
	}
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
	                	<h4 class="card-title">Ticket Bonus History</h4>
	                		<div class="row">
	                				<div class="table-responsive">
	                			<div class="col-sm-12">
	                				<table class="table no-footer" id="referrals-grid" role="grid" aria-describedby="employee-grid_info">
	                					<thead class="text-thirdary">
	                						<tr>
	                							<th>{{ trans('adminlte_lang::mybonus.week') }}</th>
												<th>Level 1</th>
												<th>Level 2</th>
												<th>Level 3</th>
												<th>Level 4</th>
												<th>Level 5</th>
												<th>Total</th>
	                						</tr>
	                					</thead>
	                					<tbody>
	                						@foreach ($binarys as $binary)
											<tr>
												<td>{{ date( "Y/m/d", strtotime(substr($binary->week_year,0,4)."W".substr($binary->week_year,-2)."1")) }} - {{ date( "Y/m/d", strtotime(substr($binary->week_year,0,4)."W".substr($binary->week_year,-2)."7")) }}</td>
												<td><a href="{{ URL::to('week/tickets/level/1') }}">{{ number_format($binary->level_1) }}</a></td>
												<td><a href="{{ URL::to('week/tickets/level/2') }}">{{ number_format($binary->level_2) }}</a></td>
												<td><a href="{{ URL::to('week/tickets/level/3') }}">{{ number_format($binary->level_3) }}</a></td>
												<td><a href="{{ URL::to('week/tickets/level/4') }}">{{ number_format($binary->level_4) }}</a></td>
												<td><a href="{{ URL::to('week/tickets/level/5') }}">{{ number_format($binary->level_5) }}</a></td>
												<td>{{ number_format($binary->total) }}</td>
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
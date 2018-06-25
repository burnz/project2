@extends('adminlte::layouts.backend')

@section('contentheader_title')
	Agency Commission
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
	                	<h4 class="card-title">Fast Start Bonus History</h4>
	                		<div class="row">
	                				<div class="table-responsive">
	                			<div class="col-sm-12">
	                				<table class="table no-footer" id="referrals-grid" role="grid" aria-describedby="employee-grid_info">
	                					<thead class="text-thirdary">
	                						<tr>
	                							<th>{{ trans('adminlte_lang::mybonus.date_time') }}</th>
												<th>Level</th>
												<th>Agency</th>
					                            <th>{{ trans('adminlte_lang::mybonus.package') }}</th>
												<th>{{ trans('adminlte_lang::mybonus.amount') }}</th>
	                						</tr>
	                					</thead>
	                					<tbody>
	                						@foreach ($fastStarts as $key => $fastStart)
												<tr>
													<td>{{ $fastStart->created_at }}</td>
													<td>{{ $fastStart->generation }}</td>
													<td>{{ $fastStart->users->name }}</td>
													<td>{{ $fastStart->package->name }}</td>
													<td>{{ number_format($fastStart->amount, 2) }}</td>
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

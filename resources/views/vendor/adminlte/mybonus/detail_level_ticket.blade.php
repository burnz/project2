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
	                	<h4 class="card-title">Ticket Bonus History - Detail Level</h4>
	                		<div class="row">
	                				<div class="table-responsive">
	                			<div class="col-sm-12">
	                				<table class="table no-footer" id="referrals-grid" role="grid" aria-describedby="employee-grid_info">
	                					<thead class="text-thirdary">
	                						<tr>
	                							<th>{{ trans('adminlte_lang::mybonus.week') }}</th>
	                							<th>ID</th>
												<th>Username</th>
												<th>Level</th>
												<th>Quantity</th>
												<th>%</th>
												<th>Commission</th>
	                						</tr>
	                					</thead>
	                					<tbody>
	                						@foreach ($binarys as $binary)
											<tr>
												<td>{{ date( "Y/m/d", strtotime(substr($binary->week_year,0,4)."W".substr($binary->week_year,-2)."1")) }} - {{ date( "Y/m/d", strtotime(substr($binary->week_year,0,4)."W".substr($binary->week_year,-2)."7")) }}</td>
												<td>{{$binary->user->uid}}</td>
												<td>{{$binary->user->name}}</td>
												<td>{{$level}}</td>
												<td>{{$binary->quantity}}</td>
												<td>{{ $percent }}</td>
												<td>{{ $binary->quantity * $percent / 100 }}</td>
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
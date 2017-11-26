@extends('adminlte::layouts.member')

@section('contentheader_title')
	{{ trans('adminlte_lang::member.genealogy') }}
@endsection

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<div class="col-sm-3 no-padding">
						<div class="input-group input-group-sm">
							<input type="text" class="form-control" id="search-input" placeholder="{{ trans('adminlte_lang::member.refferals_username') }}">
							<span class="input-group-btn">
								<button type="button" id="search-button" class="btn btn-primary btn-flat" ><i class="fa fa-search"></i> {{ trans('adminlte_lang::member.btn_search') }}</button>
							</span>
						</div>
					</div>
				</div>
				<div class="box-body" style="padding-top:0;">
					<div id="genealogy-container" style="min-width: 150px; min-height: 100px;"></div>
				</div>
			</div>
		</div>
	</div>
	<link rel="stylesheet" href="{{ asset('/css/jstree.css') }}" />
	<script src="{{ asset('/js/jstree.js') }}"></script>
	<script src="{{ asset('/js/jstreetable.js') }}"></script>
    <script src="{{ asset('/js/genealogy.js') }}"></script>
@endsection
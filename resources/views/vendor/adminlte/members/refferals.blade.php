@extends('adminlte::layouts.backend')

@section('contentheader_title')
{{ trans('adminlte_lang::member.refferals') }}
@endsection

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row d-flex" section="dashboard-status">
            <h3 class="m-0"></h3>
            <div class="" style="width:100%">


            <div class="card">
                    <!-- <div class="card-header card-header-icon" data-background-color="carcoin-primary-1">
                        <i class="material-icons">assignment</i>
                    </div> -->
                    <div class="card-content">
                        <h3 class="card-title">Referrals</h3>
                        <div class="table-responsive">
                        <table class="table dataTable">
                            <tr>
                                <th>{{ trans('adminlte_lang::member.refferals_no') }}</th>
                                <th>{{ trans('adminlte_lang::member.refferals_id') }}</th>
                                <th>{{ trans('adminlte_lang::member.refferals_username') }}</th>
                                <th>{{ trans('adminlte_lang::member.refferals_fullname') }}</th>
                                <th>{{ trans('adminlte_lang::member.refferals_package') }}</th>
                                <th>{{ trans('adminlte_lang::member.refferals_more') }}</th>
                                <th>{{ trans('adminlte_lang::member.refferals_loyalty') }}</th>
                            </tr>
                            <tbody>
                                @php
                                $i = 1
                                @endphp
                                @foreach ($users as $userData)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $userData->user->uid }}</td>
                                    <td>{{ $userData->user->name }}</td>
                                    <td>{{ $userData->user->name }}</td>
                                    <td class="text-uppercase">{{ $userData->package->name }}</td>
                                    <td>
                                        <a href="{{ URL::to('members/referrals/'.$userData->user->uid.'/detail') }}" class="btn btn-xs btn-info pull-left" style="margin-right: 3px;margin-top: 1px;">{{ trans('adminlte_lang::default.btn_view') }}</a>
                                    </td>
                                    <td>
                                        @if($userData->loyaltyId >0 )
                                        {{ config('cryptolanding.listLoyalty')[$userData->loyaltyId] }}
                                        @endif
                                    </td>
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

@endsection
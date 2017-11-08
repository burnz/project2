@extends('adminlte::layouts.member')

@section('contentheader_title')
{{ trans('adminlte_lang::member.refferals') }}
@endsection

@section('main-content')
<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="card">
            {{--<div class="card-header">--}}

            {{--</div>--}}
            <div class="card-body" style="padding-top:0;">
                <h4 class="card-title">Referrals Table</h4>
                <h6 class="card-subtitle">7 column</h6>
                <div class="table-responsive">
                    <table class="table color-table success-table dataTable">
                        <thead>
                            <tr>
                                <th>{{ trans('adminlte_lang::member.refferals_no') }}</th>
                                <th>{{ trans('adminlte_lang::member.refferals_id') }}</th>
                                <th>{{ trans('adminlte_lang::member.refferals_username') }}</th>
                                <th>{{ trans('adminlte_lang::member.refferals_fullname') }}</th>
                                <th>{{ trans('adminlte_lang::member.refferals_package') }}</th>
                                <th>{{ trans('adminlte_lang::member.refferals_more') }}</th>
                                <th>{{ trans('adminlte_lang::member.refferals_loyalty') }}</th>
                            </tr>
                        </thead>
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
@endsection
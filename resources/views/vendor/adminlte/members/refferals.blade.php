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
                                <th>{{ trans('adminlte_lang::member.action') }}</th>
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
                                <td class="action-push-lr">
                                    <div id="action-push-lr-{{ $userData->user->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                {!! Form::open(['url' => url('members/pushIntoTree'), 'id' => 'pushIntoTreeForm']) !!}
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Push into tree</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                        <div class="form-group">
                                                            <div class="radio-list">
                                                                <label class="custom-control custom-radio">
                                                                    <input id="radio3" name="radio" type="radio" checked="" class="custom-control-input">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span class="custom-control-description">Push to left</span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input id="radio4" name="radio" type="radio" class="custom-control-input">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span class="custom-control-description">Push to right</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    <input type="hidden" name="legpos" id="legpos" value="1">
                                                    <input type="hidden" name="userSelect" value="{{ $userData->user->id }}">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger waves-effect waves-light">Save and push</button>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                    <button data-toggle="modal" data-target="#action-push-lr-{{ $userData->user->id }}"
                                            class="btn btn-default btn-info"
                                            title="Push left and push right">Push into tree</button>

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
@section('script')
    <script src="{{ url('js/refferals/index.js') }}"></script>
@endsection
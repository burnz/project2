@extends('adminlte::layouts.member')

@section('contentheader_title')
    {{ trans('adminlte_lang::default.buy_package') }}
@endsection

@section('main-content')
    <style>
        #myTable tbody tr:hover {
            background-color: #f5f5f5;
            cursor : pointer;
        }

        tr.selected {
            background-color: #5bc0de !important;
        }

        tr.checked {
            background-color: #d9edf7 !important;
        }
    </style>
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Mining Package</div>
                    {{ Form::open(array('url' => 'packages/invest', 'id'=>'formPackage')) }}
                    <div class="row">
                        <div class="col-lg-3">
                            <input type="number" id="amount_lending" name="amount_lending" class="form-control"
                                   placeholder="Lending Amount" autofocus="autofocus">
                        </div>
                        <div class="col-lg-3">
                            <input type="text" id="amount_convert" name=""  class="form-control" disabled>
                        </div>
                    </div>
                    <span class="error-mining-package " style="color: red;"></span>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="msg_package"></div>
                            <div class="table-responsive" id="">
                                <table class="table color-table success-table dataTable" id="myTable">
                                    <thead>
                                    <tr id="table_th">
                                        <th>{{ trans('adminlte_lang::package.name') }}</th>
                                        <th>{{ trans('adminlte_lang::package.price') }}</th>
                                        <th>{{ trans('adminlte_lang::package.clp_coin') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($packages as $package)
                                        <tr{{ Auth::user()->userData->packageId > 0 && $package->id == Auth::user()->userData->packageId ?  ' class=checked':'' }} data-id="{{ $package->pack_id }}">
                                        <td>{{ $package->name }}</td>
                                        <td><i class="fa fa-usd"></i>{{ number_format($package->min_price) }}-{{ number_format($package->max_price) }}</td>
                                        <td><span class="icon-clp-icon"></span>{{ number_format($package->price / App\ExchangeRate::getCLPUSDRate(), 2, '.', ',') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-5">
                            <label for="termsPackage">
                                <div class="checkbox_register icheck">
                                    <input type="checkbox" name="terms" id="termsPackage">
                                    <a href="/package-term-condition.html" target="_blank">Term and condition</a>
                                </div>
                            </label>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <input type="hidden" name="packageId" id="packageId"
                                   value="{{ Auth::user()->userData->packageId }}">
                            @if( date('Y-m-d') > date('Y-m-d', strtotime(config('app.pre_sale_end'))) )
                                <button class="btn btn-primary btn-block"
                                        id="btn_submit" type="button">{{ trans('adminlte_lang::wallet.buy_package') }}</button>
                            @else
                                <button class="btn btn-primary btn-block"
                                        id="btn_submit" disabled="true" type="button">{{ trans('adminlte_lang::wallet.buy_package') }}</button>
                            @endif
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        var packageId = {{ Auth::user()->userData->packageId }};
        var packageIdPick = packageId;
    </script>
    <script src="{{ url('js/buy_package/index.js') }}"></script>
@endsection
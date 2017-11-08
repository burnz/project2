@extends('adminlte::layouts.member')

@section('contentheader_title')
    {{ trans('adminlte_lang::default.buy_package') }}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <div class="card">
                <div class="card-body">
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
        </div>
    </div>
@endsection

@section('script')

@endsection
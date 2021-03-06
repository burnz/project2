@extends('adminlte::layouts.errors')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.servererror') }}
@endsection

@section('main-content')

    <div class="error-page">
        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> Oops! {{ trans('adminlte_lang::message.somethingwrong') }}</h3>
            <p>
                {{ trans('adminlte_lang::message.wewillwork') }}
                {{ trans('adminlte_lang::message.mainwhile') }} <a href='{{ url('/home') }}'>{{ trans('adminlte_lang::message.returndashboard') }}</a>
            </p>
        </div>
    </div><!-- /.error-page -->
@endsection
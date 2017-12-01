@extends('adminlte::layouts.member')

@section('contentheader_title')
    {{ trans('adminlte_lang::wallet.clp') }}
@endsection

@section('main-content')
    <div id="app">
        <Clp></Clp>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/clp.js') }}"></script>
@endsection
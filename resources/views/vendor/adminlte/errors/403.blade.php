@extends('adminlte::layouts.errors')
@section('title')
{{ trans('adminlte_lang::message.pagenotfound') }}
@stop
@section('content')

    <div class="main">
        <h3>
            403
        </h3>
        <h1> Oops! {{ trans('adminlte_lang::message.somethingwrong') }}</h1>
        <p>
            {{ trans('adminlte_lang::message.notfindpage') }}   
            <br/> 
            <span>{{ trans('adminlte_lang::message.mainwhile') }} <a href='{{ url("/") }}'>{{ trans('adminlte_lang::message.returndashboard') }}</a></span>
        </p> 
    </div>
@endsection
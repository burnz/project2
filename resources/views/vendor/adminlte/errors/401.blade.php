@extends('adminlte::layouts.errors')
@section('title')
{{ trans('adminlte_lang::message.somethingwrong') }}
@stop
@section('content')
    <div class="main">
        <h3>
            401
        </h3>
        <h1> Oops! {{ trans('adminlte_lang::message.somethingwrong') }}</h1>
        <p>
            {{ trans('adminlte_lang::message.wewillwork') }}   
            <br/> 
            <span>{{ trans('adminlte_lang::message.mainwhile') }} <a href='{{ url('/home') }}'>{{ trans('adminlte_lang::message.returndashboard') }}</a></span>
        </p> 
    </div>
@endsection
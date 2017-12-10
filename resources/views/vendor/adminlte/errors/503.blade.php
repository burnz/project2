@extends('adminlte::layouts.errors')
@section('title')
    {{ trans('adminlte_lang::message.serviceunavailable') }}
@endsection

@section('content')
	<div class="main">
        <h3>
            503
        </h3>
        <h1> {{trans('adminlte_lang::message.maintenance_mode')}} </h1>
        <p>
            {{ $message }}. @if($retryAfter) Please try back in {{ $retryAfter }} days @endif
        </p> 
    </div>
@endsection

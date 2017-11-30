@extends('adminlte::backend.layouts.member')

@section('contentheader_title')
    add min price
@endsection

@section('main-content')
    @if ( session()->has("errorMessage") )
        <div class="callout callout-danger">
            <h4>Warning!</h4>
            <p>{!! session("errorMessage") !!}</p>
        </div>
        {{ session()->forget('errorMessage') }}
    @elseif ( session()->has("successMessage") )
        <div class="callout callout-success">
            <h4>Success</h4>
            <p>{!! session("successMessage") !!}</p>
        </div>
        {{ session()->forget('successMessage') }}
    @else
        <div></div>
    @endif

    {{ Form::open(array('url' => 'ordermin'))}}
    <div class="form-group @if ($errors->has('date')) has-error @endif">
        {!! Form::label('date', 'Date') !!}
        {!! Form::date('date', null, ['class' => 'form-control', 'placeholder' => 'Date']) !!}
        @if ($errors->has('date')) <p class="help-block">{{ $errors->first('date') }}</p> @endif
    </div>
    <!-- Title of Post Form Input -->
    <div class="form-group @if ($errors->has('price')) has-error @endif">
        {!! Form::label('price', 'Price') !!}
        {!! Form::text('price', null, ['class' => 'form-control', 'placeholder' => 'Min Price']) !!}
        @if ($errors->has('title')) <p class="help-block">{{ $errors->first('price') }}</p> @endif
    </div>

    <div>
        {{ Form::submit(trans('adminlte_lang::news.add_button'), array('class' => 'btn btn-primary')) }}
    </div>
    {{ Form::close() }}
@endsection
<?php use App\News; ?>
@extends('adminlte::backend.layouts.member')

@section('contentheader_title')
    {{ trans('adminlte_lang::news.manage') }}
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
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr class="heading">
                <th>Number</th>
                <th>Title</th>
                <th>Short Description</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($news as $new)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $new->title }}</td>

                        <td>{!! $new->short_desc !!}</td>
                        <td>
                            <a href="/news/{{ $new->id }}/edit" class="btn btn-default glyphicon glyphicon-edit">Edit</a>
                            {{ Form::open(['method' => 'DELETE', 'route' => ['news.destroy', $new->id] ]) }}
                                {{ Form::hidden('id', $new->id) }}
                                {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {!! $news->links('pagination') !!}
    </div>
@endsection
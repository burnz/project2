@extends('adminlte::layouts.backend')
@section('htmlheader_title')
    {{ trans('adminlte_lang::package.header_title') }}
@endsection

@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" section="buy-package">
                        <div class="card-header">
                            <h2 class="card-title text-center">
                                News
                            </h2>
                        </div>
                        <div class="card-content clearfix">
                            @if(count($listNews)>0)
                                @foreach($listNews as $pkey => $news)
                                    <div class="col-md-3">
                                        <div class="card card-pricing card-raised">
                                            <div class="card-header">
                                                <div class="stats">
                                                    <i class="material-icons" data-background-color="carcoin-primary-1">info</i>
                                                    <p style="text-transform: uppercase; color: #009e00; margin-top: 20px;"><a href="/news/detail/{{$news->id}}">{{$news->title}}</a></p>
                                                </div>
                                            </div>
                                            <div class="card-content p-0">
                                                <p>
                                                    {{$news->short_desc}}
                                                </p>
                                            </div>
                                            <div class="card-footer" style="padding: 20px 0 5px;">
                                                <div class="stats">
                                                    <i class="material-icons">update</i> {{date_format(date_create($news->created_at),'Y-m-d')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-md-12">
                                    There are no new available
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
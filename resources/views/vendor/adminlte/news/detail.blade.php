@extends('adminlte::layouts.backend')
@section('htmlheader_title')
    {{ $data->title }}
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" section="buy-package">
                        <div class="card-header">
                            <h3 class="card-title text-center">
                                {{ $data->title }}
                            </h3>
                        </div>
                        <div class="card-content clearfix">
                            <div class="card card-plain card-raised">
                                <div class="card-header">

                                </div>
                                <div class="card-content p-0 content">
                                    <div class="icon active">
                                    </div>
                                    <div style="margin-left: 20px; margin-right: 20px">
                                        {!! $data->desc !!}
                                    </div>
                                </div>
                                <div class="card-footer" style="padding: 20px 0 5px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
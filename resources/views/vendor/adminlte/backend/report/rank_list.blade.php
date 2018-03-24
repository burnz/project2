@extends('adminlte::backend.layouts.member')

@section('contentheader_title')
    Rank List
@endsection

@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body" style="padding-top:0;">
                    <div class="result-set">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="data-table">
                            <thead>
                            <tr>
                                <th>Rank</th>
                                <th>List Username</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $key => $item)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>{{ $item }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </div>

@endsection
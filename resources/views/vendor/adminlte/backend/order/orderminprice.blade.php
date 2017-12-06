@extends('adminlte::backend.layouts.member')

@section('contentheader_title')
    orderminprice
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
    <div>
        <a href="ordermin/create" class="btn btn-default btn-success">Add</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr class="heading">
                <th>OrderDate</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($order as $orde)
                <tr>
                    <td>{{ $orde->order_date }}</td>
                    <td>{{ $orde->price }}</td>
                    <td>
                        <a href="/ordermin/{{ $orde->id }}/edit" class="btn btn-default glyphicon glyphicon-edit">Edit</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $order->links('pagination') !!}
    </div>
@endsection
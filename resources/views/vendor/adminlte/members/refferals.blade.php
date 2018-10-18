@extends('adminlte::layouts.backend')

@section('contentheader_title')
{{ trans('adminlte_lang::member.refferals') }}
@endsection

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="col-md-12 align-self-center">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="carcoin-primary-1">
                    <i class="material-icons">assignment</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Referrals</h4>
                    

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive"><!--table-responsive table-scroll-y-->
                                    <table class="table dataTable no-footer" id="referrals-grid" role="grid" aria-describedby="employee-grid_info">
                                        <thead class="text-thirdary">
                                        <tr>
                                            <th>{{ trans('adminlte_lang::member.refferals_no') }}</th>
                                            <th>{{ trans('adminlte_lang::member.refferals_id') }}</th>
                                            <th>{{ trans('adminlte_lang::member.refferals_username') }}</th>
                                            <th>{{ trans('adminlte_lang::member.refferals_fullname') }}</th>
                                            <th>Package</th>
                                            <th>{{ trans('adminlte_lang::member.refferals_more') }}</th>
                                            <!-- <th>Action</th> -->
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $i = 1
                                            @endphp
                                            @foreach ($users as $userData)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $userData->user->uid }}</td>
                                                <td>{{ $userData->user->name }}</td>
                                                <td>{{ $userData->user->name }}</td>
                                                <td class="text-uppercase">{{ isset($userData->package)?$userData->package->name:'Null' }}</td>
                                                <td>
                                                    <a href="{{ URL::to('members/referrals/'.$userData->user->uid.'/detail') }}" class="btn btn-xs btn-info pull-left" style="margin-right: 3px;margin-top: 1px;">{{ trans('adminlte_lang::default.btn_view') }}</a>
                                                </td>
                                                <!-- <td>
                                                    @if($userData->isBinary==0 && Auth::user()->userData->isBinary > 0)
                                                        <button type="button" class="btn btn-fill btn-xs btn-info btn-round btn_submit_left" data-name="{{$userData->user->name}}" data-select="{{$userData->userId}}">Push to Left</button>
                                                        <button type="button" class="btn btn-fill btn-xs btn-primary btn-round btn_submit_right" data-name="{{$userData->user->name}}" data-select="{{$userData->userId}}">Push to Right</button>
                                                    @else
                                                        <button type="button" class="btn btn-fill btn-xs btn-info btn-round btn_submit_left" disabled="true" >Push to Left</button>
                                                        <button type="button" class="btn btn-fill btn-xs btn-primary btn-round btn_submit_right" disabled="true">Push to Right</button>
                                                    @endif
                                                </td> -->
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                   <div class="" style="display:none">
                                    {!! Form::open(['url' => url('members/pushIntoTree'), 'id' => 'pushIntoTreeForm']) !!}
                                        <input type="text" value="" name="userSelect" id="userSelect"/>
                                        <input type="hidden" name="legpos" id="legpos" value="0">
                                    {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript">
    jQuery(document).ready(function($){
        $('#referrals-grid').DataTable({
            "ordering": false,
            "searching":false,
            "bLengthChange": false,
        });
    });

    $('.btn_submit_left').on('click', function () {
        var uid=$(this).attr('data-select');
        if(!uid){
            swal("Whoops. Something went wrong!");
            return false;
        }else{
            swal({
                title: "Are you sure?",
                text: $(this).attr('data-name') + " will be pushed to the Left!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, do it!",
                closeOnConfirm: false,
                closeOnCancel: false,
            }).then(
                function(){
                    $('#legpos').val(1);
                    $('#userSelect').val(uid);
                    
                    $('#pushIntoTreeForm').submit();
            });

        }
    });

    $('.btn_submit_right').on('click', function () {
        var uid=$(this).attr('data-select');
        if(!uid){
            swal("Whoops. Something when wrong!");
            return false;
        }else{
            swal({
                title: "Are you sure?",
                text: $(this).attr('data-name') + " will be pushed to the Right!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, do it!",
                closeOnConfirm: false,
                closeOnCancel: false,
            }).then(
                function(){
                    $('#legpos').val(2);
                    $('#userSelect').val(uid);
                    $('#pushIntoTreeForm').submit();
            });

        }
    });

</script>
@stop
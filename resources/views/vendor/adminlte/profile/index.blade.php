@extends('adminlte::layouts.backend')

@section('contentheader_title')
    {{ trans('adminlte_lang::profile.my_profile') }}
@endsection

@section('content')
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

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="carcoin-primary-1">
                            <i class="material-icons">perm_identity</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">{{ trans('adminlte_lang::profile.personal_data') }}
                                <div class="card-control"><button class="btn btn-primary btn-round btn-sm m-0" edit-personal-data>Edit</button></div>
                            </h4>
                            {{ Form::model(Auth::user(), array('route' => array('profile.update', Auth::user()->id,), 'method' => 'PUT')) }}
                                <div class="row">
                                    <h4 class="col-md-12">General</h4>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label">{{ trans('adminlte_lang::profile.my_id') }}</label>
                                            <p  class="form-control">{{ Auth::user()->uid }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label">{{ trans('adminlte_lang::profile.username') }}</label>
                                            <p  class="form-control">{{ Auth::user()->name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label">{{ trans('adminlte_lang::profile.first_name') }}</label>
                                            <p  class="form-control">{{ Auth::user()->firstname }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label">{{ trans('adminlte_lang::profile.last_name') }}</label>
                                            <p  class="form-control">{{ Auth::user()->lastname }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label">{{ trans('adminlte_lang::profile.my_email') }}</label>
                                            <p  class="form-control">{{ Auth::user()->email }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h4 class="col-md-12">Address</h4>
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">{{ trans('adminlte_lang::profile.street_address_1') }}</label>
                                            <input type="text" class="form-control" name="address" value="{{ Auth::user()->address }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">{{ trans('adminlte_lang::profile.street_address_2') }}</label>
                                            <input type="text" class="form-control" name="address2" value="{{ Auth::user()->address2 }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label">{{ trans('adminlte_lang::profile.city') }}</label>
                                            <input type="text" class="form-control" name="city" value="{{ Auth::user()->city }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label">{{ trans('adminlte_lang::profile.state') }}</label>
                                            <input type="text" class="form-control" name="state" value="{{ Auth::user()->state }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label">{{ trans('adminlte_lang::profile.postal_code') }}</label>
                                            <input type="text" class="form-control" name="postal_code" value="{{ Auth::user()->postal_code }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label">{{ trans('adminlte_lang::profile.country') }}</label>
                                            <p class="form-control">{{ Auth::user()->name_country }}</p>
                                        </div>
                                    </div>
                                </div>
  
                                <div class="row">
                                    <h4 class="col-md-12">Contact</h4>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label">{{ trans('adminlte_lang::profile.phone') }}</label>
                                            <input type="text" class="form-control" name="phone" value="{{ Auth::user()->phone }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="label-control">{{ trans('adminlte_lang::profile.birthday') }}</label>
                                            @if(Auth::user()->birthday)
                                                <p class="form-control">{{Auth::user()->birthday}}</p>
                                            @else
                                                <input type="date" class="form-control" value="{{ Auth::user()->birthday }}" name="birthday" />
                                            @endif
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label">{{ trans('adminlte_lang::profile.passport') }}</label>
                                            @if(Auth::user()->passport)
                                                <p class="form-control">{{Auth::user()->passport}}</p>
                                            @else
                                                <input type="text" class="form-control" name="passport" value="{{ Auth::user()->passport }}">
                                            @endif
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="pull-right hide" btn-action-form>
                                    <button type="submit" class="btn btn-primary btn-round">{{ trans('adminlte_lang::profile.btn_save') }}</button>
                                    <button type="button" class="btn btn-outline-primary btn-round" cancel-btn-action-form>Cancel</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="card card-profile">
                            <div class="card-avatar">
                                <a href="javascript:;">
                                    <img class="img" src="{{ Gravatar::get(Auth()->user()->email) }}" />
                                </a>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h4>
                                <p class="description">
                                    <span>ID: {{ Auth::user()->uid }}</span>
                                    <span>Rank: </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="card card-profile">
                            <div class="card-header card-header-icon" data-background-color="carcoin-primary-1">
                                <i class="material-icons">perm_identity</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Sponsor</h4>
                                <p class="description">
                                    <span>ID: {{ Auth::user()->uid }}</span>
                                    <span>Rank: </span>
                                </p>
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="card card-profile">
                            <div class="card-header card-header-icon" data-background-color="carcoin-primary-1">
                                <i class="material-icons">insert_link</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Your referral link</h4>
                                <p class="description">
                                    <span>https://mycarcoin.com/ref/{{ Auth::user()->name }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            demo.initFormExtendedDatetimepickers();

            $('form input').each(function(index, el) {
                $(el).prop('disabled',true);
            });

            $('[edit-personal-data]').click(function() {
                $('form input').each(function(index, el) {
                    $(el).removeAttr('disabled', '') ;
                });
                $('[btn-action-form]').removeClass('hide');
            });

            $('[cancel-btn-action-form]').click(function() {
                $('form input').each(function(index, el) {
                    console.log(el);
                    $(el).attr('disabled', '');
                });
                $('[btn-action-form]').addClass('hide');
            });
        });
    </script>
@endsection
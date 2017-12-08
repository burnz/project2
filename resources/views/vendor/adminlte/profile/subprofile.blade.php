@extends('adminlte::layouts.backend')

@section('contentheader_title')
    {{ trans('adminlte_lang::profile.profile_refferals') }}
@endsection

@section('content')
<div class="content">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card card-referrals-detail">  
                                <div class="card-header card-header-icon" data-background-color="carcoin-primary-1">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Personal Data</h4>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td class="text-thirdary">ID</td>
                                                    <td>{{ $user->uid }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-thirdary">Username</td>
                                                    <td>{{ $user->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-thirdary">First Name</td>
                                                    <td>{{ $user->firstname }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-thirdary">Last Name</td>
                                                    <td>{{ $user->lastname }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-thirdary">Email</td>
                                                    <td>{{ $user->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-thirdary">Stress Address</td>
                                                    <td>{{ $user->address }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-thirdary">Stress Address 2</td>
                                                    <td>{{ $user->address2 }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-thirdary">City</td>
                                                    <td>{{ $user->city }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-thirdary">State</td>
                                                    <td>{{ $user->state }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-thirdary">Postal Code</td>
                                                    <td>{{ $user->postal_code }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-thirdary">Country</td>
                                                    <td>{{ $user->name_country }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-thirdary">Phone Number</td>
                                                    <td>{{ $user->phone }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-thirdary">Date of Birth</td>
                                                    <td>{{ $user->birthday }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-thirdary">Passport/ID Card</td>
                                                    <td>{{ $user->passport }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-thirdary">Registration Date</td>
                                                    <td>{{ $user->created_at->format('Y-m-d')}}</td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
@endsection
@extends('manager.layouts.managerbase')
@section('page')
    Customer info
@endsection
@section('content')
    <div class="container-fluid">

        <div class="row">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('warning'))
                <div class="alert alert-warning" role="alert">
                    {{ session('warning') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @include('includes.balance')
            <div class="col-lg-8 col-xlg-9 col-md-12">

                <div class="card">
                    <div class="card-header">Profile
                        <div class="mt-1">
{{--                            <a class="btn btn-success text-white" href="{{ route('save', $user->id) }}">Save</a>--}}
{{--                            <a class="btn btn-danger text-white" href="{{ route('withdraw', $user->id) }}">Withdraw</a>--}}
                            <a class="btn btn-info text-white" href="{{ route('manager.customer.history', $user->id) }}">History</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal form-material" action="">
                            @csrf
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">First Name</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="text" placeholder="Johnathan Doe" name="first_name"
                                           value="{{ $user->first_name }}"
                                           class="form-control p-0 border-0" readonly>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Last Name</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="text" placeholder="Johnathan Doe" name="last_name"
                                           value="{{ $user->surname }}"
                                           class="form-control p-0 border-0" readonly>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Middle Name</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="text" placeholder="Johnathan Doe" name="middle_name"
                                           value="{{ $user->middle_name }}"
                                           class="form-control p-0 border-0" readonly>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Phone No</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="text" placeholder="07047387890" name="phone"
                                           value="{{ $user->phone }}"
                                           class="form-control p-0 border-0" readonly>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Date of birth</label>
                                <div class="col-md-12 border-bottom p-0" >
                                    <input type="date"  name="dob"
                                           value="{{ $user->dob }}"
                                           class="form-control p-0 border-0" readonly>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">State of residence</label>
                                <div class="col-md-12 border-bottom p-0" >
                                    <input type="text"  name="resident_state"
                                           value="{{ $user->resident_state }}"
                                           class="form-control p-0 border-0" readonly>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">LGA of residence</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="text"  name="resident_lga"
                                           value="{{ $user->resident_lga }}"
                                           class="form-control p-0 border-0" readonly>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Residence address</label>
                                <div class="col-md-12 border-bottom p-0" >
                                    <input type="text"  name="resident_lga"
                                           value="{{ $user->resident_address }}"
                                           class="form-control p-0 border-0" readonly>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Occupation</label>
                                <div class="col-md-12 border-bottom p-0" >
                                    <input type="text"  name="occupation"
                                           value="{{ $user->occupation }}"
                                           class="form-control p-0 border-0">
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Office Address</label>
                                <div class="col-md-12 border-bottom p-0" >
                                    <input type="text"  name="office_address"
                                           value="{{ $user->office_address }}"
                                           class="form-control p-0 border-0" >
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="card-footer">
                        {{--                        <a class="btn btn-primary" href="{{ route('admin.user.transactions', $user->id) }}">User transactions</a>--}}
                    </div>

                </div>

            </div>
            <!-- Column -->
        </div>
    </div>
@endsection

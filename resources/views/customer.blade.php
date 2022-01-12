@extends('layouts.dashboard')
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

            <!-- Column -->
            <div class="col-lg-8 col-xlg-9 col-md-12">

                <div class="card">
                    <div class="card-header">Profile</div>
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

                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">State</label>
                                <div class="col-md-12 border-bottom p-0" >
                                    <input type="text"  name="state"
                                           value="{{ $user->state }}"
                                           class="form-control p-0 border-0">
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">LGA</label>
                                <div class="col-md-12 border-bottom p-0" >
                                    <input type="text"  name="lga"
                                           value="{{ $user->lga }}"
                                           class="form-control p-0 border-0">
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Hometown</label>
                                <div class="col-md-12 border-bottom p-0" >
                                    <input type="text"  name="hometown"
                                           value="{{ $user->hometown }}"
                                           class="form-control p-0 border-0">
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Next of kin</label>
                                <div class="col-md-12 border-bottom p-0" >
                                    <input type="text"  name="next_of_kin"
                                           value="{{ $user->next_of_kin }}"
                                           class="form-control p-0 border-0" >
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Relationship</label>
                                <div class="col-md-12 border-bottom p-0" >
                                    <input type="text"  name="relationship"
                                           value="{{ $user->relationship }}"
                                           class="form-control p-0 border-0" readonly>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Next of kin Phone</label>
                                <div class="col-md-12 border-bottom p-0" >
                                    <input type="text"  name="nokphone"
                                           value="{{ $user->nokphone }}"
                                           class="form-control p-0 border-0">
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Daily amount</label>
                                <div class="col-md-12 border-bottom p-0" >
                                    <input type="text"  name="office_address"
                                           value="{{ $user->daily_amount }}"
                                           class="form-control p-0 border-0">
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="bank_code" class="col-sm-12">Bank</label>

                                <div class="col-sm-12 border-bottom">
                                    <select id="bank_code" name="bank_code" class="form-select shadow-none p-0 border-0 form-control-line">
                                        @if(!empty($banks->data) && count($banks->data) > 0)
                                            @foreach($banks->data as $bank)
                                                <option value="{{$bank->code}}" {{ $bank->code == ($user->bank_code !== null ? $user->bank_code: '') ? 'selected' : '' }}> {{$bank->name}}</option>
                                            @endforeach
                                        @else
                                            <option value="" disabled selected>Retrieving banks failed!</option>
                                        @endif
                                    </select>
                                    <input type="hidden" name="bank_name" value="" id="bank_name">
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Account number</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="text"
                                           name="account_number" id="account_number"
                                           class="form-control p-0 border-0"
                                           value="{{ $user->account_number }}" readonly>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="account_name" class="col-md-12 p-0">Account name</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="text"
                                           class="form-control p-0 border-0"
                                           name="account_name" id="account_name" value="{{ $user->account_name }}" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-primary" href="{{ route('admin.user.transactions', $user->id) }}">User transactions</a>
                    </div>

                </div>

            </div>
            <!-- Column -->
        </div>
    </div>
@endsection

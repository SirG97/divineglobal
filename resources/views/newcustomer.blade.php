@extends('layouts.dashboard')
@section('page')
    New Customer
@endsection
@section('content')
    <div class="container-fluid">
        @include('includes.message')
        <div class="row">

            <!-- Column -->
            <div class="col-lg-10 col-xlg-10 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal form-material" method="POST" action="{{ route('store') }}">
                            <p>Fields marked asterisks(<span class="text-danger">*</span>) are required</p>
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group mb-4">
                                        <label for="first_name" class="col-sm-12">First name<span class="text-danger"> *</span></label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" placeholder=""
                                                   class="form-control p-0 border-0" name="first_name"
                                                   id="first_name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mb-4">
                                        <label for="surname" class="col-sm-12">Surname<span class="text-danger"> *</span></label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" placeholder=""
                                                   class="form-control p-0 border-0" name="surname"
                                                   id="surname" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mb-4">
                                        <label for="middle_name" class="col-sm-12">Middle name</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" placeholder=""
                                                   class="form-control p-0 border-0"  name="middle_name"
                                                   id="middle_name">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group mb-4">
                                        <label for="sex" class="col-sm-12">Sex <span class="text-danger"> *</span></label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <select id="sex" name="sex"  class="form-select shadow-none p-0 border-0 form-control-line">
                                                <option value="Male" selected="">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group mb-4">
                                        <label for="dob" class="col-sm-12">Date of Birth</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="date" placeholder=""
                                                   class="form-control p-0 border-0" name="dob"
                                                   id="dob">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group mb-4">
                                        <label for="resident_state" class="col-sm-12">State of residence</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" placeholder=""
                                                   class="form-control p-0 border-0" name="resident_state"
                                                   id="resident_state">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group mb-4">
                                        <label for="resident_lga" class="col-sm-12">LGA</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" placeholder=""
                                                   class="form-control p-0 border-0" name="resident_lga"
                                                   id="resident_lga">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-4">
                                        <label for="resident_address" class="col-sm-12">Address</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" placeholder=""
                                                   class="form-control p-0 border-0" name="resident_address"
                                                   id="resident_address">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-4">
                                        <label for="occupation" class="col-sm-12">Occupation</label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" placeholder=""
                                                   class="form-control p-0 border-0" name="occupation"
                                                   id="occupation">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-7">
                                    <div class="form-group mb-4">
                                        <label for="office_address" class="col-sm-12">Office Address<span class="text-danger"> *</span></label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" placeholder=""
                                                   class="form-control p-0 border-0" name="office_address"
                                                   id="office_address" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="form-group mb-4">
                                        <label for="phone" class="col-sm-12">Phone<span class="text-danger"> *</span></label>
                                        <div class="col-md-12 border-bottom p-0">
                                            <input type="text" placeholder=""
                                                   class="form-control p-0 border-0" name="phone"
                                                   id="phone" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

{{--                            <div class="row">--}}
{{--                                <div class="col-sm-4">--}}
{{--                                    <div class="form-group mb-4">--}}
{{--                                        <label for="state" class="col-sm-12">State of origin</label>--}}
{{--                                        <div class="col-md-12 border-bottom p-0">--}}
{{--                                            <select name="state" class="form-select shadow-none p-0 border-0 form-control-line" id="state">--}}
{{--                                                <option disabled selected>--Select State--</option>--}}
{{--                                                <option value="Abia">Abia</option>--}}
{{--                                                <option value="Adamawa">Adamawa</option>--}}
{{--                                                <option value="Akwa Ibom">Akwa Ibom</option>--}}
{{--                                                <option value="Anambra">Anambra</option>--}}
{{--                                                <option value="Bauchi">Bauchi</option>--}}
{{--                                                <option value="Bayelsa">Bayelsa</option>--}}
{{--                                                <option value="Benue">Benue</option>--}}
{{--                                                <option value="Borno">Borno</option>--}}
{{--                                                <option value="Cross Rive">Cross River</option>--}}
{{--                                                <option value="Delta">Delta</option>--}}
{{--                                                <option value="Ebonyi">Ebonyi</option>--}}
{{--                                                <option value="Edo">Edo</option>--}}
{{--                                                <option value="Ekiti">Ekiti</option>--}}
{{--                                                <option value="Enugu">Enugu</option>--}}
{{--                                                <option value="FCT">Federal Capital Territory</option>--}}
{{--                                                <option value="Gombe">Gombe</option>--}}
{{--                                                <option value="Imo">Imo</option>--}}
{{--                                                <option value="Jigawa">Jigawa</option>--}}
{{--                                                <option value="Kaduna">Kaduna</option>--}}
{{--                                                <option value="Kano">Kano</option>--}}
{{--                                                <option value="Katsina">Katsina</option>--}}
{{--                                                <option value="Kebbi">Kebbi</option>--}}
{{--                                                <option value="Kogi">Kogi</option>--}}
{{--                                                <option value="Kwara">Kwara</option>--}}
{{--                                                <option value="Lagos">Lagos</option>--}}
{{--                                                <option value="Nasarawa">Nasarawa</option>--}}
{{--                                                <option value="Niger">Niger</option>--}}
{{--                                                <option value="Ogun">Ogun</option>--}}
{{--                                                <option value="Ondo">Ondo</option>--}}
{{--                                                <option value="Osun">Osun</option>--}}
{{--                                                <option value="Oyo">Oyo</option>--}}
{{--                                                <option value="Plateau">Plateau</option>--}}
{{--                                                <option value="Rivers">Rivers</option>--}}
{{--                                                <option value="Sokoto">Sokoto</option>--}}
{{--                                                <option value="Taraba">Taraba</option>--}}
{{--                                                <option value="Yobe">Yobe</option>--}}
{{--                                                <option value="Zamfara">Zamfara</option>--}}
{{--                                            </select>--}}

{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-sm-4">--}}
{{--                                    <div class="form-group mb-4">--}}
{{--                                        <label for="lga" class="col-sm-12">LGA</label>--}}
{{--                                        <div class="col-md-12 border-bottom p-0">--}}
{{--                                            <input type="text" placeholder=""--}}
{{--                                                   class="form-control p-0 border-0" name="lga"--}}
{{--                                                   id="lga">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-sm-4">--}}
{{--                                    <div class="form-group mb-4">--}}
{{--                                        <label for="hometown" class="col-sm-12">Hometown</label>--}}
{{--                                        <div class="col-md-12 border-bottom p-0">--}}
{{--                                            <input type="text" placeholder=""--}}
{{--                                                   class="form-control p-0 border-0" name="hometown"--}}
{{--                                                   id="hometown">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="row">--}}
{{--                                <div class="col-sm-4">--}}
{{--                                    <div class="form-group mb-4">--}}
{{--                                        <label for="next_of_kin" class="col-sm-12">Next of kin</label>--}}
{{--                                        <div class="col-md-12 border-bottom p-0">--}}
{{--                                            <input  type="text" placeholder=""--}}
{{--                                                    class="form-control p-0 border-0" name="next_of_kin"--}}
{{--                                                    id="next_of_kin">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-sm-4">--}}
{{--                                    <div class="form-group mb-4">--}}
{{--                                        <label for="relationship" class="col-sm-12">Relationship</label>--}}
{{--                                        <div class="col-md-12 border-bottom p-0">--}}
{{--                                            <input type="text" placeholder=""--}}
{{--                                                   class="form-control p-0 border-0" name="relationship"--}}
{{--                                                   id="relationship">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-sm-4">--}}
{{--                                    <div class="form-group mb-4">--}}
{{--                                        <label for="nokphone" class="col-sm-12">Phone</label>--}}
{{--                                        <div class="col-md-12 border-bottom p-0">--}}
{{--                                            <input type="text" placeholder=""--}}
{{--                                                   class="form-control p-0 border-0" name="nokphone"--}}
{{--                                                   id="nokphone">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="row">--}}
{{--                                <div class="col-sm-3">--}}
{{--                                    <div class="form-group mb-4">--}}
{{--                                        <label for="bank_code" class="col-sm-12">Bank</label>--}}

{{--                                        <div class="col-sm-12 border-bottom">--}}
{{--                                            <select id="bank_code" name="bank_code" class="form-select shadow-none p-0 border-0 form-control-line">--}}
{{--                                                @if(!empty($banks->data) && count($banks->data) > 0)--}}
{{--                                                    @foreach($banks->data as $bank)--}}
{{--                                                        <option value="{{$bank->code}}" > {{$bank->name}}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                @else--}}
{{--                                                    <option value="" disabled selected>Retrieving banks failed!</option>--}}
{{--                                                @endif--}}
{{--                                            </select>--}}
{{--                                            <input type="hidden" name="bank_name" value="" id="bank_name">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-sm-5">--}}
{{--                                    <div class="form-group mb-4">--}}
{{--                                        <label for="account_number" class="col-sm-12">Account no</label>--}}
{{--                                        <div class="col-md-12 border-bottom p-0">--}}
{{--                                            <input type="text" placeholder=""--}}
{{--                                                   class="form-control p-0 border-0" name="account_number"--}}
{{--                                                   id="account_number"--}}
{{--                                                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">--}}
{{--                                            <small id="accountHelpText" class="form-text ">--}}

{{--                                            </small>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-sm-4">--}}
{{--                                    <div class="form-group mb-4">--}}
{{--                                        <label for="account_name" class="col-sm-12">Account name</label>--}}
{{--                                        <div class="col-md-12 border-bottom p-0">--}}
{{--                                            <input type="text" placeholder=""--}}
{{--                                                   class="form-control p-0 border-0" name="account_name"--}}
{{--                                                   id="account_name">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="row">--}}
{{--                                <div class="col-sm-5">--}}
{{--                                    <div class="form-group mb-4">--}}
{{--                                        <label for="daily_amount" class="col-sm-12">Daily amount</label>--}}
{{--                                        <div class="col-md-12 border-bottom p-0">--}}
{{--                                            <input type="text"--}}
{{--                                                   class="form-control p-0 border-0" placeholder="#1000" name="daily_amount"--}}
{{--                                                   id="daily_amount" required--}}
{{--                                                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">--}}

{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            </div>--}}
                            <div class="form-group mb-4">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success">Save Customer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
    </div>
@endsection

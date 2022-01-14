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
            @include('includes.balance')
            <div class="col-lg-8 col-xlg-9 col-md-12">

                <div class="card">
                    <div class="card-header">Save
                        <div class="mt-1">
                            <a class="btn btn-danger text-white" href="{{ route('withd', $user->id) }}">Withdraw</a>
                            <a class="btn btn-info text-white"  href="{{ route('customer.history', $user->id) }}">History</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal form-material" method="POST" action="{{ route('mark') }}">
                            @csrf
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Name</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="text" placeholder="Johnathan Doe" name="first_name"
                                           value="{{ $user->first_name }} {{ $user->surname }}"
                                           class="form-control p-0 border-0" disabled>
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Address</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="text"
                                           name="account_number" id="account_number"
                                           class="form-control p-0 border-0"
                                           value="{{ $user->resident_address }}" readonly>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Daily amount(₦)</label>
                                <div class="col-md-12 border-bottom p-0" >
                                    <input type="text"  name="daily_amount"
                                           value="{{ $user->initial_unit }}"
                                           class="form-control p-0 border-0">
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Date</label>
                                <div class="col-md-12 border-bottom p-0" >
                                    <input type="date"  name="date"

                                           class="form-control p-0 border-0">
                                </div>
                            </div>
                            <div class="col-sm-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-success text-white">Save</button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
            <!-- Column -->
        </div>
    </div>
@endsection

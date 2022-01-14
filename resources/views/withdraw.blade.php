@extends('layouts.dashboard')

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
                            <a class="btn btn-success text-white" href="{{ route('save', $user->id) }}">Save</a>
                            <a class="btn btn-info text-white"  href="{{ route('history', $user->id) }}">History</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal form-material" method="POST" action="{{ route('withdraw.store') }}">
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
                                <label class="col-md-12 p-0">Amount to withdraw(₦)</label>
                                <div class="col-md-12 border-bottom p-0" >
                                    <input type="text"  name="amount"
                                           value="{{ $balance }}"
                                           class="form-control p-0 border-0">
                                </div>
                            </div>
                            <div class="col-sm-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-danger text-white">Withdraw</button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
            <!-- Column -->
        </div>
    </div>
@endsection

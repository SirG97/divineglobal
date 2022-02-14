@extends('manager.layouts.managerbase')

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
            <!-- ============================================================== -->
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">Balance</h3>
                            <ul class="list-inline two-part d-flex align-items-center mb-0">
                                {{--                        <li>--}}
                                {{--                            <div id="sparklinedash"><canvas width="67" height="30"--}}
                                {{--                                                            style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>--}}
                                {{--                            </div>--}}
                                {{--                        </li>--}}
                                <li class="ms-auto"><span class="counter text-success">₦{{ number_format($balance, 2) }}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">Balance(Cash)</h3>
                            <ul class="list-inline two-part d-flex align-items-center mb-0">
                                {{--                        <li>--}}
                                {{--                            <div id="sparklinedash"><canvas width="67" height="30"--}}
                                {{--                                                            style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>--}}
                                {{--                            </div>--}}
                                {{--                        </li>--}}
                                <li class="ms-auto"><span class="counter text-success">₦{{ number_format($cash, 2) }}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">Balance(Bank)</h3>
                            <ul class="list-inline two-part d-flex align-items-center mb-0">
                                {{--                        <li>--}}
                                {{--                            <div id="sparklinedash2"><canvas width="67" height="30"--}}
                                {{--                                                             style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>--}}
                                {{--                            </div>--}}
                                {{--                        </li>--}}
                                <li class="ms-auto"><span class="counter text-purple">₦{{ number_format($bank, 2) }}</span></li>
                            </ul>
                        </div>
                    </div>

                </div>
            <div class="col-lg-8 col-xlg-9 col-md-12">
                <div class="card">
                    <div class="card-header">Record Transaction

                    </div>
                    <div class="card-body">
                        <form class="form-horizontal form-material" method="POST" action="{{ route('manager.expenditure.store') }}">
                            @csrf

                            <div class="form-group mb-4">
                                <label for="amount" class="col-md-12 p-0">Amount</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="text" placeholder="₦150000" class="form-control p-0 border-0" name="amount" id="amount" autocomplete="off"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" >
                                </div>
                            </div>
{{--                            <div class="form-group mb-4">--}}
{{--                                <label for="option" class="col-md-12 p-0">Transaction type</label>--}}
{{--                                <div class="d-flex justify-content-between mt-2">--}}
{{--                                    <div class="switch">--}}
{{--                                        <div class="form-check form-check-inline">--}}
{{--                                            <input class="form-check-input" type="radio" name="transaction_type" id="transaction_type" value="debit" checked>--}}
{{--                                            <label class="form-check-label" for="inlineRadio1">Debit</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check form-check-inline">--}}
{{--                                            <input class="form-check-input" type="radio" name="transaction_type" id="transaction_type" value="credit" >--}}
{{--                                            <label class="form-check-label" for="inlineRadio2">Credit</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="form-group mb-4">--}}
{{--                                <label class="col-sm-12">Purpose</label>--}}

{{--                                <div class="col-sm-12 border-bottom">--}}
{{--                                    <select name="purpose" id="" required="" class="form-select shadow-none p-0 border-0 form-control-line">--}}
{{--                                        <option value="logistics" selected="">Logistics</option>--}}
{{--                                        <option value="deposit">Deposit</option>--}}
{{--                                        <option value="withdrawal">Withdrawal</option>--}}

{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Description</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="text"
                                           name="description" id="description"
                                           class="form-control p-0 border-0"
                                           value="">
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="option" class="col-md-12 p-0">Transaction option</label>
                                <div class="d-flex justify-content-between mt-2">
                                    <div class="switch">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="option" id="option" value="cash" checked>
                                            <label class="form-check-label" for="inlineRadio1">Cash</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="option" id="option" value="bank" >
                                            <label class="form-check-label" for="inlineRadio2">Bank</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Remark (optional)</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <textarea rows="5" class="form-control p-0 border-0" name="remark"></textarea>
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

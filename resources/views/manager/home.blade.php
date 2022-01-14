@extends('manager.layouts.managerbase')

@section('page')
    Dashboard
@endsection
@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Three charts -->
        <!-- ============================================================== -->
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="white-box analytics-info">
                    <h3 class="box-title">Total Customers</h3>
                    <ul class="list-inline two-part d-flex align-items-center mb-0">
                        {{--                        <li>--}}
                        {{--                            <div id="sparklinedash"><canvas width="67" height="30"--}}
                        {{--                                                            style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>--}}
                        {{--                            </div>--}}
                        {{--                        </li>--}}
                        <li class="ms-auto"><span class="counter text-success">{{ $totalCustomers }}</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="white-box analytics-info">
                    <h3 class="box-title">Yearly Total</h3>
                    <ul class="list-inline two-part d-flex align-items-center mb-0">
                        {{--                        <li>--}}
                        {{--                            <div id="sparklinedash"><canvas width="67" height="30"--}}
                        {{--                                                            style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>--}}
                        {{--                            </div>--}}
                        {{--                        </li>--}}
                        <li class="ms-auto"><span class="counter text-success">₦{{ number_format($yearlyTotal) }}</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="white-box analytics-info">
                    <h3 class="box-title">Monthly Total</h3>
                    <ul class="list-inline two-part d-flex align-items-center mb-0">
                        {{--                        <li>--}}
                        {{--                            <div id="sparklinedash2"><canvas width="67" height="30"--}}
                        {{--                                                             style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>--}}
                        {{--                            </div>--}}
                        {{--                        </li>--}}
                        <li class="ms-auto"><span class="counter text-purple">₦{{number_format($monthlyTotal) }}</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="white-box analytics-info">
                    <h3 class="box-title">Daily Total</h3>
                    <ul class="list-inline two-part d-flex align-items-center mb-0">
                        <li>
                            <div id="sparklinedash3"><canvas width="67" height="30"
                                                             style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                            </div>
                        </li>
                        <li class="ms-auto"><span class="counter text-info">₦{{number_format($dailyTotal) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- RECENT SALES -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="white-box">
                    <div class="d-md-flex mb-3">
                        <h3 class="box-title mb-0">Recent transactions</h3>
                        <div class="col-md-3 col-sm-4 col-xs-6 ms-auto">
                            {{--                            <select class="form-select shadow-none row border-top">--}}
                            {{--                                <option>March 2021</option>--}}
                            {{--                                <option>April 2021</option>--}}
                            {{--                                <option>May 2021</option>--}}
                            {{--                                <option>June 2021</option>--}}
                            {{--                                <option>July 2021</option>--}}
                            {{--                            </select>--}}
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table no-wrap user-table mb-0">
                            <tbody>
                            @if(!empty($transactions) && count($transactions) > 0)
                                @foreach($transactions as $transaction)
                                    <tr style="margin-bottom: 2px;">
                                        <td class="{{ $transaction->txn_type == 'credit'?'left-border-success':'left-border-danger' }}">
                                            <h5 class="font-weight-medium mb-0">
                                                <span class="text-capitalize">{{ $transaction->description }}</span>
                                            </h5>
                                            <span class="text-muted">{{ $transaction->created_at->toDayDateTimeString() }}</span>
                                        </td>
                                        <td style="text-align: right;margin-right: 15px">
                                        <span class="text-right {{ $transaction->txn_type == 'credit'?'text-success':'text-danger' }}">
                                            {{ $transaction->txn_type == 'credit'?'+':'-' }}
                                            ₦{{ number_format($transaction->amount, '2', '.', ',') }}</span>
                                        </td>
                                    </tr>

                                @endforeach
                            @else
                                <tr><td colspan="2">No transactions yet</td></tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
    </div>
@endsection

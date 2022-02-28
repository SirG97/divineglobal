@extends('manager.layouts.managerbase')

@section('page')
    Dashboard
@endsection
@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Three charts -->
        <!-- ============================================================== -->
        <div class="row justify-content-start">
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
                    <h3 class="box-title">Balance</h3>
                    <ul class="list-inline two-part d-flex align-items-center mb-0">
                        {{--                        <li>--}}
                        {{--                            <div id="sparklinedash"><canvas width="67" height="30"--}}
                        {{--                                                            style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>--}}
                        {{--                            </div>--}}
                        {{--                        </li>--}}
                        <li class="ms-auto"><span class="counter text-success">₦{{ number_format($balance) }}</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="white-box analytics-info">
                    <h3 class="box-title">Total Deposit</h3>
                    <ul class="list-inline two-part d-flex align-items-center mb-0">
                        {{--                        <li>--}}
                        {{--                            <div id="sparklinedash2"><canvas width="67" height="30"--}}
                        {{--                                                             style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>--}}
                        {{--                            </div>--}}
                        {{--                        </li>--}}
                        <li class="ms-auto"><span class="counter text-purple">₦{{number_format($yearlyCredit) }}</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="white-box analytics-info">
                    <h3 class="box-title">Total Withdrawal</h3>
                    <ul class="list-inline two-part d-flex align-items-center mb-0">
                        <li>
                            <div id="sparklinedash3"><canvas width="67" height="30"
                                                             style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                            </div>
                        </li>
                        <li class="ms-auto"><span class="counter text-info">₦{{number_format($yearlyDebit) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="white-box analytics-info">
                    <h3 class="box-title">Profit</h3>
                    <ul class="list-inline two-part d-flex align-items-center mb-0">
                        <li>
                            <div id="sparklinedash3"><canvas width="67" height="30"
                                                             style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                            </div>
                        </li>
                        <li class="ms-auto"><span class="counter text-info">₦{{number_format($profit) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="white-box analytics-info">
                    <h3 class="box-title">Expenses</h3>
                    <ul class="list-inline two-part d-flex align-items-center mb-0">
                        <li>
                            <div id="sparklinedash3"><canvas width="67" height="30"
                                                             style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                            </div>
                        </li>
                        <li class="ms-auto"><span class="counter text-info">₦{{number_format($expenses) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="white-box analytics-info">
                    <h3 class="box-title">Loan received</h3>
                    <ul class="list-inline two-part d-flex align-items-center mb-0">
                        <li>
                            <div id="sparklinedash3"><canvas width="67" height="30"
                                                             style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                            </div>
                        </li>
                        <li class="ms-auto"><span class="counter text-info">₦{{number_format($loanReceived) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="white-box analytics-info">
                    <h3 class="box-title">Loan disbursed</h3>
                    <ul class="list-inline two-part d-flex align-items-center mb-0">
                        <li>
                            <div id="sparklinedash3"><canvas width="67" height="30"
                                                             style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                            </div>
                        </li>
                        <li class="ms-auto"><span class="counter text-info">₦{{number_format($loanGivenOut) }}</span>
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
{{--                                        {{ $transaction->txn_type == 'credit'?'left-border-success': $transaction->purpose == 'commission'? 'left-border-primary': 'left-border-danger' }}--}}
                                        <td class="@if($transaction->txn_type == 'credit') left-border-success
                                                    @elseif($transaction->txn_type == 'debit' and $transaction->purpose == 'commission' or $transaction->purpose == 'transfer') left-border-primary
                                                    @elseif($transaction->txn_type == 'debit') left-border-danger
                                                    @endif">
                                            <a href="{{ route('manager.transaction', ['id' => $transaction->txn_ref]) }}">
                                                <h5 class="font-weight-medium mb-0">
                                                    <span class="text-capitalize">{{ $transaction->description }}</span>
                                                </h5>
                                                <span class="text-muted">{{ $transaction->created_at->toDayDateTimeString() }}</span>
                                            </a>
                                        </td>
                                        <td style="text-align: right;margin-right: 15px">
                                            <a href="{{ route('manager.transaction', ['id' => $transaction->txn_ref]) }}">
                                                <span class="text-right
                                                    @if($transaction->txn_type == 'credit') text-success
                                                    @elseif($transaction->txn_type == 'debit' and $transaction->purpose == 'commission' or $transaction->purpose == 'transfer') text-primary
                                                    @elseif($transaction->txn_type == 'debit') text-danger
                                                    @endif">
                                                    @if($transaction->txn_type == 'credit') +
                                                    @elseif($transaction->txn_type == 'debit' and $transaction->purpose == 'commission' or $transaction->purpose == 'transfer')
                                                    @elseif($transaction->txn_type == 'debit') -
                                                    @endif
                                                ₦{{ number_format($transaction->amount, '2', '.', ',') }}</span>
                                            </a>
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

@extends('admin.layouts.base')
@section('page')
    {{ $branchname[0] }} Transaction History
@endsection
@section('content')
    <div class="container">
        <div class="page-content mt-3">
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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
        @endif
        <!-- ============================================================== -->

            <!-- Pay, topup transfer -->
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
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-0" style="margin-left: -15px">Transactions</h5>
                            <div class="example">
                                <h4 class="card-title mt-4">Select range</h4>
                                <form action="{{ route('admin.branch.history', ['branch' => $branch]) }}" method="GET">

                                    <div class="input-daterange input-group" id="date-range">
                                        <input type="date" class="form-control" name="start" value="{{ old('start') }}" required>

                                        <span class="input-group-text bg-info b-0 text-white">TO</span>

                                        <input type="date" class="form-control" name="end"  value="{{ old('end') }}">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table no-wrap user-table mb-0">
                                <tbody>
                                @if(!empty($transactions) && count($transactions) > 0)
                                    @foreach($transactions as $transaction)
                                        <tr style="margin-bottom: 2px;">

                                            <td class="@if($transaction->txn_type == 'credit') left-border-success
                                                    @elseif($transaction->txn_type == 'debit' and $transaction->purpose == 'commission' or $transaction->purpose == 'transfer') left-border-primary
                                                    @elseif($transaction->txn_type == 'debit') left-border-danger
                                                    @endif">
                                                <a href="{{ route('admin.transaction', ['id' => $transaction->txn_ref]) }}">
                                                    <h5 class="font-weight-medium mb-0">
                                                        <span class="text-capitalize">{{ $transaction->description }}</span>
                                                    </h5>
                                                    <span class="text-muted">{{ $transaction->created_at->toDayDateTimeString() }}</span>
                                                </a>
                                            </td>
                                            <td style="text-align: right;margin-right: 15px">
                                                <a href="{{ route('admin.transaction', ['id' => $transaction->txn_ref]) }}">
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
                        <div class="card-footer">
                            <div class="p-2">
                                {!! $transactions->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

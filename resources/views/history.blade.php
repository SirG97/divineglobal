@extends('layouts.dashboard')

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

            <div class="row">
                <div class="col-md-12 mt-3">
                    @include('includes.balance')
                </div>
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-0" style="margin-left: -15px">Transactions</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table no-wrap user-table mb-0">
                                <tbody>
                                @if(!empty($transactions) && count($transactions) > 0)
                                    @foreach($transactions as $transaction)
                                        <tr style="margin-bottom: 2px;">
                                            <td class="{{ $transaction->txn_type == 'credit'?'left-border-success':'left-border-danger' }}">
                                                <h5 class="font-weight-medium mb-0">
                                                    <span class="text-capitalize">{{ $transaction->purpose }}</span>
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

        </div>
    </div>

@endsection

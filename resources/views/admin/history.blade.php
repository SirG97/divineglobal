@extends('admin.layouts.base')

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
{{--                <div class="col-md-12 mt-3">--}}
{{--                    @include('includes.balance')--}}
{{--                </div>--}}
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

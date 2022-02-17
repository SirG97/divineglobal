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
                            <div class="example">
                                <h4 class="card-title mt-4">Select range</h4>
                                <form action="{{ route('history') }}" method="GET">
                                    @csrf
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

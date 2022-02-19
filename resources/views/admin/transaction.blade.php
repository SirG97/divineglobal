@extends('admin.layouts.base')
@section('page')
    Transaction
@endsection
@section('content')
    <div class="container-fluid">
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
        <div class="row">
            <div class="col-lg-8 col-xlg-9 col-md-12">
                <div class="white-box">
                    <div class="d-md-flex mb-3">
                        <h3 class="box-title mb-0">Transaction</h3>

                    </div>
                    <dl class="row">
                        @if($transaction->customer_id)
                            <dt class="col-sm-3">Customer</dt>
                            <dd class="col-sm-9">{{ $transaction->customer->first_name . ' ' . $transaction->customer->surname }}</dd>
                        @endif
                        <dt class="col-sm-3">Transaction Ref</dt>
                        <dd class="col-sm-9">{{$transaction->txn_ref}}</dd>
                        <dt class="col-sm-3">Amount</dt>
                        <dd class="col-sm-9">₦{{ number_format((float)$transaction->amount,2)}}</dd>
                        <dt class="col-sm-3">Transaction type</dt>
                        <dd class="col-sm-9">{{$transaction->txn_type}}</dd>
                        <dt class="col-sm-3">Purpose</dt>
                        <dd class="col-sm-9">{{$transaction->purpose}}</dd>
                            @if($transaction->customer_id)
                                <dt class="col-sm-3">Marketer</dt>
                                <dd class="col-sm-9">{{$transaction->user->name}}</dd>
                            @endif
                        <dt class="col-sm-3">Option</dt>
                        <dd class="col-sm-9">{{$transaction->option}}</dd>

                        <dt class="col-sm-3">Description</dt>
                        <dd class="col-sm-9">{{$transaction->description}}</dd>
                        <dt class="col-sm-3">Remark</dt>
                        <dd class="col-sm-9">{{$transaction->remark}}</dd>
                        <dt class="col-sm-3">Date</dt>
                        <dd class="col-sm-9">{{$transaction->created_at->toDayDateTimeString()}}</dd>
                    </dl>

                </div>
            </div>
        </div>
    </div>
@endsection

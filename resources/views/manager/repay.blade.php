@extends('manager.layouts.managerbase')
@section('page')
    Repay loan
@endsection
@section('content')

    <div class="container-fluid">
        @include('includes.message')
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="white-box">
                    <div class="d-md-flex mb-3">
                        <h3 class="box-title mb-0">Outstanding loans</h3>
                        <div class="col-md-3 col-sm-4 col-xs-6 ms-auto">

                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table no-wrap">
                            <thead>
                            <tr>
                                <th class="border-top-0">Branch</th>
                                <th class="border-top-0">Requested amount</th>
                                <th class="border-top-0">Approved amount</th>
                                <th class="border-top-0">Paid Back</th>
                                <th class="border-top-0">Status</th>
                                <th class="border-top-0">Date</th>
                                <th class="border-top-0">Approve</th>
                                <th class="border-top-0">Reject</th>

                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($loans) && count($loans) > 0)
                                @foreach($loans as $loan)
                                    <tr>
                                        <td scope="row" class="txt-oflo">{{ $loan->lender['name'] }}</td>
                                        <td scope="row" class="txt-oflo">{{ number_format($loan['request_amount'], 2) }}</td>
                                        <td scope="row" class="txt-oflo">{{ number_format($loan['amount'], 2) }}</td>
                                        <td scope="row" class="txt-oflo">{{ number_format($loan['paid'], 2) }}</td>
                                        <td scope="row" class="txt-oflo">
                                            @if($loan['status'] == 'pending')
                                                <span class="badge bg-warning">pending</span>
                                            @elseif($loan['status'] == 'success')
                                                <span class="badge bg-primary">approved</span>
                                            @elseif($loan['status'] == 'rejected')
                                                <span class="badge bg-danger">rejected</span>
                                            @elseif($loan['status'] == 'paid')
                                                <span class="badge bg-success">paid</span>
                                            @endif
                                        </td>
                                        <td scope="row" class="txt-oflo">{{ $loan['created_at']->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">
                                        <div class="d-flex justify-content-center">You have no loans to payback</div>
                                    </td>
                                </tr>
                            @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

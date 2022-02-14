@extends('manager.layouts.managerbase')

@section('content')

    <div class="container-fluid">
        @include('includes.message')
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="white-box">
                    <div class="d-md-flex mb-3">
                        <h3 class="box-title mb-0">Loan requests from other branches</h3>
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
                                <th class="border-top-0">Reject

                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($loans) && count($loans) > 0)
                                @foreach($loans as $loan)
                                    <tr>
                                        <td scope="row" class="txt-oflo">{{ $loan->branch['name'] }}</td>
                                        <td scope="row" class="txt-oflo">₦{{ number_format($loan['request_amount'], 2) }}</td>
                                        <td scope="row" class="txt-oflo">₦{{ number_format($loan['amount'], 2) }}</td>
                                        <td scope="row" class="txt-oflo">₦{{ number_format($loan['paid'], 2) }}</td>
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
                                        <td>
                                            <button class="btn btn-sm btn-success"
                                                    title="Edit coin details"
                                                    data-toggle="modal"
                                                    data-target="#approveLoan"
                                                    data-id="{{ $loan['id'] }}"
                                                    data-amount="{{ $loan['request_amount'] }}">Approve</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-danger text-white"
                                                    title="Delete"
                                                    data-toggle="modal"
                                                    data-target="#rejectLoan"
                                                    data-delid="{{ $loan['id'] }}">Reject</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">
                                        <div class="d-flex justify-content-center">No branch has requested for any loans</div>
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
    <div id="approveLoan" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="approveLoanForm" action="{{ route('manager.loan.approve') }}" method="POST">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">
                            Approve Loan
                        </h4>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group mb-4">
                            <label id="name" class="col-sm-12">Amount</label>
                            <input type="hidden" name="id" id="id" value="">
                            <div class="col-sm-12 border-bottom">
                                <input type="text"
                                       class="form-control p-0 border-0" value="" name="amount"
                                       id="amount">
                            </div>
                            <div class="d-flex justify-content-between mt-3">
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="
                                      btn btn-light-danger
                                      text-danger
                                      font-weight-medium
                                      waves-effect" data-dismiss="modal">
                            Close
                        </button>
                        <button id="updateBranchBtn" type="submit" class="
                                      btn btn-success
                                      font-weight-medium
                                      waves-effect
                                      text-white
                                    ">
                            Approve Loan
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div id="rejectLoan" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" id="deleteCoinForm" method="POST">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">
                            Reject loan
                        </h4>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" value="" id="delid" name="id">
                        <p>Are you sure you want to reject this loan?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="
                                  btn btn-light-danger
                                  text-danger
                                  font-weight-medium
                                  waves-effect" data-dismiss="modal">
                            Close
                        </button>
                        <button id="rejectLoanBtn" type="submit" class="
                                  btn btn-danger
                                  font-weight-medium
                                  text-white
                                  waves-effect">
                            Reject Loan
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

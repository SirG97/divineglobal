@extends('manager.layouts.managerbase')
@section('page')
    Apply for loan
@endsection
@section('content')

    <div class="container-fluid">
        @include('includes.message')
        <div class="row">
            <!-- Column -->
            <div class="col-lg-8 col-xlg-9 col-md-12">
                <div class="card">
                    <div class="card-header font-weight-bold setting-header">Apply for loan</div>
                    <div class="card-body">
                        <form class="form-horizontal form-material" method="POST" action="{{ route('manager.loan.store') }}">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="amount" class="col-md-12 p-0">Amount</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="text" placeholder="₦150000" class="form-control p-0 border-0" name="amount" id="amount" autocomplete="off"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" >
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="branch" class="col-sm-12">Branch</label>

                                <div class="col-sm-12 border-bottom">
                                    <select id="branch" name="branch" class="form-select shadow-none p-0 border-0 form-control-line">
                                        @if(!empty($branches) && count($branches) > 0)
                                            @foreach($branches as $branch)
                                                <option value="{{$branch->id}}" > {{$branch->name}}</option>
                                            @endforeach
                                        @else
                                            <option value="" disabled selected>No branch available</option>
                                        @endif

                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success">Apply</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="white-box">
                    <div class="d-md-flex mb-3">
                                                <h3 class="box-title mb-0">Loan applications</h3>
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
                                {{--                                <th class="border-top-0">Delete</th>--}}

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
                                            @elseif($loan['status'] == 'approved')
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
                                        <div class="d-flex justify-content-center">You have not applied for any loans</div>
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

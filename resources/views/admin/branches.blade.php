@extends('admin.layouts.base')
@section('page')
    Branches
@endsection
@section('content')

    <div class="container-fluid">
        @include('includes.message')
        <div class="row">
            <!-- Column -->
            <div class="col-lg-8 col-xlg-9 col-md-12">
                <div class="card">
                    <div class="card-header font-weight-bold setting-header">Add New Branch</div>
                    <div class="card-body">
                        <form class="form-horizontal form-material" method="POST" action="{{ route('admin.branch.store') }}">
                            @csrf
                            <div class="form-group mb-4">
                                <label class="col-sm-12">Branch name</label>

                                <div class="col-sm-12 border-bottom">
                                    <input type="text"
                                           class="form-control p-0 border-0" value="" name="name"
                                           id="name">
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-sm-12">Address</label>

                                <div class="col-sm-12 border-bottom">
                                    <input type="text"
                                           class="form-control p-0 border-0" value="" name="address"
                                           id="address">
                                </div>

                            </div>

                            <div class="form-group mb-4">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success">Save Branch</button>
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
                        <h3 class="box-title mb-0">Branches</h3>
                        <div class="col-md-3 col-sm-4 col-xs-6 ms-auto">

                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table no-wrap">
                            <thead>
                            <tr>
                                <th class="border-top-0">Branch name</th>
                                <th class="border-top-0">Daily</th>
                                <th class="border-top-0">History</th>
                                <th class="border-top-0">Edit</th>
                                <th class="border-top-0">Delete</th>

                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($branches) && count($branches) > 0)
                                @foreach($branches as $branch)
                                    <tr>
                                        <td scope="row" class="txt-oflo">{{$branch['name']}}</td>

                                        <td><a href="{{route('admin.branch.daily', ['branch'=> $branch['id']])}}" class="btn btn-primary">Daily</a></td>
                                        <td><a href="{{route('admin.branch.history', ['branch'=> $branch['id']])}}" class="btn btn-primary">History</a></td>


                                        <td>
                                            <button class="btn btn-sm btn-warning"
                                                    title="Edit branch details"
                                                    data-toggle="modal"
                                                    data-target="#editBranch"
                                                    data-name="{{ $branch['name'] }}"
                                                    data-address="{{ $branch['address'] }}"
                                                    data-id="{{ $branch['id'] }}">Edit</button>
                                        </td>

                                        <td>
                                            <button class="btn btn-sm btn-danger text-white"
                                                    title="Delete"
                                                    data-toggle="modal"
                                                    data-target="#deleteBranch"
                                                    data-delid="{{ $branch['id'] }}">Delete</button>
                                        </td>

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">
                                        <div class="d-flex justify-content-center">No Branches yet</div>
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
    <div id="editBranch" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editBranchForm" action="{{ route('admin.branch.edit') }}" method="POST">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">
                            Edit branch
                        </h4>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group mb-4">
                            <label id="name" class="col-sm-12">Name</label>
                            <input type="hidden" name="id" id="id" value="">
                            <div class="col-sm-12 border-bottom">
                                <input type="text"
                                       class="form-control p-0 border-0" value="" name="name"
                                       id="name">
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="address" class="col-sm-12"> Address</label>

                            <div class="col-sm-12 border-bottom">
                                <input type="text" placeholder="x0esjkxeposeabcacdswa"
                                       class="form-control p-0 border-0" value="" name="address"
                                       id="address">
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
                                    ">
                            Update Branch
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div id="deleteBranch" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteBranchForm" method="POST" action="{{ route('admin.branch.delete') }}">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">
                            Delete Branch
                        </h4>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" value="" id="delid" name="id">
                        <p class="text-danger">Please beware that deleting a branch will result in deleting all associated data including
                            customers, marketers, payment and manager. Only delete a branch if it is created in error
                            and has not been used by anybody. Are you sure you want to delete</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="
                                  btn btn-light-danger
                                  text-danger
                                  font-weight-medium
                                  waves-effect" data-dismiss="modal">
                            Close
                        </button>
                        <button id="deleteCoinBtn" type="submit" class="
                                  btn btn-danger
                                  font-weight-medium
                                  text-white
                                  waves-effect">
                            Delete Branch
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection

@extends('manager.layouts.managerbase')
@section('page')
    All Marketers
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
        @if (session('warning'))
            <div class="alert alert-warning" role="alert">
                {{ session('warning') }}
            </div>
        @endif
{{--        <div class="row">--}}
{{--            <div class="col-md-offset-6"></div>--}}
{{--            <div class="col-md-6">--}}
{{--                <div class="nav-item search-box mb-3" style="position: relative">--}}
{{--                    <form class="app-search d-block">--}}
{{--                        <input type="text" id="user_search" class="form-control" placeholder="Search users...">--}}
{{--                        <a href="" class="active"><i class="fa fa-search"></i></a>--}}
{{--                    </form>--}}
{{--                    <div class="user-search-result">--}}
{{--                        <ul class="list-group list-group-flush" id="search-result-list">--}}

{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="white-box">
                    <div class="d-md-flex mb-3">
                        <h3 class="box-title mb-0">Marketers</h3>

                    </div>
                    <div class="table-responsive">
                        <table class="table no-wrap">
                            <thead>
                            <tr>
                                <th class="border-top-0">Name</th>
                                <th class="border-top-0">Email</th>
{{--                                <th class="border-top-0">Phone</th>--}}
                                <th class="border-top-0">Joined</th>
                                <th class="border-top-0">Status</th>
                                <th class="border-top-0">Edit</th>
                                <th class="border-top-0">Delete</th>
{{--                                <th class="border-top-0">Block</th>--}}
{{--                                <th class="border-top-0">Delete</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($users) && count($users) > 0)
                                @foreach($users as $user)
                                    <tr>
                                        <td scope="row">{{ $user['name'] }}</td>
                                        <td>{{ $user['email'] }}</td>
{{--                                        <td>{{ $user['phone'] }}</td>--}}

                                        <td>{{ $user['created_at']->diffForHumans() }}</td>
                                        <td>
                                            @if($user['status'] === 1)
                                                <span class="badge bg-success">active</span>
                                            @elseif($user['status'] === 0)
                                                <span class="badge bg-danger">blocked</span>
                                            @endif</td>
{{--                                        <td>--}}
{{--                                            <a class="btn btn-info btn-sm inline-block" href="{{ route('admin.user', $user['id']) }}">View</a>--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            <form method="POST" action="{{ route('admin.confirm') }}">--}}
{{--                                                @csrf--}}
{{--                                                <input type="hidden" name="id" value="{{ $user['id'] }}">--}}
{{--                                                <button type="submit" class="btn btn-primary btn-sm inline-block">Verify</button>--}}
{{--                                            </form></td>--}}
{{--                                        <td>--}}
{{--                                            <button class="btn btn-danger btn-sm inline-block text-white" title="Block user"--}}
{{--                                                    data-toggle="modal"--}}
{{--                                                    data-target="#blockUser"--}}
{{--                                                    data-id="{{ $user['id'] }}"--}}
{{--                                                    data-active="{{ $user['active'] }}" >--}}
{{--                                                @if($user['status'] === 1)--}}
{{--                                                    Block--}}
{{--                                                @elseif($user['status'] === 0)--}}
{{--                                                    Unblocked--}}
{{--                                                @endif--}}
{{--                                            </button>--}}
{{--                                        </td>--}}
                                        <td>
                                            <button class="btn btn-warning btn-sm inline-block text-white"
                                                    data-toggle="modal"
                                                    data-target="#updateMarketer"
                                                    data-name="{{ $user['name'] }}"
                                                    data-email="{{ $user['email'] }}"
                                                    data-id="{{ $user['id'] }}">Edit <i class="fa fa-edit"></i></button>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-sm inline-block text-white"
                                                    data-toggle="modal"
                                                    data-target="#deleteMarketer"
                                                    data-name="{{ $user['name'] }}"
                                                    data-email="{{ $user['email'] }}"
                                                    data-id="{{ $user['id'] }}">Delete <i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">
                                        <div class="d-flex justify-content-center">No Marketers yet</div>
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
    <div id="updateMarketer" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="updateMarketerForm" action="{{ route('manager.marketer.edit') }}" method="POST">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">
                            Update Marketer
                        </h4>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="name" class="col-sm-12">Name</label>
                            <input type="hidden" name="id" id="id" value="">
                            <div class="col-sm-12 border-bottom">
                                <input type="text"
                                       class="form-control p-0 border-0" value="" name="name"
                                       id="name">
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="email" class="col-sm-12">Email</label>

                            <div class="col-sm-12 border-bottom">
                                <input type="email"
                                       class="form-control p-0 border-0" value="" name="email"
                                       id="email">
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
                        <button id="updateMarketerBtn" type="submit" class="
                                      btn btn-success text-white
                                      font-weight-medium
                                      waves-effect
                                    ">
                            Update Email
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
{{--    <div id="blockUser" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" style="display: none;" aria-hidden="true">--}}
{{--        <div class="modal-dialog">--}}
{{--            <div class="modal-content">--}}
{{--                <form action="{{ route('admin.user.block') }}" id="blockUserForm" method="POST">--}}
{{--                    <div class="modal-header d-flex align-items-center">--}}
{{--                        <h4 class="modal-title" id="myModalLabel">--}}
{{--                            Block marketer--}}
{{--                        </h4>--}}
{{--                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>--}}
{{--                    </div>--}}
{{--                    <div class="modal-body">--}}
{{--                        @csrf--}}
{{--                        <input type="hidden" value="" id="id" name="id">--}}
{{--                        <p id="toggleUserState"></p>--}}
{{--                    </div>--}}
{{--                    <div class="modal-footer">--}}
{{--                        <button type="button" class="--}}
{{--                                  btn btn-light-danger--}}
{{--                                  text-danger--}}
{{--                                  font-weight-medium--}}
{{--                                  waves-effect" data-dismiss="modal">--}}
{{--                            Close--}}
{{--                        </button>--}}
{{--                        <button id="blockUserBtn" type="submit" class="--}}
{{--                                  btn btn-danger--}}
{{--                                  font-weight-medium--}}
{{--                                  text-white--}}
{{--                                  waves-effect">--}}
{{--                            Block user--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--            <!-- /.modal-content -->--}}
{{--        </div>--}}
{{--        <!-- /.modal-dialog -->--}}
{{--    </div>--}}

    <div id="deleteMarketer" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('manager.user.delete') }}" id="deleteMarketerForm" method="POST">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">
                            Delete Marketer
                        </h4>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" value="" id="user_id" name="id">
                        <p>Delete marketer? <br>This action is not reversible</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="
                                  btn btn-light-danger
                                  text-danger
                                  font-weight-medium
                                  waves-effect" data-dismiss="modal">
                            Close
                        </button>
                        <button id="deleteMarketerBtn" type="submit" class="
                                  btn btn-danger
                                  font-weight-medium
                                  text-white
                                  waves-effect">
                            Delete Marketer
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

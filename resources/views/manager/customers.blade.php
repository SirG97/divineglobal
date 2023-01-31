@extends('manager.layouts.managerbase')
@section('page')
    All Customers
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
        <div class="row">
            <div class="col-md-offset-6"></div>
            <div class="col-md-6">
                <div class="nav-item search-box mb-3" style="position: relative">
                    <form class="app-search d-block">
                        <input type="text" id="m_user_search" class="form-control" placeholder="Search users...">
                        <a href="" class="active"><i class="fa fa-search"></i></a>
                    </form>
                    <div class="user-search-result" >
                        <ul class="list-group list-group-flush" id="search-result-list">

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="white-box">
                    <div class="d-md-flex mb-3">
                        <h3 class="box-title mb-0">Customers</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table no-wrap">
                            <thead>
                            <tr>
                                <th class="border-top-0">Name</th>
                                <th class="border-top-0">Account ID</th>
                                <th class="border-top-0">Marketer </th>
{{--                                <th class="border-top-0">Phone</th>--}}
                                <th class="border-top-0">Joined on</th>
                                <th class="border-top-0">View</th>
{{--                                <th class="border-top-0">Edit</th>--}}
                                <th class="border-top-0">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($users) && count($users) > 0)
                                @foreach($users as $user)
                                    <tr>
                                        <td scope="row">{{ $user['first_name'] }} {{ $user['surname'] }}</td>
                                        <td scope="row">{{ $user['account_id']  }}</td>
                                        <td scope="row">{{ ($user['user']) ? $user['user']['name'] : 'Deleted'  }}</td>
{{--                                        <td>{{ $user['phone'] }}</td>--}}
                                        <td>{{ $user['created_at']->diffForHumans() }}</td>
                                        <td>
                                            <a class="btn btn-info btn-sm inline-block" href="{{ route('manager.show', $user['id']) }}">View</a>
                                        </td>
{{--                                        <td>--}}
{{--                                            <a--}}
{{--                                                class="btn btn-warning btn-sm inline-block"--}}
{{--                                                data-toggle="modal"--}}
{{--                                                data-target="#updateCustomer"--}}
{{--                                               href="#">Edit</a>--}}
{{--                                        </td>--}}
                                        <td>
                                            <a class="btn btn-danger btn-sm inline-block"
                                                data-toggle="modal"
                                               data-id="{{ $user['id'] }}"
                                                data-target="#deleteUser">
                                                Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">
                                        <div class="d-flex justify-content-center">No customers yet</div>
                                    </td>
                                </tr>
                            @endif

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="">
                            {!! $users->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="updateCustomer" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" id="blockUserForm" method="POST">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">
                            Block user
                        </h4>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" value="" id="id" name="id">
                        <p id="toggleUserState"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="
                                  btn btn-light-danger
                                  text-danger
                                  font-weight-medium
                                  waves-effect" data-dismiss="modal">
                            Close
                        </button>
                        <button id="blockUserBtn" type="submit" class="
                                  btn btn-danger
                                  font-weight-medium
                                  text-white
                                  waves-effect">
                            Block user
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div id="deleteUser" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('manager.customer.delete')}}" id="deleteUserForm" method="POST">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">
                            Delete Customer
                        </h4>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" value="" id="user_id" name="id">
                        <p>Delete customer? <br>Every data related to this user will be erased. This action is not reversible</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="
                                  btn btn-light-danger
                                  text-danger
                                  font-weight-medium
                                  waves-effect" data-dismiss="modal">
                            Close
                        </button>
                        <button id="deleteUserBtn" type="submit" class="
                                  btn btn-danger
                                  font-weight-medium
                                  text-white
                                  waves-effect">
                            Delete Customer
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

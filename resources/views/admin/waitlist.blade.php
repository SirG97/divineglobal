@extends('admin.layouts.base')
@section('page')
    Preregistered managers
@endsection
@section('content')

    <div class="container-fluid">
        @include('includes.message')
        <div class="row">
            <!-- Column -->
            <div class="col-lg-8 col-xlg-9 col-md-12">
                <div class="card">
                    <div class="card-header font-weight-bold setting-header">Preregister a manager</div>
                    <div class="card-body">
                        <form class="form-horizontal form-material" method="POST" action="{{ route('admin.manager.store') }}">
                            @csrf
                            <div class="form-group mb-4">
                                <label class="col-sm-12">Email</label>

                                <div class="col-sm-12 border-bottom">
                                    <input type="email"
                                           class="form-control p-0 border-0" value="" name="email"
                                           id="email">
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
                                    <button type="submit" class="btn btn-success">Save manager email</button>
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
{{--                        <h3 class="box-title mb-0">Managers</h3>--}}
                        <div class="col-md-3 col-sm-4 col-xs-6 ms-auto">

                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table no-wrap">
                            <thead>
                            <tr>
                                <th class="border-top-0">Email</th>
                                <th class="border-top-0">Branch</th>
                                <th class="border-top-0">Edit</th>
                                {{--                                <th class="border-top-0">Delete</th>--}}

                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($waitlists) && count($waitlists) > 0)
                                @foreach($waitlists as $waitlist)
                                    <tr>
                                        <td scope="row" class="txt-oflo">{{$waitlist['email']}}</td>
                                        <td>{{ $waitlist['branch']['name'] }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning"
                                                    title="Edit branch details"
                                                    data-toggle="modal"
                                                    data-target="#updatePreManager"
                                                    data-email="{{ $waitlist['email'] }}"
                                                    data-id="{{ $waitlist['id'] }}">Edit</button>
                                        </td>

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">
                                        <div class="d-flex justify-content-center">No preregistered manager yet</div>
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
    <div id="updatePreManager" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="updatePreManagerForm" action="{{ route('admin.manager.edit') }}" method="POST">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">
                            Update Email
                        </h4>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group mb-4">
                            <label id="name" class="col-sm-12">Email</label>
                            <input type="hidden" name="id" id="id" value="">
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
                        <button id="updatePreManagerBtn" type="submit" class="
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
@endsection

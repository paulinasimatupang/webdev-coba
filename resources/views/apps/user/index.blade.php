@extends('layouts.master')

@section('page-css')
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
@endsection

@section('main-content')
    <div class="breadcrumb">
        <h1>Users Management</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="row mb-4">
        <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center mb-3">
            <div class="input-group">
                @can('create user')
                    <a href="{{ route('users.create') }}">
                        <button class="btn btn-primary ripple m-1 add-new-btn" type="button">Add User</button>
                    </a>
                @endcan
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row">
                        <h4 class="col-sm-12 col-md-6 card-title mb-3">List of Users</h4>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success mt-2">{{ session('status') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table id="default_ordering_table" class="display table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Fullname</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->fullname }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if (!empty($user->getRoleNames()))
                                                @foreach ($user->getRoleNames() as $roleName)
                                                    <label class="badge bg-primary mx-1">{{ $roleName }}</label>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('users.edit', $user->id) }}">
                                                <button class="btn btn-success btn-sm m-1" type="button">Edit</button>
                                            </a>
                                            <button class="btn btn-danger btn-sm m-1 delete-btn" type="button" onclick="deleteConfirm({{ $user->id }})">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ asset('assets/js/vendor/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/js/es5/echart.options.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.script.js') }}"></script>
    <script src="{{ asset('assets/js/es5/dashboard.v4.script.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickadate/picker.date.js') }}"></script>
@endsection

@section('bottom-js')
    <script src="{{ asset('assets/js/form.basic.script.js') }}"></script>
    <script>
        function deleteConfirm(id) {
            if (confirm("Are you sure you want to delete this user?")) {
                $.ajax({
                    url: '{{ url("users") }}/' + id + '/delete',
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        location.reload(true);
                    },
                    error: function (response) {
                        alert("Error, Please try again later!");
                    }
                });
            }
        }
    </script>
    <style>
        .add-new-btn {
            background-color: #0a6e44;
            border: none;
            color: white;
        }

        .edit-btn,
        .delete-btn {
            background-color: #0182bd;
            border: none;
            color: white;
        }
    </style>
@endsection

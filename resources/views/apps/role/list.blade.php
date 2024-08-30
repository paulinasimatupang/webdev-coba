@extends('layouts.master')

@section('page-css')
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
@endsection

@section('main-content')
<div class="breadcrumb">
    <h1>Role Management</h1>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row mb-4">
    <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center mb-3">
        <div class="input-group">
            <a href="{{ route('roles.add') }}">
                <button class="btn btn-warning ripple m-1 add-new-btn" type="button">Add Role</button>
            </a>
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="row">
                    <h4 class="col-sm-12 col-md-6 card-title mb-3">List of Roles</h4>
                </div>

                @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="table-responsive">
                    <table id="default_ordering_table" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                            <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <a href="{{ route('roles.addPermissionToRole', $role) }}">
                                                <button class="btn btn-primary" type="button">Add/Edit Role</button>
                                            </a>
                                            <a href="{{ route('roles.edit', $role) }}">
                                                <button class="btn btn-success" type="button">Edit Role</button>
                                            </a>
                                            <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
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
<script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables.script.js') }}"></script>
@endsection

@section('bottom-js')
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
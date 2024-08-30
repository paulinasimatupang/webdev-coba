@extends('layouts.master')

@section('main-content')
<div class="breadcrumb">
    <h1>Role: {{ $role->name }}</h1>
</div>
<div class="separator-breadcrumb border-top"></div>

@if (session('status'))
<div class="alert alert-success">{{ session('status') }}</div>
@endif

@if ($errors->any())
<ul class="alert alert-warning">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-body">
                <form action="{{ route('roles.givePermissionToRole', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Permissions</label>
                        <div class="col-sm-10">
                            <div class="row">
                                @foreach ($permissions as $permission)
                                <div class="col-md-3 mb-2">
                                    <label>
                                        <input
                                            type="checkbox"
                                            name="permission[]"
                                            value="{{ $permission->name }}"
                                            {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }} />
                                        {{ $permission->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @error('permission') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12 text-right">
                            <a href="{{ route('roles.list') }}">
                                <button type="button" class="btn btn-danger">Back</button>
                            </a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-js')

@endsection

@section('bottom-js')

<script src="{{ asset('assets/js/form.validation.script.js') }}"></script>

@endsection
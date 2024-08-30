@extends('layouts.master')

@section('main-content')
<div class="breadcrumb">
    <h1>Edit Permission</h1>
</div>
<div class="separator-breadcrumb border-top"></div>

@if(Session('error'))
@foreach (Session('error') as $key => $item)
<div class="alert alert-danger" role="alert">
    <strong class="text-capitalize">Error : </strong> {{ $item[0] }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endforeach
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
                <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Permission Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" value="{{ $permission->name }}" class="form-control" placeholder="Permission Name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-right">
                            <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Back</a>
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
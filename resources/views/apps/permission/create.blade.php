@extends('layouts.master')

@section('main-content')
<div class="breadcrumb">
    <h1>Create Permission</h1>
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

<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-body">
                <form action="{{ route('permissions.store') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Permission Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" placeholder="Permission Name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-right">
                            <a href="{{ route('permissions.index') }}">
                                <button type="button" class="btn btn-primary">Back</button>
                            </a>
                            <button type="submit" class="btn btn-primary">Save</button>
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
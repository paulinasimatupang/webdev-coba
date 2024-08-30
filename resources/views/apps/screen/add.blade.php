@extends('layouts.master')

@section('main-content')
    <div class="breadcrumb">
        <h1>Add Screen</h1>
        <ul>
            <li><a href="">Selada</a></li>
        </ul>
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
                    <form action="{{ route('screen_store') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Screen ID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ old('screen_id') }}" name="screen_id" placeholder="Screen ID" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Screen Type</label>
                            <div class="col-sm-10">
                                <select name="screen_type_id" class="form-control">
                                    <option value="">Select Screen Type</option>
                                    @foreach($screen_type as $item)
                                        <option value="{{ $item->screen_type_id }}">{{ $item->screen_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Screen Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ old('screen_title') }}" name="screen_title" placeholder="Screen Title" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Version</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ old('version') }}" name="version" placeholder="Version" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Action URL</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ old('action_url') }}" name="action_url" placeholder="Action URL">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 text-right">
                                <a href="{{ route('screen') }}">
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

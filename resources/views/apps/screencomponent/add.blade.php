@extends('layouts.master')

@section('main-content')
    <div class="breadcrumb">
        <h1>Add Screen Component</h1>
        <ul>
            <li><a href="">Selada</a></li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    @if(Session('error'))
        <div class="alert alert-danger" role="alert">
            <strong class="text-capitalize">Error: </strong> {{ Session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">
                    <form action="{{ route('screen_component_store') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Screen ID</label>
                            <div class="col-sm-10">
                                <select name="screen_id" class="form-control">
                                    <option value="">Select Screen ID</option>
                                    @foreach($screens as $screen)
                                        <option value="{{ $screen->screen_id }}">{{ $screen->screen_id }} - {{ $screen->screen_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Component ID</label>
                            <div class="col-sm-10">
                                <select name="comp_id" class="form-control">
                                    <option value="">Select Component ID</option>
                                    @foreach($components as $component)
                                        <option value="{{ $component->comp_id }}">{{ $component->comp_id }} - {{ $component-> comp_lbl }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Sequence</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" value="{{ old('sequence') }}" name="sequence" placeholder="Sequence" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 text-right">
                                <a href="{{ route('screen_component') }}">
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

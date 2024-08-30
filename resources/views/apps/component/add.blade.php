@extends('layouts.master')

@section('main-content')
    <div class="breadcrumb">
        <h1>Add Component</h1>
        <ul>
            <li><a href="">Selada</a></li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    @if(Session::has('error'))
        @php
            $errors = Session::get('error');
            $errors = is_array($errors) ? $errors : [$errors];
        @endphp
        @foreach ($errors as $item)
            <div class="alert alert-danger" role="alert">
                <strong class="text-capitalize">Error : </strong> {{ $item }}
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
                    <form action="{{ route('component_store') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Component ID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ old('comp_id') }}" name="comp_id" placeholder="Component ID" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Component Label</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ old('comp_lbl') }}" name="comp_lbl" placeholder="Component Label" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Component Action</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ old('comp_act') }}" name="comp_act" placeholder="Component Action">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Component Label EN</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ old('comp_lbl_en') }}" name="comp_lbl_en" placeholder="Component Label EN">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Min Length</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" value="{{ old('min_length') }}" name="min_length" placeholder="Min Length"required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Max Length</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" value="{{ old('max_length') }}" name="max_length" placeholder="Max Length"required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Component Type</label>
                            <div class="col-sm-10">
                                <select name="component_type_id" class="form-control">
                                    <option value="">Select Component Type</option>
                                    @foreach($component_type as $item)
                                        <option value="{{ $item->component_type_id }}">{{ $item->componenet_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Component Content Type</label>
                            <div class="col-sm-10">
                                <select name="comp_content_type" class="form-control">
                                    <option value="">Select Component Content Type</option>
                                    @foreach($component_content_type as $item)
                                        <option value="{{ $item->comp_content_type }}">{{ $item->comp_content_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Visible</label>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="visible_true" name="visible" value="t" {{ old('visible') == 't' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="visible_true">
                                        True
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="visible_false" name="visible" value="f" {{ old('visible') == 'f' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="visible_false">
                                        False
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Mandatory</label>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="mandatory_true" name="mandatory" value="t" {{ old('mandatory') == 't' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="mandatory_true">
                                        True
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="mandatory_false" name="mandatory" value="f" {{ old('mandatory') == 'f' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="mandatory_false">
                                        False
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Disabled</label>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="disabled_true" name="disabled" value="t" {{ old('disabled') == 't' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="disabled_true">
                                        True
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="disabled_false" name="disabled" value="f" {{ old('disabled') == 'f' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="disabled_false">
                                        False
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 text-right">
                                <a href="{{ route('component') }}">
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

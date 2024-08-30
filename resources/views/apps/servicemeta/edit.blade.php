@extends('layouts.master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/pickadate/classic.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/pickadate/classic.date.css') }}">
@endsection

@section('main-content')
    <div class="container">
        <h1>Edit Service Meta</h1>
        <form action="{{ route('servicemeta_update', $group->id) }}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="service_id">Service ID</label>
                <input type="text" id="service_id" name="service_id" class="form-control" value="{{ $group->service_id }}" required>
            </div>
            <div class="form-group">
                <label for="seq">Sequence</label>
                <input type="number" id="seq" name="seq" class="form-control" value="{{ $group->seq }}" required>
            </div>
            <div class="form-group">
                <label for="meta_type_id">Meta Type ID</label>
                <input type="text" id="meta_type_id" name="meta_type_id" class="form-control" value="{{ $group->meta_type_id }}" required>
            </div>
            <div class="form-group">
                <label for="meta_default">Meta Default</label>
                <textarea id="meta_default" name="meta_default" class="form-control">{{ $group->meta_default }}</textarea>
            </div>
            <div class="form-group">
                <label for="influx">Influx</label>
                <select id="influx" name="influx" class="form-control">
                    <option value="1" {{ $group->influx ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ !$group->influx ? 'selected' : '' }}>No</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection

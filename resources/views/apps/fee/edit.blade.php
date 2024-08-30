@extends('layouts.master')

@section('main-content')
<div class="breadcrumb">
    <h1>Edit Fee</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('fee_update', ['meta_id' => $group->meta_id, 'service_id' => $group->service_id, 'seq' => $group->seq]) }}" method="POST">
                    @csrf
                    @method('POST')

                    <div class="form-group">
                        <label for="service_id">Fitur</label>
                        <input type="text" class="form-control" id="service_id" name="service_id" value="{{ str_replace(['Review', 'OTP'], '', $group->service->service_name) }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="meta_default">Nominal</label>
                        <input type="text" class="form-control" id="meta_default" name="meta_default" value="{{ old('meta_default', $group->meta_default) }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('fee') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

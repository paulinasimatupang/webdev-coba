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
                <form action="{{ route('persen_fee_update', ['id' => $group->id, 'penerima' => $group->penerima, 'persentase' => $group->persentase]) }}" method="POST">
                    @csrf
                    @method('post')
                    <div class="form-group">
                        <label for="service_id">ID</label>
                        <input type="text" class="form-control" id="id" name="id" value="{{ $group->id }}">
                    </div>

                    <div class="form-group">
                        <label for="meta_id">Peneriman</label>
                        <input type="text" class="form-control" id="penerima" name="penerima" value="{{ $group->penerima }}">
                    </div>

                    <div class="form-group">
                        <label for="meta_default">Persentase</label>
                        <input type="text" class="form-control" id="persentase" name="persentase" value="{{ $group->persentase }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('fee') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
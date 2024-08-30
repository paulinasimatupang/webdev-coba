@extends('layouts.master')

@section('main-content')
    <div class="breadcrumb">
        <h1>Add Persen Fee</h1>
        <!-- <ul>
            <li><a href="">Selada</a></li>
        </ul> -->
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
                <form action="{{ route('persen_fee_store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">ID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ old('id') }}" name="id" placeholder="ID" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Penerima</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ old('penerima') }}" name="penerima" placeholder="Penerima" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Persentase</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ old('persentase') }}" name="persentase" placeholder="Persentase" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-right">
                            <a href="{{ route('persen_fee') }}">
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

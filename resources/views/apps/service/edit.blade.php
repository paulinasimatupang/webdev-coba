@extends('layouts.master')

@section('main-content')
    <div class="breadcrumb">
        <h1>Edit Service</h1>
        <ul>
            <li><a href="">Selada</a></li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    @if(Session('error'))
        <div class="alert alert-danger" role="alert">
            <strong class="text-capitalize">Error : </strong> {{ Session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">
                    <form action="{{ route('service_update', [$service->service_id]) }}" method="POST">
                        @csrf
                        @method('POST')

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Service ID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ $service->service_id }}" name="service_id" placeholder="Service ID" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Service Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ $service->service_name }}" name="service_name" placeholder="Service Name" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Screen Response</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ $service->screen_response }}" name="screen_response" placeholder="Screen Response" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Service URL</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ $service->param1 }}" name="param1" placeholder="Service URL">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12 text-right">
                                <a href="{{ route('service') }}">
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

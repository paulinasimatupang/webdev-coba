@extends('layouts.master')
@section('main-content')
    <div class="breadcrumb">
                <h1>Add Terminal</h1>
                <!-- <ul>
                    <li><a href="">Selada</a></li>
                   
                </ul> -->
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
                            <form action="{{route('terminal_store')}}" method="POST">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Merchant</label>
                                    <div class="col-sm-10">
                                        <select name="merchant_id" class="form-control">
                                            <option value="">Select Merchant</option>
                                            @foreach($merchant as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                    <label class="col-sm-2 col-form-label">Terminal ID</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{Request::old('tid')}}" name="tid" placeholder="Terminal ID" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                    <label class="col-sm-2 col-form-label">Serial Number</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{Request::old('serial_number')}}" name="serial_number" placeholder="Serial Number" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">SID</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{Request::old('sid')}}" name="sid" placeholder="SID" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">ICCID</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{Request::old('iccid')}}" name="iccid" placeholder="ICCID" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">IMEI</label>
                                    <div class="col-sm-10">
                                        <input type="test" class="form-control" value="{{Request::old('imei')}}" name="imei" placeholder="IMEI" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 text-right">
                                        <a href="{{route('terminal')}}">
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

    <script src="{{asset('assets/js/form.validation.script.js')}}"></script>

@endsection

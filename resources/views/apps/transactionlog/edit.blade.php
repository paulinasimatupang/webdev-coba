@extends('layouts.master')
@section('main-content')
    <div class="breadcrumb">
                <h1>Set Reversal</h1>
                <ul>
                    <li><a href="">Selada</a></li>
                   
                </ul>
            </div>
    <div class="separator-breadcrumb border-top"></div>
   
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
                <div class="col-md-12">
                    <div class="card mb-5">
                        <div class="card-body">
                            <form action="{{ route('transactionlog_update', $data->additional_data) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>STAN:</strong>
                                            <input type="text" name="stan" value="{{ $data->stan }}" class="form-control" placeholder="STAN" disabled>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Amount:</strong>
                                            <input type="number" name="tx_amount" value="{{$data->tx_amount}}" class="form-control" placeholder="Amount" disabled>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>TX MTI:</strong>
                                            {{-- <input type="text" name="tx_mti" value="{{ $data->tx_mti }}" class="form-control" placeholder="Tx MTI"> --}}
                                            <select class="form-control" name="tx_mti" placeholder="Select Status">
                                                <option>Select Status</option>
                                                <option @if($data->tx_mti == '0200') selected @endif value="0200">Non Reversal</option>
                                                <option @if($data->tx_mti == '0400') selected @endif value="0400">Reversal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>RP MTI:</strong>
                                            {{-- <input type="text" name="rp_mti" value="{{ $data->rp_mti }}" class="form-control" placeholder="Rp MTI"> --}}
                                            <select class="form-control" name="rp_mti" placeholder="Select Status">
                                                <option>Select Status</option>
                                                <option @if($data->rp_mti == '0210') selected @endif value="0210">Non Reversal</option>
                                                <option @if($data->rp_mti == '0410') selected @endif value="0410">Reversal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <a href="{{url()->previous()}}">
                                                <button type="button" class="btn btn-primary">Back</button>
                                            </a>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
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

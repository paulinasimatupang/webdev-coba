@extends('apps.transactionlog.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Transaction Log</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('transaction_log') }}"> Back</a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>STAN:</strong>
                {{ $transactionLog->stan }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Amount:</strong>
                {{ $transactionLog->amount }}
            </div>
        </div>
    </div>
@endsection
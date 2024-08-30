@extends('layouts.master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/pickadate/classic.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/pickadate/classic.date.css') }}">
@endsection

@section('main-content')
<div class="breadcrumb">
    <h1>Transaction Ranking</h1>
    <!-- <ul>
        <li><a href="">Home</a></li>
        <li><a href="#">Transaction Ranking</a></li>
    </ul> -->
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row mb-4">
    <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center mb-3">
        <!-- Optional button or other controls -->
    </div>
    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="row">
                    <h4 class="col-sm-12 col-md-6 card-title mb-3">List of Transaction Rankings</h4>
                </div>
                
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                @if ($message = Session::get('failed'))
                    <div class="alert alert-danger">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <div class="table-responsive">
                    <table id="deafult_ordering_table" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Account Number</th>
                                <th scope="col">Merchant Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Email</th>
                                <th scope="col">MID</th>
                                <th scope="col">Transaction Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rankedTransactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->account_number }}</td>
                                    <td>{{ $transaction->merchant_name }}</td>
                                    <td>{{ $transaction->address }}</td>
                                    <td>{{ $transaction->email }}</td>
                                    <td>{{ $transaction->mid }}</td>
                                    <td>{{ $transaction->transaction_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-js')
    <script src="{{ asset('assets/js/vendor/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/js/es5/echart.options.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.script.js') }}"></script>
    <script src="{{ asset('assets/js/es5/dashboard.v4.script.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickadate/picker.date.js') }}"></script>
@endsection

@section('bottom-js')
    <script src="{{ asset('assets/js/form.basic.script.js') }}"></script>
@endsection

@section('styles')
    <style>
        .card-title {
            color: #0a6e44;
        }
    </style>
@endsection

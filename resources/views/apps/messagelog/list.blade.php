@extends('layouts.master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/pickadate/classic.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/pickadate/classic.date.css') }}">
@endsection

@section('main-content')
<style>
    #b1, #b2, #b3 {
        display: none;
    }
</style>

<div class="breadcrumb">
    <h1>Message Log</h1>
    <!-- <ul>
        <li><a href="#">Selada</a></li>
    </ul> -->
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="2-columns-form-layout">
    <div class="card mb-4">
        <form method="GET" action="{{ url('message') }}" id="message_filter_form">
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="inputtext11" class="ul-form__label">Message ID:</label>
                        <input type="text" class="form-control" value="{{ request('search') }}" name="search" id="search" placeholder="Message ID">
                    </div>
                </div>

                <div class="custom-separator"></div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="start_date" class="ul-form__label">Start Date:</label>
                        <input type="text" readonly="readonly" class="form-control start_date" value="{{ request('start_date') }}" name="start_date" id="start_date" placeholder="Start Date">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="end_date" class="ul-form__label">End Date:</label>
                        <div class="input-right-icon">
                            <input type="text" readonly="readonly" class="form-control end_date" value="{{ request('end_date') }}" name="end_date" id="end_date" placeholder="End Date">
                        </div>
                    </div>
                </div>

                <div class="custom-separator"></div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="terminal_id" class="ul-form__label">TID:</label>
                        <input type="text" class="form-control" value="{{ request('terminal_id') }}" name="terminal_id" id="terminal_id" placeholder="Terminal ID">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="service_id" class="ul-form__label">Service:</label>
                        <input type="text" class="form-control" value="{{ request('service_id') }}" name="service_id" id="service_id" placeholder="Service ID">
                    </div>
                </div>

                <div class="custom-separator"></div>
            </div>

            <div class="card-footer">
                <div class="mc-footer">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn btn-success m-1">Search</button>
                            <a href="{{ url('message') }}" class="btn btn-outline-secondary m-1">Clear</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="row">
                    <h4 class="col-sm-9 col-md-6 card-title mb-3" style="line-height: 2.1rem;">List Message Log</h4>
                </div>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <div class="table-responsive">
                    <table id="default_ordering_table" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Log ID</th>
                                <th scope="col">Message ID</th>
                                <th scope="col">Terminal ID</th>
                                <th scope="col">Service ID</th>
                                <th scope="col">Request Time</th>
                                <th scope="col">Reply Time</th>
                                <th scope="col">Response Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = ($data->perPage() * ($data->currentPage() - 1)) + 1;
                            @endphp
                            @foreach($data as $item)
                                <tr>
                                    <th scope="row">{{ $no }}</th>
                                    <td>{{ $item->log_id }}</td>
                                    <td>{{ $item->message_id }}</td>
                                    <td>{{ $item->terminal_id }}</td>
                                    <td>{{ $item->service_id }}</td>
                                    <td>{{ $item->request_time }}</td>
                                    <td>{{ $item->reply_time }}</td>
                                    <td>{{ $item->message_status }}</td>
                                </tr>
                                @php
                                    $no++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-4 text-center">{{ $data->appends(request()->input())->links() }}</div>
    </div>
</div>
@endsection

@section('page-js')
    <script src="{{ asset('assets/js/vendor/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/js/es5/echart.options.min.js') }}"></script>
    <!-- <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/js/datatables.script.js') }}"></script> -->
    <script src="{{ asset('assets/js/es5/dashboard.v4.script.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/pickadate/picker.date.js') }}"></script>

    <script>
        var $dateFrom = $('.start_date').pickadate({format: 'yyyy-mm-dd'}),
            dateFromPicker = $dateFrom.pickadate('picker');

        var $dateTo = $('.end_date').pickadate({format: 'yyyy-mm-dd'}),
            dateToPicker = $dateTo.pickadate('picker');

        dateFromPicker.on({
            open: function(e) {
                console.log('Open start_date');
                if ($dateFrom.val()) {
                    console.log('User is making a change to start_date');
                }
            },
            close: function(e) {
                if ($dateFrom.val() && !$dateTo.val()) {
                    console.log('Open end_date via start_date');
                    dateToPicker.open();
                } else if (!$dateFrom.val()) {
                    console.log('User left start_date empty. Not popping end_date');
                }
                console.log('Close start_date');
                // workaround for github issue #160
                $(document.activeElement).blur();
            }
        });

        dateToPicker.on({
            open: function(e) {
                console.log('Popped end_date');
                if ($dateTo.val()) {
                    console.log('User is making a change to end_date');
                }
            },
            close: function(e) {
                if (!$dateTo.val()) {
                    console.log('User left end_date empty. Not popping start_date or end_date');
                }
                console.log('Close end_date');
                // workaround for github issue #160
                $(document.activeElement).blur();
            }
        });
    </script>
@endsection

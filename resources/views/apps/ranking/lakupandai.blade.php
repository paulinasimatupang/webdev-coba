@extends('layouts.master')
@section('page-css')
     <link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
     <link rel="stylesheet" href="{{asset('assets/styles/vendor/pickadate/classic.css')}}">
     <link rel="stylesheet" href="{{asset('assets/styles/vendor/pickadate/classic.date.css')}}">

@endsection
@section('main-content')
<style type="text/css">
#b1, #b2, #b3 {
display: none;

}

</style>
            <div class="breadcrumb">
                <h1>Ranking Laku Pandai</h1>
                <ul>
                    <li><a href="">Selada</a></li>
                    
            </div>
            <div class="separator-breadcrumb border-top"></div>
            <div class="2-columns-form-layout">
                <div class="">
                    <div class="row">
                        <div class="col-lg-12">
                            
                            <div class="card mb-4">
                                <form method="GET" action="transaction" id="transaction_filter_form">
                                    <div class="card-body">


                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="inputtext11" class="ul-form__label">Transaction Code:</label>
                                                <input type="text" class="form-control" value="{{app('request')->input('search')}}" name="search" id="search" placeholder="Transaction Code">
                                            </div>
                                        </div>

                                        <div class="custom-separator"></div>


                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputtext14" class="ul-form__label">Start Date:</label>
                                                <input type="text" readonly="readonly" class="form-control start_date" value="{{app('request')->input('start_date')}}" name="start_date" id="start_date" placeholder="Start Date">
                                                
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail15" class="ul-form__label">End Date:</label>
                                                <div class="input-right-icon">
                                                    <input type="text" readonly="readonly" class="form-control end_date" value="{{app('request')->input('end_date')}}" name="end_date" id="end_date" placeholder="End Date">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="custom-separator"></div>


                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="inputtext14" class="ul-form__label">TID:</label>
                                                <input type="text" class="form-control" value="{{app('request')->input('terminal_id')}}" name="terminal_id" id="terminal_id" placeholder="Terminal ID">
                                                
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="inputEmail15" class="ul-form__label">MID:</label>
                                                <div class="input-right-icon">
                                                    <input type="text" class="form-control" value="{{app('request')->input('merchant_id')}}" name="merchant_id" id="merchant_id" placeholder="Merchant ID">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="custom-separator"></div>


                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="inputtext14" class="ul-form__label">Service:</label>
                                                <input type="text" class="form-control" value="{{app('request')->input('service_id')}}" name="service_id" id="service_id" placeholder="Service">
                                                
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="inputEmail15" class="ul-form__label">Status:</label>
                                                <div class="input-right-icon">
                                                    <!-- <input type="text" class="form-control" value="{{app('request')->input('service')}}" name="service" id="service" placeholder="Service Name"> -->
                                                    <select class="form-control" name="status" id="status" placeholder="Select Status">
                                                        <option>Select Status</option>
                                                        <option @php if (app('request')->input('status') == 'Pending') echo 'selected' @endphp>Pending</option>
                                                        <option @php if (app('request')->input('status') == 'Success') echo 'selected' @endphp>Success</option>
                                                        <option @php if (app('request')->input('status') == 'Failed') echo 'selected' @endphp>Failed</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="card-footer">
                                        <div class="mc-footer">
                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <button type="submit" class="btn  btn-success m-1">Save</button>
                                                    <a href='https://report.selada.id/transaction' type="button" class="btn btn-outline-secondary m-1">Clear</a>



                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>

                                <!-- end::form 3-->

                            </div>
                            
                        </div>

                    </div>
                    <!-- end of main row -->
                
                
                <div class="col-md-12 mb-3">
                    <div class="card text-left">
                        <div class="card-body">
                            <div class="row">
                                <h4 class=" col-sm-9 col-md-6 card-title mb-3" style="line-height: 2.1rem;">List Transaction </h4>
				<div class="col-sm-3 col-md-12 mb-3">
				     <div style="display: inline-block;     float: right;" class="export-button-wrapper">
                        
                                {{-- <a id="btn-sale-reversal" 
                    			style="" href="#" 
                    			type="button" class="btn btn-outline-secondary">
                    			        Check Reversal
                    			</a> --}}

                                @php if($username == 'selada_produktif') echo '<a id="btn-sale-bjb" 
                    			style="" href="#" 
                    			type="button" class="btn btn-outline-secondary">
                    			        Ubah Status Transaksi
                    			</a>
                                '
                                @endphp
                                <a id="export-fee-to-excel" 
                    			style="" href='#' 
                    			type="button" class="btn btn-outline-secondary">
                    			        Export Fee Agen to Excel
                    			</a>
                    			<a id="export-to-csv" 
                    			style="" href='#' 
                    			type="button" class="btn btn-outline-secondary">
                    			        Export to CSV
                    			</a>
                    			<a id="export-to-excel" 
                    			style="" href='#' 
                    			type="button" class="btn btn-outline-secondary">
                        		 	    Export to Excel
                    			</a>
					            <a id="sale-export-to-excel" 
                                        style="" href='#' 
                                        type="button" class="btn btn-outline-secondary">
                                        Export to Excel (Payment Only)
                                </a>
                    			<a id="export-to-pdf"
                    			style="display:none" href='#' 
                    			type="button" class="btn btn-outline-secondary">
                    			        Export to PDF
                    			</a>
				     </div>
            			</div>
                            </div>
                        
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table id="deafult_ordering_table" class="display table table-striped table-bordered" style="width:150%">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Transaction Code</th>
                                            <th scope="col">TID</th>
                                            <th scope="col">MID</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Fee</th>
                                            <th scope="col">Trace Number</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = ($data->perPage() * ($data->currentPage() - 1))+1;
                                            $status = ' ';
                                            $statusBJB = ' ';
                                        @endphp
                                        @foreach($data as $item)
                                        <tr>
                                            <th scope="row">{{ $no }}</th>
                                            
                                            <td>{{!empty($item->user) ? $item->user->username : ''}}</td>
                                            <td>{{$item->transaction_id}}</td>>
                                            <td>{{!empty($item->terminal) ? $item->terminal->terminal_id : ''}}</td>
                                            <td>{{!empty($item->terminal) ? $item->terminal->merchant_id : ''}}</td>
                                            <td>@currency($item->amount)</td>
                                            <td>@currency($item->fee)</td>
                                            <td>{{$item->trace_no}}</td>
                                            <td>{{$item->transaction_time}}</td>
                                            <td>{{$item->transaction_status_id}}</td>
                                            <td>
                                                <!-- <a href="{{route('transaction_updateStatus',[$item->id])}}">
                                                    <button class="btn btn-primary ripple btn-sm m-1" type="button" @php if ($item->status_text == 'Success' || $item->status_text == 'Failed') echo 'id="b1" ' @endphp @php if($username !== 'selada_produktif') echo 'disabled' @endphp>Update</button>
                                                </a>
                                                {{-- <button onClick="changeStatus({{$item->id}})" class="btn btn-outline-info ripple btn-sm m-1" type="button" @php if($item->status_text == 'Success') echo 'disabled' @endphp>{{$status}}</button> --}}
                                                {{-- <select onchange="if (this.selectedIndex) changeStatus({{$item->id}})" class="form-control" name="is-suspect" @php if ($item->status_text == 'Success' || $item->status_text == 'Failed') echo 'id="b1"' @endphp placeholder="Select Status">
                                                        <option>Select Status</option>
                                                        <option onClick="changeStatus({{$item->id}})" @php if ($item->status_text == 'Success' || $item->status_text == 'Failed') echo 'disabled' @endphp>Success</option>
                                                        <option onClick="changeStatus({{$item->id}})" @php if ($item->status_text == 'Success' || $item->status_text == 'Failed') echo 'disabled' @endphp>Failed</option>
                                                </select>                                     --}}
                                            </td>
                                            <td>
                                                <a href="{{route('transactionlog_edit',[$item->stan])}}">
                                                    <button class="btn btn-primary ripple btn-sm m-1" type="button" @php if ($item->status_text == 'Success' || $item->status_text == 'Pending') echo 'id="b1" ' @endphp @php if($username !== 'selada_produktif') echo 'disabled' @endphp>Set Reversal</button>
                                                </a>
                                            </td> -->
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
                    <center><div class="mt-4 center">{{$data->appends(request()->input())->links()}}</div></center>
                </div>
            </div>
@endsection

@section('page-js')
     <script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
     <!-- <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script> -->
     <!-- <script src="{{asset('assets/js/datatables.script.js')}}"></script> -->
     <script src="{{asset('assets/js/es5/dashboard.v4.script.js')}}"></script>
     <script src="{{asset('assets/js/vendor/pickadate/picker.js')}}"></script>
     <script src="{{asset('assets/js/vendor/pickadate/picker.date.js')}}"></script>

     <script>
        $("#export-to-excel").on('click', function() {
                    window.location = "transaction/export?"+$('#transaction_filter_form').serialize()
        });
        $("#sale-export-to-excel").on('click', function() {
                window.location = "transaction/saleExport?"+$('#transaction_filter_form').serialize()
                // window.location = "http://laravel.test/transaction/saleExport?"+$('#transaction_filter_form').serialize()
        });
        $("#export-to-pdf").on('click', function() {
                window.location = "transaction/exportPDF?"+$('#transaction_filter_form').serialize()
        });
        $("#export-to-csv").on('click', function() {
                window.location = "transaction/exportCSV?"+$('#transaction_filter_form').serialize()
        });
        $("#export-fee-to-excel").on('click', function() {
                window.location = "transaction/feeExport?"+$('#transaction_filter_form').serialize()
                // window.location = "http://laravel.test/transaction/feeExport?"+$('#transaction_filter_form').serialize()
        });
        $("#btn-sale-bjb").on('click', function() {
                window.location = "transaction_log?"+$('#transaction_filter_form').serialize()
        });
        $("#btn-sale-reversal").on('click', function() {
                window.location = "transaction/reversal?"+$('#transaction_filter_form').serialize()
        });
        var $dateFrom = $('.start_date').pickadate({format:'yyyy-mm-dd'}),
            dateFromPicker = $dateFrom.pickadate('picker');

        var $dateTo = $('.end_date').pickadate({format:'yyyy-mm-dd'}),
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
            }
            else if (!$dateFrom.val()) {
            console.log('User left start_date empty. Not popping end_date');
            }
            console.log('Close start_date');
            // workaround for github issue #160
            $(document.activeElement).blur();
        }
        });
        dateToPicker.on({
        open: function(e) {
            console.log('Poppped end_date');
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
@section('bottom-js')
<script src="{{asset('assets/js/form.basic.script.js')}}"></script>
<script>
    function changeStatus(id) {
        var r = confirm("Anda akan merubah status transaksi, Apakah anda yakin?");
        if (r == true) {
            var url = '{{route("transaction_update",[":id"])}}';
            url = url.replace(':id', id);
            
            $.post(url,
            {
                _token: "{{ csrf_token() }}",
            },
            function(data,status){
                location.reload(true);
            }).done(function() {
                location.reload(true);
            }).fail(function() {
                alert( "Error, Please try again later!" );
            })
        }
    }
</script>
<script>
    function changeStatusBJB(id, date) {
        var r = confirm("Anda akan merubah status transaksi, Apakah anda yakin?");
        if (r == true) {
            // var e = document.getElementById("change_status_bjb");
            // var strType = e.options[e.selectedIndex].text;
            // var url = '{{route("transaction_update",[":stan|:date|:type"])}}';
            var split = "|";
            var url = '{{route("transaction_update",[":id_:date"])}}';
            url = url.replace(':id', id);
            // url = url.replace(':id', id + split + date.substring(0,10));
            url = url.replace(':date', date.substring(0,10));
            // url = url.replace(':type', strType);
            $.post(url,
            {
                _token: "{{ csrf_token() }}",
            },
            function(data,status){
                location.reload(true);
            }).done(function() {
                location.reload(true);
            }).fail(function() {
                console.error();
                alert( "Error, Please try again later!" );
            })
        }
    }
</script>

@endsection

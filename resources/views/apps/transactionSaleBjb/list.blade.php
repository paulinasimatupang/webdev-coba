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
                <h1>Transaction Sale BJB</h1>
                <ul>
                    <li><a href="">Selada</a></li>
                    
            </div>
            <div class="separator-breadcrumb border-top"></div>
            <div class="2-columns-form-layout">
                <div class="">
                    <div class="row">
                        <div class="col-lg-12">
                            
                            <div class="card mb-4">
                                <form method="GET" action="transactionSaleBjb" id="transaction_filter_form">
                                    <div class="card-body">

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
                                                <label for="inputtext14" class="ul-form__label">STAN:</label>
                                                <input type="text" class="form-control" value="{{app('request')->input('stan')}}" name="stan" id="stan" placeholder="STAN">
                                                
                                            </div>
                                        </div>


                                    </div>

                                    <div class="card-footer">
                                        <div class="mc-footer">
                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <button type="submit" class="btn  btn-primary m-1">Save</button>
                                                    <a href='https://report.selada.id/transactionSaleBjb' type="button" class="btn btn-outline-secondary m-1">Clear</a>



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
                </div>
            </div>
            <div class="row mb-4">
                
            <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-2">
                        <div class="card-body text-center">
                            <i class="i-Add-User"></i>
                           <div class="content max_width_bintang ml-4">
                                <p class="text-muted mt-2 mb-0">Total Transaction</p>
                                <p class="text-primary text-24 line-height-1 mb-2">{{ $dataRevenue['total_trx'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Financial"></i>
                            <div class="content max_width_bintang ml-4">
                                <p class="text-muted mt-2 mb-0">Amount Transaction</p>
                                <p class="text-primary text-24 line-height-1 mb-2">@currency($dataRevenue['amount_trx'])</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12 mb-3">
                    <div class="card text-left">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="deafult_ordering_table" class="display table table-striped table-bordered" style="width:150%">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Stan</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Status Reversal</th>
                                            <th scope="col">Suspect/Reversal</th>
                                            {{-- <th scope="col">Status Suspect</th>
                                            <th scope="col">Action</th> --}}
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
                                            
                                            <td>{{$item->stan}}</td>
                                            <td>@currency($item->tx_amount)</td>
                                            <td>{{$item->created_at}}</td>
                                            <td>{{$item->status_text}}</td>
                                            <td>{{$item->status_reversal}}</td>
                                            <td>
                                                {{-- <a href="{{route('transactionBJB_edit',[$item->stan . '_' . $item->created_at])}}">
                                                    <button class="btn btn-primary ripple btn-sm m-1" type="button" @php if ($item->status_text == 'Success' || $item->status_text == 'Pending') echo 'id="b1"' @endphp>Set Reversal</button>
                                                </a> --}}
                                                <select onchange="if (this.selectedIndex) changeStatusBJB('{{$item->stan}}')" class="form-control" name="is-suspect" @php if ($item->status_text == 'Pending') echo 'id="b1"'; if ($item->status_text !== 'Pending') echo 'id="change_status_bjb"' @endphp placeholder="Select Status">
                                                        <option>Select Sus/Rev</option>
                                                        <option onClick="changeStatusBJB({{$item->stan}}, {{$item->created_at}})" @php if ($item->status_text == 'Success' || $item->status_text == 'Pending') echo 'disabled' @endphp>Reversal</option>
                                                        <option onClick="changeStatusBJB({{$item->stan}}, {{$item->created_at}})" @php if ($item->status_text == 'Success' || $item->status_text == 'Pending') echo 'disabled' @endphp>Suspect</option>
                                                </select>                                    
                                            </td>
                                            {{-- <td>
                                                {{$item->status_suspect}} --}}
                                                {{-- <select class="form-control" name="is-suspect" id="is-suspect" placeholder="Select Status">
                                                        <option>Select Status</option>
                                                        <option @php if ($item->status_text == 'True') echo 'selected' @endphp>True</option>
                                                        <option @php if ($item->status_text !== 'True') echo 'selected' @endphp>False</option>
                                                    </select><br>                                     --}}
                                            {{-- </td> --}}
                                            {{-- <td><a href="{{route('transaction_edit',[$item->id])}}">
                                                    <button class="btn btn-primary ripple btn-sm m-1" type="button">Ubah Status</button>
                                                </a>
                                            </td> --}}
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
                    window.location = "https://report.selada.id/transaction/export?"+$('#transaction_filter_form').serialize()
        });
        $("#sale-export-to-excel").on('click', function() {
                window.location = "https://report.selada.id/transaction/saleExport?"+$('#transaction_filter_form').serialize()
        });
        $("#export-to-pdf").on('click', function() {
                window.location = "https://report.selada.id/transaction/exportPDF?"+$('#transaction_filter_form').serialize()
        });
        $("#export-to-csv").on('click', function() {
                window.location = "https://report.selada.id/transaction/exportCSV?"+$('#transaction_filter_form').serialize()
        });
        $("#fee-export-to-excel").on('click', function() {
                window.location = "http://laravel.test/transaction/feeExport?"+$('#transaction_filter_form').serialize()
        });
        var $dateFrom = $('.start_date').pickadate({format:'mm-dd-yyyy'}),
            dateFromPicker = $dateFrom.pickadate('picker');

        var $dateTo = $('.end_date').pickadate({format:'mm-dd-yyyy'}),
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
    function changeStatusBJB(id) {
        var r = confirm("Anda akan merubah status transaksi, Apakah anda yakin?");
        if (r == true) {
            // var e = document.getElementById("change_status_bjb");
            // var strType = e.options[e.selectedIndex].text;
            // var url = '{{route("transaction_updatebjb",[":stan|:date|:type"])}}';
            var split = "|";
            var url = '{{route("transaction_updatebjb",[":id"])}}';
            url = url.replace(':id', id);
            // url = url.replace(':id', id + split + date.substring(0,10));
            // url = url.replace(':date', date.substring(0,10));
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

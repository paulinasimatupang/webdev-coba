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
                <h1>Agent Fee</h1>
                <ul>
                    <li><a href="">Selada</a></li>
                    
            </div>
            <div class="separator-breadcrumb border-top"></div>

            <div class="row mb-4">
                
                <div class="col-md-12 mb-3">
                    <div class="card text-left">
                        <div class="card-body">
                            
                        <div class="flex_bintang">
                                <h4 class="card-title mb-3">Top 10 Agent Fee {{$month}}</h4>
                               
                            </div>
                            <div class="table-responsive">
                                        <table id="deafult_ordering_table" class="display table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">No</th>
                                                        <th scope="col">TID</th>
                                                        <th scope="col">Agent Name</th>
                                                        <th scope="col">Total Amount Fee</th>
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
                                                        
                                                        <td>{{$item->tid}}</td>
                                                        <td>{{$item->agent_name}}</td>
                                                        <td>@currency($item->total_amount_fee)</td>
                                                    </tr>
                                                    @php
                                                        $no++;
                                                    @endphp
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                <a href="{{route('dashboard')}}">
                                                    <button type="button" class="btn btn-primary">Back</button>
                                                </a>
                                            </div>
                                        </div>

                        </div>
                    </div>
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
            // var url = '{{route("transaction_updatebjb",[":stan|:date|:type"])}}';
            var split = "|";
            var url = '{{route("transaction_updatebjb",[":id_:date"])}}';
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

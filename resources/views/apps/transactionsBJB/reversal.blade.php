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
                <h1>Transaction Reversal</h1>
                <ul>
                    <li><a href="">Selada</a></li>
                    
            </div>
            <div class="separator-breadcrumb border-top"></div>
            <div class="row mb-4">
                
                {{-- <div class="col-lg-4 col-md-4 col-sm-4">
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

                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Financial"></i>
                            <div class="content max_width_bintang ml-4">
                                <p class="text-muted mt-2 mb-0">Total Fee</p>
                                <p class="text-primary text-24 line-height-1 mb-2">@currency($dataRevenue['total_fee'])</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-2">
                        <div class="card-body text-center">
                            <i class="i-Add-User"></i>
                           <div class="content max_width_bintang ml-4">
                                <p class="text-muted mt-2 mb-0">Total Fee Agent</p>
                                <p class="text-primary text-24 line-height-1 mb-2">@currency($dataRevenue['total_fee_agent'])</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Financial"></i>
                            <div class="content max_width_bintang ml-4">
                                <p class="text-muted mt-2 mb-0">Total Fee BJB</p>
                                <p class="text-primary text-24 line-height-1 mb-2">@currency($dataRevenue['total_fee_bjb'])</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Financial"></i>
                            <div class="content max_width_bintang ml-4">
                                <p class="text-muted mt-2 mb-0">Total Fee Selada</p>
                                <p class="text-primary text-24 line-height-1 mb-2">@currency($dataRevenue['total_fee_selada'])</p>
                            </div>
                        </div>
                    </div>
                </div> --}}
                
                
                <div class="col-md-12 mb-3">
                    <div class="card text-left">
                        <div class="card-body">
                            <div class="row">
                                <h4 class=" col-sm-9 col-md-6 card-title mb-3" style="line-height: 2.1rem;">List Transaction </h4>
				<div class="col-sm-3 col-md-12 mb-3">
				     <div style="display: inline-block;     float: right;" class="export-button-wrapper">
                                
                                {{-- @php if($username == 'selada_produktif') echo '<a id="btn-sale-bjb" 
                    			style="" href="#" 
                    			type="button" class="btn btn-outline-secondary">
                    			        Sale BJB
                    			</a>
                                <a id="btn-sale-reversal" 
                    			style="" href="#" 
                    			type="button" class="btn btn-outline-secondary">
                    			        Check Reversal
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
                    			</a> --}}
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
                                            <th>No</th>
                                            <th>STAN</th>
                                            <th>Tx Time</th>
                                            <th>Procode</th>
                                            <th>Response Code</th>
                                            <th>Tx MTI</th>
                                            <th>Rp MTI</th>
                                            <th>Amount</th>
                                            <th>Transaction ID</th>
                                            <th>Additional Data</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = ($data->perPage() * ($data->currentPage() - 1))+1;
                                            $status = ' ';
                                            $statusBJB = ' ';
                                        @endphp
                                        @foreach($data as $trx)
                                        <tr>
                                            <th scope="row">{{ $no }}</th>
                                            
                                            <td>{{ $trx->stan }}</td>
                                            <td>{{ $trx->tx_time }}</td>
                                            <td>{{ $trx->proc_code }}</td>
                                            <td>{{ $trx->responsecode }}</td>
                                            <td>{{ $trx->tx_mti }}</td>
                                            <td>{{ $trx->rp_mti }}</td>
                                            <td>@currency($trx->tx_amount)</td>
                                            <td>{{ $trx->transaction_id }}</td>
                                            <td>{{ $trx->additional_data }}</td>
                                            <td>Perlu dilakukan reversal</td>
                                            <td>
                                                {{-- <select onchange="if (this.selectedIndex) changeStatus('{{ $trx->additional_data }}')" class="form-control" name="tx_mti" placeholder="Select Status">
                                                    <option>Select Status</option>
                                                    <option @php if ($trx->tx_mti == '0400' && $trx->rp_mti == '0410') echo 'selected' @endphp>Reversal</option>
                                                    <option @php if ($trx->tx_mti == '0200' && $trx->rp_mti == '0210') echo 'selected' @endphp>Non Reversal</option>
                                                </select> --}}
                                                <a href="{{route('transactionBJB_postReversal',[$trx->additional_data])}}">
                                                    <button class="btn btn-primary ripple btn-sm m-1" type="button">Set Reversal</button>
                                                </a>
                                                {{-- <form action="{{ route('transactionlog_destroy',$trx->additional_data) }}" method="POST">
                                
                                                    <a class="btn btn-info" href="{{ route('transactionlog_show',$trx->additional_data) }}">Show</a>
                                    
                                                    <a class="btn btn-primary" href="{{ route('transactionlog_edit',$trx->additional_data) }}">Edit</a>
                                
                                                    @csrf
                                                    @method('DELETE')
                                    
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form> --}}
                                            </td>
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
                // window.location = "http://laravel.test/transaction/saleExport?"+$('#transaction_filter_form').serialize()
        });
        $("#export-to-pdf").on('click', function() {
                window.location = "https://report.selada.id/transaction/exportPDF?"+$('#transaction_filter_form').serialize()
        });
        $("#export-to-csv").on('click', function() {
                window.location = "https://report.selada.id/transaction/exportCSV?"+$('#transaction_filter_form').serialize()
        });
        $("#export-fee-to-excel").on('click', function() {
                window.location = "https://report.selada.id/transaction/feeExport?"+$('#transaction_filter_form').serialize()
                // window.location = "http://laravel.test/transaction/feeExport?"+$('#transaction_filter_form').serialize()
        });
        $("#btn-sale-bjb").on('click', function() {
                window.location = "https://report.selada.id/transaction_log?"+$('#transaction_filter_form').serialize()
        });
        $("#btn-sale-reversal").on('click', function() {
                window.location = "transaction/reversal?"+$('#transaction_filter_form').serialize()
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
            var url = '{{route("transactionBJB_update",[":id"])}}';
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
            // var url = '{{route("transactionBJB_updatebjb",[":stan|:date|:type"])}}';
            var split = "|";
            var url = '{{route("transactionBJB_updatebjb",[":id_:date"])}}';
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

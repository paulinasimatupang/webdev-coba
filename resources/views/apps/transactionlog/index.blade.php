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
                                <form method="GET" action="transaction_log" id="transaction_filter_form">
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputtext14" class="ul-form__label">STAN:</label>
                                                <input type="text" class="form-control" value="{{app('request')->input('stan')}}" name="stan" id="stan" placeholder="STAN">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="inputtext14" class="ul-form__label">Additional Data:</label>
                                                <input type="text" class="form-control" value="{{app('request')->input('additional_data')}}" name="additional_data" id="additional_data" placeholder="Additional Data">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <div class="mc-footer">
                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <button type="submit" class="btn  btn-primary m-1">Save</button>
                                                    <a href='https://report.selada.id/transaction_log' type="button" class="btn btn-outline-secondary m-1">Clear</a>
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
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <div class="table-responsive">
        <table id="deafult_ordering_table" class="display table table-striped table-bordered" style="width:100%">
            <tr>
                <th>No</th>
                <th>STAN</th>
                <th>Procode</th>
                <th>Response Code</th>
                <th>Tx MTI</th>
                <th>Rp MTI</th>
                <th>Amount</th>
                <th>Transaction ID</th>
                <th>Additional Data</th>
                <th>Action</th>
            </tr>
            @foreach ($transactionlog as $trx)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $trx->stan }}</td>
                <td>{{ $trx->proc_code }}</td>
                <td>{{ $trx->responsecode }}</td>
                <td>{{ $trx->tx_mti }}</td>
                <td>{{ $trx->rp_mti }}</td>
                <td>@currency($trx->tx_amount)</td>
                <td>{{ $trx->transaction_id }}</td>
                <td>{{ $trx->additional_data }}</td>
                <td>
                    {{-- <select onchange="if (this.selectedIndex) changeStatus('{{ $trx->additional_data }}')" class="form-control" name="tx_mti" placeholder="Select Status">
                        <option>Select Status</option>
                        <option @php if ($trx->tx_mti == '0400' && $trx->rp_mti == '0410') echo 'selected' @endphp>Reversal</option>
                        <option @php if ($trx->tx_mti == '0200' && $trx->rp_mti == '0210') echo 'selected' @endphp>Non Reversal</option>
                    </select> --}}
                    <a href="{{route('transactionlog_edit',[$trx->additional_data])}}">
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
            @endforeach
        </table>
        <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <a href="{{url()->previous()}}">
                <button type="button" class="btn btn-primary">Back</button>
            </a>
        </div>
        </div>
    </div>

    
    
  
    {!! $transactionlog->links() !!}
                </div>
            </div>
      
@endsection
@section('page-js')
     <script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
     <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
     <script src="{{asset('assets/js/datatables.script.js')}}"></script>
     <script src="{{asset('assets/js/es5/dashboard.v4.script.js')}}"></script>
     <script src="{{asset('assets/js/vendor/pickadate/picker.js')}}"></script>
     <script src="{{asset('assets/js/vendor/pickadate/picker.date.js')}}"></script>

@endsection

@section('bottom-js')
<script>
    function changeStatus(additional_data) {
        var r = confirm("Anda akan merubah status transaksi " + String(additional_data) + ", Apakah anda yakin?");
        if (r == true) {
            var url = '{{route("transactionlog_updatestatus",[":additional_data"])}}';
            url = url.replace(':additional_data', additional_data);
            
            $.put(url,
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
@endsection
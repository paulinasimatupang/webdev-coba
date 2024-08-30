@extends('layouts.master')
@section('main-content')
    <div class="breadcrumb">
                <h1>Ubah Status Transaksi</h1>
                <ul>
                    <li><a href="">Selada</a></li>
                   
                </ul>
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
                            <form action="{{route('transactionBJB_update', $transaction->id)}}" method="POST">
                                <div class="form-group row">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                    <label class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{!empty($transaction->merchant->user) ? $transaction->merchant->user->username : ''}}" name="username" placeholder="Username" disabled>
                                        <div class="invalid-tooltip">
                                            TID tidak boleh kosong.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Agen</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{!empty($transaction->merchant) ? $transaction->merchant->name : ''}}" name="name" placeholder="Agen" disabled>
                                        <div class="invalid-tooltip">
                                            Nama Agen tidak boleh kosong.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Transaction Code</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$transaction->code}}" name="code" placeholder="Transaction Code" disabled>
                                        <div class="invalid-tooltip">
                                            Transaction Code tidak boleh kosong.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Product</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$transaction->service->product->name}}" name="name" placeholder="Product" disabled>
                                        <div class="invalid-tooltip">
                                            Product tidak boleh kosong.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Price</label>
                                    <div class="col-sm-10">
                                        <input type="number" min="1" step="any" class="form-control" value="{{$transaction->price}}" name="price" placeholder="Price" disabled>
                                        <div class="invalid-tooltip">
                                            Price tidak boleh kosong.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="status_text" id="status_text" placeholder="Select Status">
                                                        <option disabled>Select Status</option>
                                                        <option @php if ($transaction->status == '0') echo 'selected' @endphp value="0">Pending</option>
                                                        <option @php if ($transaction->status == '2') echo 'selected' @endphp value="2">Failed</option>
                                                        <option @php if ($transaction->status == '1') echo 'selected' @endphp value="1">Success</option>
                                                    </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Status Suspect</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="status_suspect" id="status_suspect" placeholder="Select Status">
                                                        <option disabled>Select Status</option>
                                                        <option @php if ($transaction->is_suspect == 1) echo 'selected' @endphp value="1">True</option>
                                                        <option @php if ($transaction->is_suspect !== 1) echo 'selected' @endphp value="0">False</option>
                                                    </select>
                                    </div>
                                </div>
                            
                                <div class="form-group row">
                                    <div class="col-sm-12 text-right">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
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

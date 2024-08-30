@extends('layouts.master')
@section('main-content')
    <div class="breadcrumb">
                <h1>Tambah Merchant</h1>
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
                            <form action="{{route('merchant_store')}}" method="POST">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Group</label>
                                    <div class="col-sm-10">
                                        <select name="group_id" class="form-control">
                                            @foreach($groups as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                    <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{Request::old('fullname')}}" name="fullname" placeholder="Nama Lengkap" required>
                                        <div class="invalid-tooltip">
                                            Nama Lengkap tidak boleh kosong.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nama Pengguna</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{Request::old('username')}}" name="username" placeholder="Nama Pengguna" required>
                                        <div class="invalid-tooltip">
                                            Nama Pengguna tidak boleh kosong.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" value="{{Request::old('email')}}" name="email" placeholder="Email" required>
                                        <div class="invalid-tooltip">
                                            Email tidak boleh kosong.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Kata Sandi</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password" placeholder="Kata Sandi" required>
                                        <div class="invalid-tooltip">
                                            Kata sandi tidak boleh kosong.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nama Toko</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{Request::old('store_name')}}" name="store_name" placeholder="Nama Toko" required>
                                        <div class="invalid-tooltip">
                                            Nama Toko tidak boleh kosong.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nama Merek</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{Request::old('brand_name')}}" name="brand_name" placeholder="Nama Merek" required>
                                        <div class="invalid-tooltip">
                                            Nama Merek tidak boleh kosong.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Alamat Toko</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{Request::old('store_address')}}" name="store_address" placeholder="Alamat Toko" required>
                                        <div class="invalid-tooltip">
                                            Alamat Toko tidak boleh kosong.
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">No Telp</label>
                                    <div class="col-sm-10">
                                        <input type="text" pattern="[0-9]{4,15}" class="form-control" value="{{Request::old('store_phone')}}" name="store_phone" placeholder="Contoh : 081123456789" required>
                                        <div class="invalid-tooltip">
                                            No Telp tidak boleh kosong.
                                        </div>
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

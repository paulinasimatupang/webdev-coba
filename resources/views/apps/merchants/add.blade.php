@extends('layouts.master')

@section('main-content')
    <div class="breadcrumb">
        <h1>Add Agen</h1>
        <!-- <ul>
            <li><a href="#">Selada</a></li>
        </ul> -->
    </div>
    <div class="separator-breadcrumb border-top"></div>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">
                    <form action="{{ route('agen_store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Kode Agen</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="mid" name="mid" value="{{ old('mid', session('mid', null)) }}" placeholder="Kode Agen" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fullname" name="fullname" value="{{ old('fullname', session('fullname', null)) }}" placeholder="Nama Lengkap" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ old('username') }}" name="username" placeholder="Username" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" value="{{ old('email', session('email', null)) }}" name="email" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nomor Handphone</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ old('phone', session('phone', null)) }}" name="phone" placeholder="Nomor Handphone" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ old('address', session('address', null)) }}" name="address" placeholder="Alamat" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Kota</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{old('city', session('city', null))}}" name="city" placeholder="Kota" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nomor Rekening</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="no" name="no" value="{{ old('no', session('no', null)) }}" placeholder="Nomor Rekening" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nomor CIF</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ old('no_cif', session('no_cif', null)) }}" name="no_cif" placeholder="Nomor CIF" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="file_ktp">KTP</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="file_ktp" id="file_ktp" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="file_kk">Kartu Keluarga</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="file_kk" id="file_kk" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="file_npwp">NPWP</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="file_npwp" id="file_npwp" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 text-right">
                                <a href="{{ route('agen') }}">
                                    <button type="button" class="btn btn-primary">Back</button>
                                </a>
                                <button type="submit" class="btn btn-primary">Save</button>
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
    <script src="{{ asset('assets/js/form.validation.script.js') }}"></script>
@endsection

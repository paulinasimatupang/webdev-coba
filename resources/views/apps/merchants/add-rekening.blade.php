@extends('layouts.master')
@section('main-content')
    <div class="breadcrumb">
                <h1>Create Rekening</h1>
                <ul>
                    <li><a href="">Selada</a></li>
                   
                </ul>
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
                            <form action="{{route('merchant_store_rekening')}}" method="POST">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Kode Cabang</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="branchid">
                                            <option value="">-- Pilih Kode Cabang --</option>
                                            <option value="000" {{ Request::old('branchid', session('branchid', null)) == '000' ? 'selected' : '' }}>KANTOR PUSAT</option>
                                            <option value="001" {{ Request::old('branchid', session('branchid', null)) == '001' ? 'selected' : '' }}>KC ISLAMIC CENTER</option>
                                            <option value="002" {{ Request::old('branchid', session('branchid', null)) == '002' ? 'selected' : '' }}>KC SELONG PAHLAWAN</option>
                                            <option value="003" {{ Request::old('branchid', session('branchid', null)) == '003' ? 'selected' : '' }}>KC PRAYA SUDIRMAN</option>
                                            <option value="004" {{ Request::old('branchid', session('branchid', null)) == '004' ? 'selected' : '' }}>KC SUMBAWA DR. WAHIDIN</option>
                                            <option value="005" {{ Request::old('branchid', session('branchid', null)) == '005' ? 'selected' : '' }}>KC BIMA SOEKARNO HATTA</option>
                                            <option value="006" {{ Request::old('branchid', session('branchid', null)) == '006' ? 'selected' : '' }}>KCP MATARAM CAKRANEGARA</option>
                                            <option value="007" {{ Request::old('branchid', session('branchid', null)) == '007' ? 'selected' : '' }}>KC DOMPU NUSANTARA</option>
                                            <option value="008" {{ Request::old('branchid', session('branchid', null)) == '008' ? 'selected' : '' }}>KC TANJUNG</option>
                                            <option value="009" {{ Request::old('branchid', session('branchid', null)) == '009' ? 'selected' : '' }}>KCP ALAS</option>
                                            <option value="010" {{ Request::old('branchid', session('branchid', null)) == '010' ? 'selected' : '' }}>KCP NARMADA</option>
                                            <option value="011" {{ Request::old('branchid', session('branchid', null)) == '011' ? 'selected' : '' }}>KCP AIKMEL</option>
                                            <option value="012" {{ Request::old('branchid', session('branchid', null)) == '012' ? 'selected' : '' }}>KCP SWETA</option>
                                            <option value="013" {{ Request::old('branchid', session('branchid', null)) == '013' ? 'selected' : '' }}>KC TENTE</option>
                                            <option value="014" {{ Request::old('branchid', session('branchid', null)) == '014' ? 'selected' : '' }}>KCP BOLO</option>
                                            <option value="015" {{ Request::old('branchid', session('branchid', null)) == '015' ? 'selected' : '' }}>KCP KOPANG</option>
                                            <option value="016" {{ Request::old('branchid', session('branchid', null)) == '016' ? 'selected' : '' }}>KCP KERUAK</option>
                                            <option value="017" {{ Request::old('branchid', session('branchid', null)) == '017' ? 'selected' : '' }}>KC TALIWANG SUDIRMAN</option>
                                            <option value="018" {{ Request::old('branchid', session('branchid', null)) == '018' ? 'selected' : '' }}>KCP MANGGELEWA</option>
                                            <option value="019" {{ Request::old('branchid', session('branchid', null)) == '019' ? 'selected' : '' }}>KCP SAPE</option>
                                            <option value="020" {{ Request::old('branchid', session('branchid', null)) == '020' ? 'selected' : '' }}>KCP PLAMPANG</option>
                                            <option value="021" {{ Request::old('branchid', session('branchid', null)) == '021' ? 'selected' : '' }}>KC SURABAYA DARMO</option>
                                            <option value="022" {{ Request::old('branchid', session('branchid', null)) == '022' ? 'selected' : '' }}>KC GERUNG</option>
                                            <option value="023" {{ Request::old('branchid', session('branchid', null)) == '023' ? 'selected' : '' }}>KCP LUNYUK</option>
                                            <option value="024" {{ Request::old('branchid', session('branchid', null)) == '024' ? 'selected' : '' }}>KCP LOPOK</option>
                                            <option value="025" {{ Request::old('branchid', session('branchid', null)) == '025' ? 'selected' : '' }}>KCP PEKAT</option>
                                            <option value="026" {{ Request::old('branchid', session('branchid', null)) == '026' ? 'selected' : '' }}>KCP PRINGGABAYA</option>
                                            <option value="027" {{ Request::old('branchid', session('branchid', null)) == '027' ? 'selected' : '' }}>KCP PAGESANGAN</option>
                                            <option value="028" {{ Request::old('branchid', session('branchid', null)) == '028' ? 'selected' : '' }}>KCP Ampenan</option>
                                            <option value="029" {{ Request::old('branchid', session('branchid', null)) == '029' ? 'selected' : '' }}>KCP Gunungsari</option>
                                            <option value="030" {{ Request::old('branchid', session('branchid', null)) == '030' ? 'selected' : '' }}>KCP Mujur</option>
                                            <option value="501" {{ Request::old('branchid', session('branchid', null)) == '501' ? 'selected' : '' }}>KC MASBAGIK</option>
                                            <option value="502" {{ Request::old('branchid', session('branchid', null)) == '502' ? 'selected' : '' }}>KCP PASAR TALIWANG</option>
                                            <option value="503" {{ Request::old('branchid', session('branchid', null)) == '503' ? 'selected' : '' }}>KCP KEMPO</option>
                                            <option value="504" {{ Request::old('branchid', session('branchid', null)) == '504' ? 'selected' : '' }}>KC SRIWIJAYA MATARAM</option>
                                            <option value="505" {{ Request::old('branchid', session('branchid', null)) == '505' ? 'selected' : '' }}>KCP PEMENANG</option>
                                            <option value="506" {{ Request::old('branchid', session('branchid', null)) == '506' ? 'selected' : '' }}>KCP MALUK</option>
                                            <option value="507" {{ Request::old('branchid', session('branchid', null)) == '507' ? 'selected' : '' }}>KCP KEDIRI</option>
                                            <option value="508" {{ Request::old('branchid', session('branchid', null)) == '508' ? 'selected' : '' }}>KCP WAWO</option>
                                            <option value="509" {{ Request::old('branchid', session('branchid', null)) == '509' ? 'selected' : '' }}>KCP UTAN</option>
                                            <option value="510" {{ Request::old('branchid', session('branchid', null)) == '510' ? 'selected' : '' }}>KCP PUJUT</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                    <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', session('nama_lengkap', null)) }}" placeholder="Nama Lengkap" required>
                                    </div>
                                </div>
                                <!-- <div class="form-group row">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                    <label class="col-sm-2 col-form-label">NIK</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="nik" name="nik" value="{{ old('nik', session('nik')) }}" placeholder="Nomor Identitas" >
                                    </div>
                                </div> -->
                                <div class="form-group row">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                    <label class="col-sm-2 col-form-label">Nomor CIF</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="no_cif" name="no_cif" value="{{ old('no_cif', session('no_cif', null)) }}" placeholder="Nomor CIF" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Produk</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="kode_produk">
                                            <option value="36" {{ Request::old('kode_produk') == '36' ? 'selected' : '' }}>BSA Laku Pandai</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nomor Registrasi</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{old('no_registrasi', session('no_registrasi', null))}}" name="no_registrasi" placeholder="Nomor Registrasi" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 text-right">
                                        <a href="{{route('merchant')}}">
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

    <script src="{{asset('assets/js/form.validation.script.js')}}"></script>

@endsection

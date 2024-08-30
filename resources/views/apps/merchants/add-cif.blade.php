@extends('layouts.master')
@section('main-content')
    <div class="breadcrumb">
                <h1>Create CIF</h1>
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
                            <form action="{{route('merchant_store_cif')}}" method="POST">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Kode Cabang</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="branchid">
                                            <option value="">-- Pilih Kode Cabang --</option>
                                            <option value="000" {{ Request::old('branchid') == '000' ? 'selected' : '' }}>KANTOR PUSAT</option>
                                            <option value="001" {{ Request::old('branchid') == '001' ? 'selected' : '' }}>KC ISLAMIC CENTER</option>
                                            <option value="002" {{ Request::old('branchid') == '002' ? 'selected' : '' }}>KC SELONG PAHLAWAN</option>
                                            <option value="003" {{ Request::old('branchid') == '003' ? 'selected' : '' }}>KC PRAYA SUDIRMAN</option>
                                            <option value="004" {{ Request::old('branchid') == '004' ? 'selected' : '' }}>KC SUMBAWA DR. WAHIDIN</option>
                                            <option value="005" {{ Request::old('branchid') == '005' ? 'selected' : '' }}>KC BIMA SOEKARNO HATTA</option>
                                            <option value="006" {{ Request::old('branchid') == '006' ? 'selected' : '' }}>KCP MATARAM CAKRANEGARA</option>
                                            <option value="007" {{ Request::old('branchid') == '007' ? 'selected' : '' }}>KC DOMPU NUSANTARA</option>
                                            <option value="008" {{ Request::old('branchid') == '008' ? 'selected' : '' }}>KC TANJUNG</option>
                                            <option value="009" {{ Request::old('branchid') == '009' ? 'selected' : '' }}>KCP ALAS</option>
                                            <option value="010" {{ Request::old('branchid') == '010' ? 'selected' : '' }}>KCP NARMADA</option>
                                            <option value="011" {{ Request::old('branchid') == '011' ? 'selected' : '' }}>KCP AIKMEL</option>
                                            <option value="012" {{ Request::old('branchid') == '012' ? 'selected' : '' }}>KCP SWETA</option>
                                            <option value="013" {{ Request::old('branchid') == '013' ? 'selected' : '' }}>KC TENTE</option>
                                            <option value="014" {{ Request::old('branchid') == '014' ? 'selected' : '' }}>KCP BOLO</option>
                                            <option value="015" {{ Request::old('branchid') == '015' ? 'selected' : '' }}>KCP KOPANG</option>
                                            <option value="016" {{ Request::old('branchid') == '016' ? 'selected' : '' }}>KCP KERUAK</option>
                                            <option value="017" {{ Request::old('branchid') == '017' ? 'selected' : '' }}>KC TALIWANG SUDIRMAN</option>
                                            <option value="018" {{ Request::old('branchid') == '018' ? 'selected' : '' }}>KCP MANGGELEWA</option>
                                            <option value="019" {{ Request::old('branchid') == '019' ? 'selected' : '' }}>KCP SAPE</option>
                                            <option value="020" {{ Request::old('branchid') == '020' ? 'selected' : '' }}>KCP PLAMPANG</option>
                                            <option value="021" {{ Request::old('branchid') == '021' ? 'selected' : '' }}>KC SURABAYA DARMO</option>
                                            <option value="022" {{ Request::old('branchid') == '022' ? 'selected' : '' }}>KC GERUNG</option>
                                            <option value="023" {{ Request::old('branchid') == '023' ? 'selected' : '' }}>KCP LUNYUK</option>
                                            <option value="024" {{ Request::old('branchid') == '024' ? 'selected' : '' }}>KCP LOPOK</option>
                                            <option value="025" {{ Request::old('branchid') == '025' ? 'selected' : '' }}>KCP PEKAT</option>
                                            <option value="026" {{ Request::old('branchid') == '026' ? 'selected' : '' }}>KCP PRINGGABAYA</option>
                                            <option value="027" {{ Request::old('branchid') == '027' ? 'selected' : '' }}>KCP PAGESANGAN</option>
                                            <option value="028" {{ Request::old('branchid') == '028' ? 'selected' : '' }}>KCP Ampenan</option>
                                            <option value="029" {{ Request::old('branchid') == '029' ? 'selected' : '' }}>KCP Gunungsari</option>
                                            <option value="030" {{ Request::old('branchid') == '030' ? 'selected' : '' }}>KCP Mujur</option>
                                            <option value="501" {{ Request::old('branchid') == '501' ? 'selected' : '' }}>KC MASBAGIK</option>
                                            <option value="502" {{ Request::old('branchid') == '502' ? 'selected' : '' }}>KCP PASAR TALIWANG</option>
                                            <option value="503" {{ Request::old('branchid') == '503' ? 'selected' : '' }}>KCP KEMPO</option>
                                            <option value="504" {{ Request::old('branchid') == '504' ? 'selected' : '' }}>KC SRIWIJAYA MATARAM</option>
                                            <option value="505" {{ Request::old('branchid') == '505' ? 'selected' : '' }}>KCP PEMENANG</option>
                                            <option value="506" {{ Request::old('branchid') == '506' ? 'selected' : '' }}>KCP MALUK</option>
                                            <option value="507" {{ Request::old('branchid') == '507' ? 'selected' : '' }}>KCP KEDIRI</option>
                                            <option value="508" {{ Request::old('branchid') == '508' ? 'selected' : '' }}>KCP WAWO</option>
                                            <option value="509" {{ Request::old('branchid') == '509' ? 'selected' : '' }}>KCP UTAN</option>
                                            <option value="510" {{ Request::old('branchid') == '510' ? 'selected' : '' }}>KCP PUJUT</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                    <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{Request::old('nama_lengkap')}}" name="nama_lengkap" placeholder="Nama Lengkap" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                    <label class="col-sm-2 col-form-label">Nama Alias</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{Request::old('nama_alias')}}" name="nama_alias" placeholder="Nama Alias" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Ibu Kandung</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{Request::old('ibu_kandung')}}" name="ibu_kandung" placeholder="Ibu Kandung" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Tempat Lahir</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{Request::old('tempat_lahir')}}" name="tempat_lahir" placeholder="Tempat Lahir" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" 
                                            value="{{ old('tgl_lahir') ? date('Y-m-d', strtotime(old('tgl_lahir'))) : '' }}" 
                                            name="tgl_lahir" placeholder="Tanggal Lahir" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="jenis_kelamin">
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="1" {{ Request::old('jenis_kelamin') == '1' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="2" {{ Request::old('jenis_kelamin') == '2' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Agama</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="agama">
                                            <option value="">-- Pilih Agama --</option>
                                            <option value="1" {{ Request::old('agama') == '1' ? 'selected' : '' }}>Islam</option>
                                            <option value="2" {{ Request::old('agama') == '2' ? 'selected' : '' }}>Kristen Protestan</option>
                                            <option value="3" {{ Request::old('agama') == '3' ? 'selected' : '' }}>Katholik</option>
                                            <option value="4" {{ Request::old('agama') == '4' ? 'selected' : '' }}>Budha</option>
                                            <option value="5" {{ Request::old('agama') == '5' ? 'selected' : '' }}>Hindu</option>
                                            <option value="6" {{ Request::old('agama') == '6' ? 'selected' : '' }}>Konghucu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Status Nikah</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="status_nikah">
                                            <option value="">-- Pilih Status Nikah --</option>
                                            <option value="1" {{ Request::old('status_nikah') == '1' ? 'selected' : '' }}>Kawin</option>
                                            <option value="2" {{ Request::old('status_nikah') == '2' ? 'selected' : '' }}>Belum Kawin</option>
                                            <option value="3" {{ Request::old('status_nikah') == '3' ? 'selected' : '' }}>Janda/Duda</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Alamat</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{Request::old('alamat')}}" name="alamat" placeholder="Alamat" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">RT</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" value="{{Request::old('rt')}}" name="rt" placeholder="RT" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">RW</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" value="{{Request::old('rw')}}" name="rw" placeholder="RW" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Kecamatan</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{Request::old('kecamatan')}}" name="kecamatan" placeholder="Kecamatan" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Kelurahan</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{Request::old('kelurahan')}}" name="kelurahan" placeholder="Kelurahan" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Kabupaten/Kota</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="kab_kota">
                                        <option value="">-- Pilih Kabupaten / Kota --</option>
                                        <option value="5201" {{ Request::old('kab_kota') == '5201' ? 'selected' : '' }}>Kabupaten Lombok Barat</option>
                                        <option value="5202" {{ Request::old('kab_kota') == '5202' ? 'selected' : '' }}>Kabupaten Lombok Tengah</option>
                                        <option value="5203" {{ Request::old('kab_kota') == '5203' ? 'selected' : '' }}>Kabupaten Lombok Timur</option>
                                        <option value="5204" {{ Request::old('kab_kota') == '5204' ? 'selected' : '' }}>Kabupaten Sumbawa</option>
                                        <option value="5205" {{ Request::old('kab_kota') == '5205' ? 'selected' : '' }}>Kabupaten Dompu</option>
                                        <option value="5206" {{ Request::old('kab_kota') == '5206' ? 'selected' : '' }}>Kabupaten Bima</option>
                                        <option value="5207" {{ Request::old('kab_kota') == '5207' ? 'selected' : '' }}>Kabupaten Sumbawa Barat</option>
                                        <option value="5208" {{ Request::old('kab_kota') == '5208' ? 'selected' : '' }}>Kabupaten Mataram</option>
                                        <option value="5271" {{ Request::old('kab_kota') == '5271' ? 'selected' : '' }}>Kota Mataram</option>
                                        <option value="5272" {{ Request::old('kab_kota') == '5272' ? 'selected' : '' }}>Kota Bima</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Provinsi</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="provinsi">
                                            <option value="52" {{ Request::old('provinsi') == '52' ? 'selected' : '' }}>Nusa Tenggara Barat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Kode POS</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" value="{{Request::old('kode_pos')}}" name="kode_pos" placeholder="Kode Pos" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Kewarganegaraan</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="kewarganegaarn">
                                            <option value="">-- Pilih Kewarganegaraan --</option>
                                            <option value="1" {{ Request::old('kewarganegaarn') == '1' ? 'selected' : '' }}>WNI</option>
                                            <option value="2" {{ Request::old('kewarganegaarn') == '2' ? 'selected' : '' }}>WNA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Status Penduduk</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="status_penduduk">
                                        <option value="">-- Pilih Status Penduduk --</option>
                                            <option value="0" {{ Request::old('status_penduduk') == '0' ? 'selected' : '' }}>Tidak Menetap</option>
                                            <option value="1" {{ Request::old('status_penduduk') == '1' ? 'selected' : '' }}>Menetap</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nomor Telepon</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" value="{{Request::old('no_telp')}}" name="no_telp" placeholder="Nomor Telepon" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nomor HP</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" value="{{Request::old('no_hp')}}" name="no_hp" placeholder="Nomor HP" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">NPWP</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{Request::old('npwp')}}" name="npwp" placeholder="NPWP" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Jenis Identitas</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="jenis_identitas">
                                            <option value="">-- Pilih Jenis Identitas --</option>
                                            <option value="1" {{ Request::old('jenis_identitas') == '1' ? 'selected' : '' }}>KTP</option>
                                            <option value="2" {{ Request::old('jenis_identitas') == '2' ? 'selected' : '' }}>Passport</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">No Identitas</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="no_identitas" name="no_identitas" value="{{ old('no_identitas', session('no_identitas')) }}" placeholder="Nomor Identitas" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Golongan Darah</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="golongan_darah">
                                            <option value="">-- Pilih Golongan Darah --</option>
                                            <option value="0" {{ Request::old('golongan_darah') == '0' ? 'selected' : '' }}>A</option>
                                            <option value="1" {{ Request::old('golongan_darah') == '1' ? 'selected' : '' }}>AB</option>
                                            <option value="2" {{ Request::old('golongan_darah') == '2' ? 'selected' : '' }}>B</option>
                                            <option value="3" {{ Request::old('golongan_darah') == '3' ? 'selected' : '' }}>O</option>
                                            <option value="4" {{ Request::old('golongan_darah') == '4' ? 'selected' : '' }}>-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Expired Identitas</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" 
                                            value="{{ old('expired_identitas') ? date('Y-m-d', strtotime(old('expired_identitas'))) : '' }}" 
                                            name="expired_identitas" placeholder="Expired Identitas" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Pendidikan Terakhir</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="pendidikan_terakhir">
                                            <option value="">-- Pilih Pendidikan Terakhir --</option>
                                            <option value="1" {{ Request::old('pendidikan_terakhir') == '1' ? 'selected' : '' }}>SD</option>
                                            <option value="2" {{ Request::old('pendidikan_terakhir') == '2' ? 'selected' : '' }}>SMP</option>
                                            <option value="3" {{ Request::old('pendidikan_terakhir') == '3' ? 'selected' : '' }}>SMA</option>
                                            <option value="4" {{ Request::old('pendidikan_terakhir') == '4' ? 'selected' : '' }}>AKADEMI</option>
                                            <option value="5" {{ Request::old('pendidikan_terakhir') == '5' ? 'selected' : '' }}>S1</option>
                                            <option value="6" {{ Request::old('pendidikan_terakhir') == '6' ? 'selected' : '' }}>S2</option>
                                            <option value="7" {{ Request::old('pendidikan_terakhir') == '7' ? 'selected' : '' }}>S3</option>
                                            <option value="8" {{ Request::old('pendidikan_terakhir') == '8' ? 'selected' : '' }}>OTHERS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" value="{{Request::old('email')}}" name="email" placeholder="Email" required>
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

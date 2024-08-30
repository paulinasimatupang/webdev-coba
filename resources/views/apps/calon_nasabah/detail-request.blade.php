@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>Detail Calon Nasabah</h1>
</div>
<div class="separator-breadcrumb border-top"></div>

@if(Session::has('error'))
@foreach (Session::get('error') as $key => $item)
<div class="alert alert-danger" role="alert">
    <strong class="text-capitalize">Error: </strong> {{ $item[0] }}
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
                @php
                $fields = [
                'NIK' => $nasabah->no_identitas,
                'Nama Lengkap' => $nasabah->nama_lengkap,
                'Nama Alias' => $nasabah->nama_alias,
                'Ibu Kandung' => $nasabah->ibu_kandung,
                'Tempat Lahir' => $nasabah->tempat_lahir,
                'Tanggal Lahir' => \Carbon\Carbon::parse($nasabah->tgl_lahir)->format('d M Y'),
                'Jenis Kelamin' => $jenis_kelamin->firstWhere('seq', $nasabah->jenis_kelamin)->opt_label ?? '',
                'Agama' => $agama->firstWhere('seq', $nasabah->agama)->opt_label ?? '',
                'Alamat' => $nasabah->alamat,
                'RT' => $nasabah->rt,
                'RW' => $nasabah->rw,
                'Kecamatan' => $nasabah->kecamatan,
                'Kelurahan' => $nasabah->kelurahan,
                'Kabupaten/Kota' => $kab_kota->firstWhere('seq', $nasabah->kab_kota)->opt_label ?? $nasabah->kab_kota,
                'Provinsi' => $provinsi->firstWhere('seq', $nasabah->provinsi)->opt_label ?? '',
                'Kode POS' => $nasabah->kode_pos,
                'Nomor Telepon' => $nasabah->no_telp,
                'Nomor HP' => $nasabah->no_hp,
                'Status Penduduk' => $status_penduduk->firstWhere('seq', $nasabah->status_penduduk)->opt_label ?? '',
                'Kewarganegaraan' => $kewarganegaraan->firstWhere('seq', $nasabah->kewarganegaraan)->opt_label ?? '',
                'Nomor NPWP' => $nasabah->npwp,
                'Jenis Identitas' => $jenis_identitas->firstWhere('seq', $nasabah->jenis_identitas)->opt_label ?? '',
                'Golongan Darah' => $golongan_darah->firstWhere('seq', $nasabah->golongan_darah)->opt_label ?? '',
                'Expired Identitas' => \Carbon\Carbon::parse($nasabah->expired_identitas)->format('d M Y'),
                'Pendidikan Terakhir' => $pendidikan_terakhir->firstWhere('seq', $nasabah->pendidikan_terakhir)->opt_label ?? '',
                'Email' => $nasabah->email,
                ];
                @endphp

                @foreach ($fields as $label => $value)
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ $label }}</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ $value }}</p>
                    </div>
                </div>
                @endforeach

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Foto Diri</label>
                    <div class="col-sm-10">
                        @if ($nasabah->foto_diri)
                            <img src="{{ $baseUrl . $nasabah->foto_diri }}" alt="Foto Tanda Tangan" class="img-thumbnail" style="max-width: 200px;">
                        @else
                        <p class="form-control-static">Belum diunggah</p>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Foto KTP</label>
                    <div class="col-sm-10">
                        @if ($nasabah->foto_ktp)
                        <img src="{{ $baseUrl . $nasabah->foto_ktp }}" alt="Foto Tanda Tangan" class="img-thumbnail" style="max-width: 200px;">
                        @else
                        <p class="form-control-static">Belum diunggah</p>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Foto Tanda Tangan</label>
                    <div class="col-sm-10">
                        @if ($nasabah->foto_tanda_tangan)
                        <img src="{{ $baseUrl . $nasabah->foto_tanda_tangan }}" alt="Foto Tanda Tangan" class="img-thumbnail" style="max-width: 200px;">
                        @else
                        <p class="form-control-static">Belum diunggah</p>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12 text-right">
                        <a href="{{ route('nasabah_request') }}">
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
@endsection

@section('bottom-js')
<script src="{{ asset('assets/js/form.validation.script.js') }}"></script>
@endsection
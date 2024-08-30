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
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">NIK</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{ $nasabah->no_identitas }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{ $nasabah->nama_lengkap }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nama Alias</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{ $nasabah->nama_alias }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Ibu Kandung</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{ $nasabah->ibu_kandung }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tempat Lahir</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{ $nasabah->tempat_lahir }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{ $nasabah->tgl_lahir }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">
                                @foreach($jenis_kelamin as $option)
                                    @if($nasabah->jenis_kelamin == $option->seq)
                                        {{ $option->opt_label }}
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Agama</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">
                                @foreach($agama as $option)
                                    @if($nasabah->agama == $option->seq)
                                        {{ $option->opt_label }}
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{ $nasabah->alamat }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">RT</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{ $nasabah->rt }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">RW</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{ $nasabah->rw }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Kecamatan</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{ $nasabah->kecamatan }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Kelurahan</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{ $nasabah->kelurahan }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Kabupaten/Kota</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">
                                @php
                                    $labelFound = false;
                                @endphp
                                
                                @foreach($kab_kota as $option)
                                    @if($nasabah->kab_kota == $option->seq)
                                        {{ $option->opt_label }}
                                        @php
                                            $labelFound = true;
                                        @endphp
                                    @endif
                                @endforeach

                                @if(!$labelFound)
                                    {{ $nasabah->kab_kota }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Provinsi</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">
                                @foreach($provinsi as $option)
                                    @if($nasabah->provinsi == $option->seq)
                                        {{ $option->opt_label }}
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Kode POS</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{ $nasabah->kode_pos }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nomor Telepon</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{ $nasabah->no_telp }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nomor HP</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{ $nasabah->no_hp }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Status Penduduk</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">
                                @foreach($status_penduduk as $option)
                                    @if($nasabah->status_penduduk == $option->seq)
                                        {{ $option->opt_label }}
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Kewarganegaraan</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">
                                @foreach($kewarganegaraan as $option)
                                    @if($nasabah->kewarganegaraan == $option->seq)
                                        {{ $option->opt_label }}
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nomor NPWP</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{ $nasabah->npwp }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Jenis Identitas</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">
                                @foreach($jenis_identitas as $option)
                                    @if($nasabah->jenis_identitas == $option->seq)
                                        {{ $option->opt_label }}
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Golongan Darah</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">
                                @foreach($golongan_darah as $option)
                                    @if($nasabah->golongan_darah == $option->seq)
                                        {{ $option->opt_label }}
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Expired Identitas</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{ $nasabah->expired_identitas }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Pendidikan Terakhir</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">
                                @foreach($pendidikan_terakhir as $option)
                                    @if($nasabah->pendidikan_terakhir == $option->seq)
                                        {{ $option->opt_label }}
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{{ $nasabah->email }}</p>
                        </div>
                    </div>

                    <div class="col-sm-12 d-flex justify-content-end">
                        <a href="{{ route('nasabah_request') }}" class="btn btn-primary mr-2">Back</a>
                        <form id="actionForm" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="nasabah_id" value="{{ $nasabah->id }}">
                            <input type="hidden" name="action" id="formAction">

                            <button type="button" id="approve" class="btn btn-success">
                                Approve
                            </button>

                            <button type="button" id="reject" class="btn btn-danger ml-2">
                                Reject
                            </button>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-js')
<script>
document.getElementById('approve').addEventListener('click', function() {
    if (confirm('Are you sure you want to activate this merchant?')) {
        document.getElementById('formAction').value = 'activate';
        document.getElementById('actionForm').action = "{{ route('nasabah_approve', ['id' => $nasabah->id]) }}";
        document.getElementById('actionForm').submit();
    }
});

document.getElementById('reject').addEventListener('click', function() {
    if (confirm('Are you sure you want to reject this merchant?')) {
        document.getElementById('formAction').value = 'reject';
        document.getElementById('actionForm').action = "{{ route('nasabah_reject', ['id' => $nasabah->id]) }}";
        document.getElementById('actionForm').submit();
    }
});
</script>
@endsection

@section('bottom-js')
<script src="{{ asset('assets/js/form.validation.script.js') }}"></script>
@endsection

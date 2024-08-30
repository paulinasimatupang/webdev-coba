@extends('layouts.master')

@section('main-content')
<div class="breadcrumb">
    <h1>Detail Merchant</h1>
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
                <!-- Konten detail merchant -->
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Kode Agen</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ $merchant->mid }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ $merchant->name }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ $merchant->email }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nomor Handphone</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ $merchant->phone }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ $merchant->address }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Kota</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ $merchant->city }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nomor Rekening</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ $merchant->no }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nomor CIF</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ $merchant->no_cif }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">KTP</label>
                    <div class="col-sm-10">
                        @if(isset($merchant) && $merchant->file_ktp)
                            <div class="mb-2">
                                <a href="{{ asset('uploads/' . $merchant->file_ktp) }}" target="_blank">Lihat File KTP</a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Kartu Keluarga</label>
                    <div class="col-sm-10">
                        @if(isset($merchant) && $merchant->file_kk)
                            <div class="mb-2">
                                <a href="{{ asset('uploads/' . $merchant->file_kk) }}" target="_blank">Lihat File Kartu Keluarga</a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">NPWP</label>
                    <div class="col-sm-10">
                        @if(isset($merchant) && $merchant->file_npwp)
                            <div class="mb-2">
                                <a href="{{ asset('uploads/' . $merchant->file_npwp) }}" target="_blank">Lihat File NPWP</a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12 text-right">
                        <a href="{{ route('agen_request') }}" class="btn btn-primary">Back</a>
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
</div>

@endsection

@section('page-js')
<script>
document.getElementById('approve').addEventListener('click', function() {
    if (confirm('Are you sure you want to activate this merchant?')) {
        document.getElementById('formAction').value = 'activate';
        document.getElementById('actionForm').action = "{{ route('agen_activate', ['id' => $merchant->id]) }}";
        document.getElementById('actionForm').submit();
    }
});

document.getElementById('reject').addEventListener('click', function() {
    if (confirm('Are you sure you want to reject this merchant?')) {
        document.getElementById('formAction').value = 'reject';
        document.getElementById('actionForm').action = "{{ route('agen_reject', ['id' => $merchant->id]) }}";
        document.getElementById('actionForm').submit();
    }
});
</script>
@endsection

@section('bottom-js')
<script src="{{ asset('assets/js/form.validation.script.js') }}"></script>
@endsection

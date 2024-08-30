@extends('layouts.master')
@section('main-content')
<div class="breadcrumb">
    <h1>Edit Merchant</h1>
    <!-- <ul>
        <li><a href="">Selada</a></li>
    </ul> -->
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-body">
                <form action="{{ route('agen_update', [$merchant->id]) }}" method="POST">
                    @csrf
                    @method('POST')

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Merchant ID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $merchant->mid }}" name="mid" placeholder="Merchant ID" required>
                        </div>
                    </div>
                    <!-- Other form fields here... -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="{{ $merchant->name }}" placeholder="Nama Lengkap" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" value="{{ $merchant->email }}" name="email" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nomor Handphone</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $merchant->phone }}" name="phone" placeholder="Phone" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $merchant->address }}" name="address" placeholder="Address" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Kota</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $merchant->city }}" name="city" placeholder="City" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nomor Rekening</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="no" name="no" value="{{ $merchant->no }}" placeholder="Nomor Rekening" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nomor Registrasi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="no_registrasi" name="no_registrasi" value="{{ $merchant->no_registrasi }}" placeholder="Nomor Registrasi" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nomor CIF</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{ $merchant->no_cif }}" name="no_cif" placeholder="Nomor CIF" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Kode Cabang</label>
                        <div class="col-sm-10">
                            <select id="branchid" class="form-control" name="branchid">
                                <option value="">-- Pilih Kode Cabang --</option>
                                <option value="000" {{ $merchant->branchid ? 'selected' : '' }}>KANTOR PUSAT</option>
                                <option value="001" {{ $merchant->branchid ? 'selected' : '' }}>KC ISLAMIC CENTER</option>
                                <option value="002" {{ $merchant->branchid ? 'selected' : '' }}>KC SELONG PAHLAWAN</option>
                                <option value="003" {{ $merchant->branchid ? 'selected' : '' }}>KC PRAYA SUDIRMAN</option>
                                <option value="004" {{ $merchant->branchid ? 'selected' : '' }}>KC SUMBAWA DR. WAHIDIN</option>
                                <option value="005" {{ $merchant->branchid ? 'selected' : '' }}>KC BIMA SOEKARNO HATTA</option>
                                <option value="006" {{ $merchant->branchid ? 'selected' : '' }}>KCP MATARAM CAKRANEGARA</option>
                                <option value="007" {{ $merchant->branchid ? 'selected' : '' }}>KC DOMPU NUSANTARA</option>
                                <option value="008" {{ $merchant->branchid ? 'selected' : '' }}>KC TANJUNG</option>
                                <option value="009" {{ $merchant->branchid ? 'selected' : '' }}>KCP ALAS</option>
                                <option value="010" {{ $merchant->branchid ? 'selected' : '' }}>KCP NARMADA</option>
                                <option value="011" {{ $merchant->branchid ? 'selected' : '' }}>KCP AIKMEL</option>
                                <option value="012" {{ $merchant->branchid ? 'selected' : '' }}>>KCP SWETA</option>
                                <option value="013" {{ $merchant->branchid ? 'selected' : '' }}>KC TENTE</option>
                                <option value="014" {{ $merchant->branchid ? 'selected' : '' }}>KCP BOLO</option>
                                <option value="015" {{ $merchant->branchid ? 'selected' : '' }}>KCP KOPANG</option>
                                <option value="016" {{ $merchant->branchid ? 'selected' : '' }}>KCP KERUAK</option>
                                <option value="017" {{ $merchant->branchid ? 'selected' : '' }}>KC TALIWANG SUDIRMAN</option>
                                <option value="018" {{ $merchant->branchid ? 'selected' : '' }}>KCP MANGGELEWA</option>
                                <option value="019" {{ $merchant->branchid ? 'selected' : '' }}>KCP SAPE</option>
                                <option value="020" {{ $merchant->branchid ? 'selected' : '' }}>KCP PLAMPANG</option>
                                <option value="021" {{ $merchant->branchid ? 'selected' : '' }}>KC SURABAYA DARMO</option>
                                <option value="022" {{ $merchant->branchid ? 'selected' : '' }}>KC GERUNG</option>
                                <option value="023" {{ $merchant->branchid ? 'selected' : '' }}>KCP LUNYUK</option>
                                <option value="024" {{ $merchant->branchid ? 'selected' : '' }}>KCP LOPOK</option>
                                <option value="025" {{ $merchant->branchid ? 'selected' : '' }}>KCP PEKAT</option>
                                <option value="026" {{ $merchant->branchid ? 'selected' : '' }}>KCP PRINGGABAYA</option>
                                <option value="027" {{ $merchant->branchid ? 'selected' : '' }}>KCP PAGESANGAN</option>
                                <option value="028" {{ $merchant->branchid ? 'selected' : '' }}>KCP Ampenan</option>
                                <option value="029" {{ $merchant->branchid ? 'selected' : '' }}>KCP Gunungsari</option>
                                <option value="030" {{ $merchant->branchid ? 'selected' : '' }}>KCP Mujur</option>
                                <option value="501" {{ $merchant->branchid ? 'selected' : '' }}>KC MASBAGIK</option>
                                <option value="502" {{ $merchant->branchid ? 'selected' : '' }}>KCP PASAR TALIWANG</option>
                                <option value="503" {{ $merchant->branchid ? 'selected' : '' }}>KCP KEMPO</option>
                                <option value="504" {{ $merchant->branchid ? 'selected' : '' }}>KC SRIWIJAYA MATARAM</option>
                                <option value="505" {{ $merchant->branchid ? 'selected' : '' }}>KCP PEMENANG</option>
                                <option value="506" {{ $merchant->branchid ? 'selected' : '' }}>KCP MALUK</option>
                                <option value="507" {{ $merchant->branchid ? 'selected' : '' }}>KCP KEDIRI</option>
                                <option value="508" {{ $merchant->branchid ? 'selected' : '' }}>KCP WAWO</option>
                                <option value="509" {{ $merchant->branchid ? 'selected' : '' }}>KCP UTAN</option>
                                <option value="510" {{ $merchant->branchid ? 'selected' : '' }}>KCP PUJUT</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Produk</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="kode_produk">
                                <option value="36" {{ $merchant->kode_produk == '36' ? 'selected' : '' }}>BSA Laku Pandai</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="file_ktp">KTP</label>
                        <div class="col-sm-10">
                            @if(isset($merchant) && $merchant->file_ktp)
                            <div class="mb-2">
                                <a href="{{ asset('uploads/' . $merchant->file_ktp) }}" target="_blank">Lihat File KTP</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="file_kk">Kartu Keluarga</label>
                        <div class="col-sm-10">
                            @if(isset($merchant) && $merchant->file_kk)
                            <div class="mb-2">
                                <a href="{{ asset('uploads/' . $merchant->file_kk) }}" target="_blank">Lihat File Kartu Keluarga</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="file_npwp">NPWP</label>
                        <div class="col-sm-10">
                            @if(isset($merchant) && $merchant->file_npwp)
                            <div class="mb-2">
                                <a href="{{ asset('uploads/' . $merchant->file_npwp) }}" target="_blank">Lihat File NPWP</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Activate Merchant</label>
                        <div class="col-sm-10">
                            <button type="button" id="activateMerchantBtn" class="btn btn-success" {{ $merchant->status_agen == 1 ? 'disabled' : '' }}>
                                {{ $merchant->status_agen == 1 ? 'Activated' : 'Activate' }}
                            </button>
                            @if ($merchant->status_agen == 1)
                            <label class="col-sm-10 col-form-label">Merchant Aktif</label>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Deactivate Merchant</label>
                        <div class="col-sm-10">
                            <button type="button" id="deactivateMerchantBtn" class="btn btn-primary" {{ $merchant->status_agen == 2 ? 'disabled' : '' }}>
                                {{ $merchant->status_agen == 2 ? 'Deactivated' : 'Deactivate' }}
                            </button>
                            @if ($merchant->status_agen == 2)
                            <label class="col-sm-10 col-form-label">Merchant Tidak aktif</label>
                            @endif
                        </div>
                    </div>

                    <script>
                        document.getElementById('activateMerchantBtn').addEventListener('click', function() {
                            if (confirm('Are you sure you want to activate this merchant?')) {
                                fetch("{{ route('agen_activate', [$merchant->id]) }}", {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                        },
                                        body: JSON.stringify({
                                            action: 'activate'
                                        })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            alert('Merchant has been activated.');
                                            location.reload(); // Reload the page or redirect to merchant list
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                    });
                            }
                        });

                        document.getElementById('deactivateMerchantBtn').addEventListener('click', function() {
                            if (confirm('Are you sure you want to deactivate this merchant?')) {
                                fetch("{{ route('agen_deactivate', [$merchant->id]) }}", {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                        },
                                        body: JSON.stringify({
                                            action: 'deactivate'
                                        })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            alert('Merchant has been deactivated.');
                                            location.reload(); // Reload the page or redirect to merchant list
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                    });
                            }
                        });
                    </script>

                    <div class="form-group row">
                        <div class="col-sm-12 text-right">
                            <a href="{{route('agen_list')}}">
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
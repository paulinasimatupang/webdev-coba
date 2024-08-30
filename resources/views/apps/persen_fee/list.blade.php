@extends('layouts.master')

@section('page-css')
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/pickadate/classic.css') }}">
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/pickadate/classic.date.css') }}">
@endsection

@section('main-content')
<div class="breadcrumb">
    <h1>Persen Fee</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row mb-4">
    <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center mb-3">
        <div class="input-group">
            <a href="{{ route('persen_fee_create') }}">
                <button class="btn btn-warning ripple m-1 add-new-btn" type="button">Add New</button>
            </a>
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="row">
                    <h4 class="col-sm-12 col-md-6 card-title mb-3">Persen Fee List</h4>
                </div>

                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif

                @if ($message = Session::get('failed'))
                <div class="alert alert-failed">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <div class="table-responsive">
                    <table id="default_ordering_table" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Penerima</th>
                                <th>Persentase</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($persenFees as $persenFee)
                            <tr>
                                <td>{{ $persenFee->id }}</td>
                                <td>{{ $persenFee->penerima }}</td>
                                <td>{{ $persenFee->persentase }}%</td>
                                <td>
                                    <a href="{{ route('persen_fee_edit', $persenFee->id) }}">
                                        <button class="btn btn-edit ripple btn-sm m-1" type="button">Edit</button>
                                    </a>
                                    <a href="#" onclick="deleteConfirm('{{ $persenFee->id }}'); return false;" class="btn btn-danger ripple btn-sm m-1">Delete</a>
                                </td>
                            </tr>
                            @php $no++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-js')
<script src="{{ asset('assets/js/vendor/echarts.min.js') }}"></script>
<script src="{{ asset('assets/js/es5/echart.options.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables.script.js') }}"></script>
<script src="{{ asset('assets/js/es5/dashboard.v4.script.js') }}"></script>
<script src="{{ asset('assets/js/vendor/pickadate/picker.js') }}"></script>
<script src="{{ asset('assets/js/vendor/pickadate/picker.date.js') }}"></script>
@endsection

@section('bottom-js')
<script src="{{ asset('assets/js/form.basic.script.js') }}"></script>
<script>
    function deleteConfirm(id) {
        var r = confirm("Are you sure?");
        if (r == true) {
            var url = '{{ route("persen_fee_destroy", ":id") }}';
            url = url.replace(':id', id);

            $.post(url, {
                    _token: "{{ csrf_token() }}",
                },
                function(data, status) {
                    location.reload(true);
                }).done(function() {
                location.reload(true);
            }).fail(function() {
                alert("Error, Please try again later!");
            })
        }
    }
</script>
<style>
    .add-new-btn {
        background-color: #0a6e44;
        border: none;
        color: white;
    }

    .btn-edit {
        background-color: #0182bd;
        border: none;
        color: white;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
        color: white;
    }
</style>
@endsection

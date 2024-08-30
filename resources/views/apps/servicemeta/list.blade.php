@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/pickadate/classic.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/pickadate/classic.date.css')}}">
@endsection

@section('main-content')
<div class="breadcrumb">
    <h1>Service Meta</h1>
    <ul>
        <li><a href="">Selada</a></li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row mb-4">
    <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center mb-3">
        <div class="input-group">
            <a href="{{route('servicemeta_create')}}">
                <button class="btn btn-warning ripple m-1 add-new-btn" type="button" @php if($username !=='selada_produktif' ) echo 'disabled' @endphp>Add New</button>
            </a>
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="row">
                    <h4 class=" col-sm-12 col-md-6 card-title mb-3">List Service Meta </h4>
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
                    <table id="deafult_ordering_table" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Meta ID</th>
                                <th scope="col">Service ID</th>
                                <th scope="col">Seq</th>
                                <th scope="col">Meta Type ID</th>
                                <th scope="col">Meta Default</th>
                                <th scope="col">Influx</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach($groups as $group)
                            <tr>
                                <th scope="row">{{ $no }}</th>
                                <td>{{ $group->meta_id }}</td>
                                <td>{{ $group->service_id }}</td>
                                <td>{{ $group->seq }}</td>
                                <td>{{ $group->meta_type_id }}</td>
                                <td>{{ $group->meta_default }}</td>
                                <td>{{ $group->influx}}</td>
                                <td>
                                    <a href="{{route('servicemeta_edit', $group->meta_id)}}">
                                        <button class="btn btn-edit ripple btn-sm m-1 edit-btn" type="button">Edit</button>
                                    </a>
                                    <a href="#" onclick="deleteConfirm({{ $group->meta_id }}); return false;" class="btn btn-danger ripple btn-sm m-1">Delete</a>
                                </td>
                            </tr>
                            @php
                            $no++;
                            @endphp
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
<script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
<script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/datatables.script.js')}}"></script>
<script src="{{asset('assets/js/es5/dashboard.v4.script.js')}}"></script>
<script src="{{asset('assets/js/vendor/pickadate/picker.js')}}"></script>
<script src="{{asset('assets/js/vendor/pickadate/picker.date.js')}}"></script>
@endsection

@section('bottom-js')
<script src="{{asset('assets/js/form.basic.script.js')}}"></script>
<script>
    function deleteConfirm(id) {
        var r = confirm("Are you sure?");
        if (r == true) {
            var url = '{{route("servicemeta_destroy",[":id"])}}';
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

    .edit-btn {
        background-color: #0182bd;
        border: none;
        color: white;
    }
</style>
@endsection
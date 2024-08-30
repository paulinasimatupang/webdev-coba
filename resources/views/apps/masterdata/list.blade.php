@extends('layouts.master')

@section('page-css')
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/pickadate/classic.css') }}">
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/pickadate/classic.date.css') }}">
@endsection

@section('main-content')
<style type="text/css">
    #b1,
    #b2,
    #b3 {
        display: none;
    }

    .card-link {
        text-decoration: none;
        color: inherit;
    }

    .card-link .card {
        transition: transform 0.2s;
    }

    .card-link:hover .card {
        transform: scale(1.05);
    }

    .card-body {
        cursor: pointer;
    }
</style>

<div class="breadcrumb">
    <h1>Master Data</h1>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row mb-4">
    <div class="col-lg-4 col-md-4 col-sm-4">
        <a href="/fee" class="card-link">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-2">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/images/new_features/fee.png') }}" alt="Service Meta" class="mr-3" style="width: 50px">
                        <div class="text-left">
                            <p class="text-muted mt-2 mb-0">Fee</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-4">
        <a href="/persen_fee" class="card-link">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-2">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/images/new_features/fee_persen.png') }}" alt="Service Meta" class="mr-3" style="width: 50px">
                        <div class="text-left">
                            <p class="text-muted mt-2 mb-0">Persen Fee</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-4">
        <a href="/roles" class="card-link">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-2">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/images/new_features/role.png') }}" alt="Service Meta" class="mr-3" style="width: 50px">
                        <div class="text-left">
                            <p class="text-muted mt-2 mb-0">Roles</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-4">
        <a href="/permissions" class="card-link">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-2">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/images/new_features/permission.png') }}" alt="Service Meta" class="mr-3" style="width: 50px">
                        <div class="text-left">
                            <p class="text-muted mt-2 mb-0">Permission</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-4">
        <a href="/users" class="card-link">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-2">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/images/new_features/user.png') }}" alt="Service Meta" class="mr-3" style="width: 50px">
                        <div class="text-left">
                            <p class="text-muted mt-2 mb-0">User</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    
    <!-- <div class="col-lg-4 col-md-4 col-sm-4">
        <a href="/hak-akses" class="card-link">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-2">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/images/new_features/fee.png') }}" alt="Service" class="mr-3" style="width: 50px">
                        <div class="text-left">
                            <p class="text-muted mt-2 mb-0">Hak Akses</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div> -->
</div>
@endsection
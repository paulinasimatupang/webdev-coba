@extends('layouts.master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/pickadate/classic.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/pickadate/classic.date.css') }}">
@endsection

@section('main-content')
    <style type="text/css">
        #b1, #b2, #b3 {
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
        <h1>New Features</h1>
        <ul>
            <li><a href="#">Selada</a></li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="row mb-4">
        <div class="col-lg-4 col-md-4 col-sm-4">
            <a href="/screen" class="card-link">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-2">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/new_features/screen.png') }}" alt="Total Transaction" class="mr-3" style="width: 50px">
                            <div class="text-left">
                                <p class="text-muted mt-2 mb-0">Screen</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4">
            <a href="/component" class="card-link">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-2">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/new_features/component.png') }}" alt="Component" class="mr-3" style="width: 60px">
                            <div class="text-left">
                                <p class="text-muted mt-2 mb-0">Component</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4">
            <a href="/service" class="card-link">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-2">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/new_features/service.png') }}" alt="Service" class="mr-3" style="width: 50px">
                            <div class="text-left">
                                <p class="text-muted mt-2 mb-0">Service</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4">
            <a href="/servicemeta" class="card-link">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-2">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/new_features/service_meta.png') }}" alt="Service Meta" class="mr-3" style="width: 50px">
                            <div class="text-left">
                                <p class="text-muted mt-2 mb-0">Service Meta</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4">
            <a href="/screen-component" class="card-link">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-2">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/new_features/screen_component.png') }}" alt="Screen Component" class="mr-3" style="width: 50px">
                            <div class="text-left">
                                <p class="text-muted mt-2 mb-0">Screen Component</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection

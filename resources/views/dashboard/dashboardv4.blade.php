@extends('layouts.master')
@section('page-css')
     <link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection
@section('main-content')
            <div class="breadcrumb">
                <h1>Agen</h1>
                <ul>
                    <li><a href="">Selada</a></li>
                    
            </div>
            <div class="separator-breadcrumb border-top"></div>
            <div class="row mb-4">


                <div class="col-md-12 mb-3">
                    <div class="card text-left">

                        <div class="card-body">
                        <div class="flex_bintang spaceb_bintang">
                            <h4 class="card-title mb-3">List Agen </h4>
                            <a href="{{route('dashboard_version_3')}}">
                            <button  type="button" class="btn btn-warning btn-icon mb-3">
                                        
                                                <span class="ul-btn__text">Tambah Agen</span>
                            </button>
                            </a>
                        </div>
                            <div class="table-responsive">
                                <table class="table">

                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Email</th>

                                            <th scope="col">Username</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Distributor</th>
                                            <th scope="col">Alamat</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Imam Kurtodwaji</td>
                                            <td>

                                               Imam Kurtodwaji@gmail

                                            </td>

                                            <td>Imam Ahli Bangunan</td>
                                            <td>lorem</td>
                                            <td>lorem</td>
                                            <td>Jl garang doang</td>
                                        

                                            <td>
                                                <a href="#" class="text-success mr-2">
                                                    <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                                </a>
                                                <a href="#" class="text-danger mr-2">
                                                    <i class="nav-icon i-Close-Window font-weight-bold"></i>
                                                </a>
                                            </td>
                                        </tr>
                                      
                                      
                                    

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
     <script src="{{asset('assets/js/es5/dashboard.v4.script.js')}}"></script>

@endsection

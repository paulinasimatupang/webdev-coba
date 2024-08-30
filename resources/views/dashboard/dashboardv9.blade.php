@extends('layouts.master')
@section('page-css')
     <link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
     <link rel="stylesheet" href="{{asset('assets/styles/vendor/pickadate/classic.css')}}">
     <link rel="stylesheet" href="{{asset('assets/styles/vendor/pickadate/classic.date.css')}}">

@endsection
@section('main-content')
            <div class="breadcrumb">
                <h1>Revenue</h1>
                <ul>
                    <li><a href="">Selada</a></li>
                    
            </div>
            <div class="separator-breadcrumb border-top"></div>
            <div class="row mb-4">

                <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center mb-3">
                                        <div class="input-group">
                                        
                                            <div id="picker3" class="input-group-append filter-dashboard-2 form-control">
                                            Filter
                                            </div>
                                        </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="card text-left">

                        <div class="card-body">
                        <div class="flex_bintang spaceb_bintang">
                            <h4 class="card-title mb-3">List Agen </h4>
                            <a href="{{route('dashboard_version_3')}}">
                          
                            </a>
                            
                        </div>
                        
                            <div class="table-responsive">
                                <table class="table">

                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Alamat</th>

                                            <th scope="col">Pendapatan</th>
                                      
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td> <span class="badge_bintang2">   <a href="{{route('dashboard_version_9')}}">Tak Gentar Terang</a> </span></td> 
                                            <td>

                                              Graha Permai

                                            </td>

                                            <td>Rp50.000.000</td>
                                          
                                          
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
     <script src="{{asset('assets/js/vendor/pickadate/picker.js')}}"></script>
     <script src="{{asset('assets/js/vendor/pickadate/picker.date.js')}}"></script>

@endsection
@section('bottom-js')
<script src="{{asset('assets/js/form.basic.script.js')}}"></script>


@endsection

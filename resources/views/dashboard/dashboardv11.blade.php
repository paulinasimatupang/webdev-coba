@extends('layouts.master')
@section('page-css')
     <link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
     <link rel="stylesheet" href="{{asset('assets/styles/vendor/pickadate/classic.css')}}">
     <link rel="stylesheet" href="{{asset('assets/styles/vendor/pickadate/classic.date.css')}}">
@endsection
@section('main-content')
            <div class="breadcrumb">
                <h1>Version</h1>
                <!-- <ul>
                    <li><a href="">Selada</a></li> -->
                    
            </div>
            <div class="separator-breadcrumb border-top"></div>
            <div class="row mb-4">
           

                <div class="col-md-12 mb-3">
                    <div class="card text-left">

                        <div class="card-body">
                        <div class="row">
                            <h4 class=" col-sm-12 col-md-6 card-title mb-3">List Version </h4>
                            <div class="col-sm-12 col-md-6 d-flex justify-content-end"><div id="zero_configuration_table_filter" class="dataTables_filter"><label class="d-flex align-items-center">Search:<input type="search" class="form-control form-control-sm ml-2" placeholder="" aria-controls="zero_configuration_table"></label></div></div>
                        </div>
                            <div class="table-responsive">
                                <table class="table">

                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Versi</th>
                                            <th scope="col">Tanggal Unduh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>V10023</td>
                                            <td>

                                            23-02-20 

                                            </td>

                                           
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>V42123</td>
                                            <td>

                                            23-04-20 

                                            </td>

                                           
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td>V50023</td>
                                            <td>

                                            07-07-21 

                                            </td>

                                           
                                        </tr>
                                        <tr>
                                            <th scope="row">4</th>
                                            <td>V52123</td>
                                            <td>

                                            02-08-21 

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
     <script src="{{asset('assets/js/vendor/pickadate/picker.js')}}"></script>
     <script src="{{asset('assets/js/vendor/pickadate/picker.date.js')}}"></script>


@endsection
@section('bottom-js')
<script src="{{asset('assets/js/form.basic.script.js')}}"></script>


@endsection

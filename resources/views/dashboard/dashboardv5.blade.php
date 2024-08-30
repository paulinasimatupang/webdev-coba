@extends('layouts.master')
@section('page-css')
     <link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection
@section('main-content')
            <div class="breadcrumb">
                <h1>Role management</h1>
                <ul>
                    <li><a href="">Super admin</a></li>
                    
            </div>
            <div class="separator-breadcrumb border-top"></div>
            <div class="row mb-4">


                <div class="col-md-12 mb-3">
                    <div class="card text-left">

                        <div class="card-body">
                        <div class="flex_bintang spaceb_bintang">
                            <h4 class="card-title mb-3">List Toko </h4>
                           
                        </div>
                            <div class="table-responsive">
                                <table class="table">

                                    <thead>
                                        <tr>
                                            <th scope="col">Menu</th>
                                            <th scope="col">Tambah</th>
                                            <th scope="col">Tampilan</th>

                                            <th scope="col">Hapus</th>
                                            <th scope="col">Ubah</th>
                                            <th scope="col">Approval</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">Dashboard</th>
                                            <td>
                                                <label class="checkbox checkbox-primary">
                                                    <input type="checkbox" checked="">
                                                   
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="checkbox checkbox-primary">
                                                    <input type="checkbox" checked="">
                                                   
                                                    <span class="checkmark"></span>
                                                </label>

                                            </td>

                                            <td>
                                                 <label class="checkbox checkbox-primary">
                                                    <input type="checkbox" checked="">
                                                   
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="checkbox checkbox-primary">
                                                    <input type="checkbox" checked="">
                                                   
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>

                                            <td>
                                                <label class="checkbox checkbox-primary">
                                                    <input type="checkbox" checked="">
                                                   
                                                    <span class="checkmark"></span>
                                                </label>
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

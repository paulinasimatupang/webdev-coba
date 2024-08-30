@extends('layouts.master')
@section('before-css')
 <link rel="stylesheet" href="{{asset('assets/styles/vendor/pickadate/classic.css')}}">
 <link rel="stylesheet" href="{{asset('assets/styles/vendor/pickadate/classic.date.css')}}">


@endsection
@section('main-content')
           <div class="breadcrumb">
                <h1>Dashboard</h1>
                <ul>
                    <li><a href="">BJB</a></li>
                    
                </ul>
            </div>
    
            <div class="separator-breadcrumb border-top"></div>
                <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center mb-3">
                                        <div class="input-group">
                                        
                                            <div id="picker3" class="input-group-append filter-dashboard form-control">
                                            Filter
                                            </div>
                                        </div>
                </div>
                <div class="row pl-3 pr-3">
                <!-- ICON BG -->
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-2">
                        <div class="card-body text-center">
                            <i class="i-Add-User"></i>
                           <div class="content max_width_bintang ml-4">
                                <p class="text-muted mt-2 mb-0">Jumlah Transaksi</p>
                                <p class="text-primary text-24 line-height-1 mb-2">Rp.210.000.000</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Financial"></i>
                            <div class="content max_width_bintang ml-4">
                                <p class="text-muted mt-2 mb-0">Amount Transaksi</p>
                                <p class="text-primary text-24 line-height-1 mb-2">Rp.210.000.000</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Checkout-Basket"></i>
                            <div class="content max_width_bintang ml-4">
                                <p class="text-muted mt-2 mb-0">Jumlah Agen</p>
                                <p class="text-primary text-24 line-height-1 mb-2">80</p>
                            </div>
                        </div>
                    </div>
                </div>

               

            </div>
            <div class="flex_bintang mt-1">
            
            <div class="col-lg-12 col-md-12 d-flex flex-wrap flex-row padding_lr_0">
                <!-- ICON BG -->
               
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card height_card_dashboard card-icon-bg card-icon-bg-primary o-hidden mb-3">
                        <div class="card-body align-items-center text-center">
                        <div class="logo_card">
                            <img src="{{asset('assets/images/icon_bintang/ntbs-transparan.png')}}" alt="">
                        </div>
                          
                            <div class="content max_width_bintang ml-4">
                                <p class="text-muted mt-2 mb-0">Pendapatan Selada</p>
                                <p class="text-primary text-24 line-height-1 mb-2">Rp.210.000.000</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card height_card_dashboard card-icon-bg card-icon-bg-primary o-hidden mb-3">
                        <div class="card-body align-items-center text-center">
                        <div class="logo_card">
                            <img src="{{asset('assets/images/icon_bintang/Bank_BJB_logo.png')}}" alt="">
                        </div>
                            <div class="content max_width_bintang ml-4">
                                <p class="text-muted mt-2 mb-0">Pendapatan BJB</p>
                                <p class="text-primary text-24 line-height-1 mb-2">Rp.210.000.000</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card height_card_dashboard card-icon-bg card-icon-bg-primary o-hidden mb-3">
                        <div class="card-body align-items-center text-center">
                        <div class="logo_card_2">
                            <img src="{{asset('assets/images/icon_bintang/distributor.png')}}" alt="">
                        </div>
                            <div class="content max_width_bintang ml-4">
                                <p class="text-muted mt-2 mb-0">Pendapatan Distributor</p>
                                <p class="text-primary text-24 line-height-1 mb-2">Rp.210.000.000</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card height_card_dashboard card-icon-bg card-icon-bg-primary o-hidden mb-3">
                        <div class="card-body align-items-center text-center">
                        <div class="logo_card_2">
                            <img src="{{asset('assets/images/icon_bintang/agent.png')}}" alt="">
                        </div>
                            <div class="content max_width_bintang ml-4">
                                <p class="text-muted mt-2 mb-0">Pendapatan Agen</p>
                                <p class="text-primary text-24 line-height-1 mb-2">Rp.210.000.000</p>
                            </div>
                        </div>
                    </div>
                </div>
                

              

            </div>

        

            </div>
           
        


@endsection


@section('page-js')
     <script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>
     <script src="{{asset('assets/js/vendor/pickadate/picker.js')}}"></script>
     <script src="{{asset('assets/js/vendor/pickadate/picker.date.js')}}"></script>

@endsection
@section('bottom-js')
<script src="{{asset('assets/js/form.basic.script.js')}}"></script>


@endsection

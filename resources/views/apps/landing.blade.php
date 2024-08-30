@extends('layouts.master')
@section('before-css')
 <link rel="stylesheet" href="{{asset('assets/styles/vendor/pickadate/classic.css')}}">
 <link rel="stylesheet" href="{{asset('assets/styles/vendor/pickadate/classic.date.css')}}">
 <style>
.card-icon-bg .card-body .content {
    margin: auto;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    max-width: 100px !important;
}
 </style>

@endsection
@section('main-content')
        <div class="breadcrumb">
            <h1>Selamat Datang!</h1>
            <ul>
                <li><a href="">Selamat Beraktifitas</a></li>
            </ul>
        </div>

        <div class="separator-breadcrumb border-top"></div>


        <div class="row">

	    <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card bg-dark text-white o-hidden mb-4">
			<img class="card-img" src="assets/images/ntbs.jpg" alt="Card image">
               	</div>
            </div>
            <!-- ICON BG -->
            <div class="col-lg-3 col-md-6 col-sm-6">
		<a href="dashboard">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <img src="{{asset('/assets/images/sidebar_icon/dashboard.png')}}" alt="" class="mr-3" style="width: 50px">
                        <div class="content">
                            <p class="lead text-primary text-24 mb-2">Dashboard</p>
                        </div>
                    </div>
                </div>
		</a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
		<a href="transaction">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                    <img src="{{asset('/assets/images/sidebar_icon/transaction.png')}}" alt="" class="mr-3" style="width: 50px">
                        <div class="content">
                            <p class="lead text-primary text-24 mb-2" style="text-align: left;">Transaksi Laku Pandai</p>
                        </div>
                    </div>
                </div>
		</a>
            </div>

            <!-- <div class="col-lg-3 col-md-6 col-sm-6"> -->
		<!-- <a href="transactionBJB">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                    <img src="{{asset('/assets/images/sidebar_icon/transactionbjb.png')}}" alt="" class="mr-3" style="width: 50px">
                        <div class="content">
                            <p class="text-muted mt-2 mb-0">Jump to</p>
                            <p class="lead text-primary text-24 mb-2">Trx BJB</p>
                        </div>
                    </div>
                </div>
		</a> -->
            <!-- </div> -->

            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="merchant">
		<div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                    <img src="{{asset('/assets/images/sidebar_icon/agent.png')}}" alt="" class="mr-3" style="width: 50px">
                        <div class="content">
                            <p class="lead text-primary text-24 mb-2">Merchants</p>
                        </div>
                    </div>
                </div>
		</a>
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

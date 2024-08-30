@extends('layouts.master')
@section('before-css')
 <link rel="stylesheet" href="{{asset('assets/styles/vendor/pickadate/classic.css')}}">
 <link rel="stylesheet" href="{{asset('assets/styles/vendor/pickadate/classic.date.css')}}">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/css/bootstrap-select.min.css">
<style>
.card-icon-bg .card-body .content {
    margin: auto;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    max-width: 100px !important;
}

{
  box-sizing: border-box;
}

/* Create two equal columns that floats next to each other */
.column {
  float: left;
  width: 50%;
  padding: 10px;
  height: 300px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
 </style>

@endsection
@section('main-content')
            <div class="breadcrumb row">
                <div class="col-lg-4 col-md-6 col-sm-12">
			        <h1>Dashboard</h1>
		        </div>
            
                <form class="col-lg-8 col-md-6 col-sm-12 form-row" method="GET" action="dashboard" id="dashboard_filter_form">
                
                    <div class="form-group col-lg-5 col-md-5 col-sm-12 mb-0">
                    <label for="inputtext14" class="ul-form__label">Start Date:</label> <input type="text" readonly="readonly" placeholder="Start Date" class="form-control start_date" value="{{app('request')->input('start_date')}}" name="start_date">
                    </div>
                    <div class="form-group col-lg-5 col-md-5 col-sm-12 mb-0">
                        <label for="inputtext14" class="ul-form__label">End Date:</label>
                        <input type="text" readonly="readonly" placeholder="End Date" class="form-control end_date" value="{{app('request')->input('end_date')}}" name="end_date">
                                </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 mb-0">
                        <label for="inputtext14" class="ul-form__label"> . </label>
                        <button type="submit" style="width:100%;" class="btn  btn-primary m-0">Filter</button>
                    </div>
                
                </form>

            </div>
    
            <div class="separator-breadcrumb border-top"></div>

            <div class="panel panel-default">
                        <div class="panel-heading"><h4><p>Fee Total {{$month}}</p></h4></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                                                <div class="card-body text-center">
                                                    <!-- <i class="i-Business-Man"></i> -->
                                                    <div class="avatar-md profile-user-wid mb-4">
                                                    <p> </p>
                                                    <img src="assets/images/icon_bintang/agent.png" alt="" class="img-thumbnail rounded-circle">
                                                    </div>
                                                    <div class="content">
                                                        <p class="text-muted mt-2 mb-0">Agent Fee</p>
                                                        <p class="lead text-primary text-24 mb-2">@currency($fee_agen)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                                                <div class="card-body text-center">
                                                    <div class="avatar-md profile-user-wid mb-4">
                                                    <p> </p>
                                                    <img src="assets/images/icon_bintang/Bank_BJB_logo.png" alt="" >
                                                    </div>
                                                    <div class="content">
                                                        <p class="text-muted mt-2 mb-0">BJB Fee</p>
                                                        <p class="lead text-primary text-24 mb-2" style="text-align: left;">@currency($fee_bjb)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                                                <div class="card-body text-center">
                                                    <div class="avatar-md profile-user-wid mb-4">
                                                    <p> </p>
                                                    <p> </p>
                                                    <img src="assets/images/icon_bintang/selada-transparant-final.png" alt="" >
                                                    </div>
                                                    <div class="content">
                                                        <p class="text-muted mt-2 mb-0">Selada Fee</p>
                                                        <p class="lead text-primary text-24 mb-2" style="text-align: left;">@currency($fee_selada)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>

                            
                            <div class="separator-breadcrumb border-top"></div>

                        <div class="panel-heading"><h4><p>Agent Total</p></h4></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <a href="dashboard/allAgent">
                                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                                                <div class="card-body text-center">
                                                    <div class="avatar-md profile-user-wid mb-4">
                                                    <p> </p>
                                                    <img src="assets/images/icon_bintang/ic_agent.png" alt="" class="img-thumbnail rounded-circle">
                                                    </div>
                                                    <div class="content">
                                                        <p class="text-muted mt-2 mb-0">All Agent</p>
                                                        <p class="lead text-primary text-24 mb-2">{{$total_merchant}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            </a>
                                        </div>

                                        <div class="col-sm-4">
                                            <a href="dashboard/activeAgent">
                                            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                                                <div class="card-body text-center">
                                                    <div class="avatar-md profile-user-wid mb-4">
                                                    <p> </p>
                                                    <img src="assets/images/icon_bintang/ic_active_agent.png" alt="" class="img-thumbnail rounded-circle">
                                                    </div>
                                                    <div class="content">
                                                        <p class="text-muted mt-2 mb-0">Active Agent</p>
                                                        <p class="lead text-primary text-24 mb-2" style="text-align: left;">{{$total_merchant_active}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            </a>
                                        </div>

                                        <div class="col-sm-4">
                                            
                                            <a href="dashboard/resignAgent">
                                            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                                                <div class="card-body text-center">
                                                    <div class="avatar-md profile-user-wid mb-4">
                                                    <p> </p>
                                                    <img src="assets/images/icon_bintang/ic_resign_agent.png" alt="" class="img-thumbnail rounded-circle">
                                                    </div>
                                                    <div class="content">
                                                        <p class="text-muted mt-2 mb-0">Resign Agent</p>
                                                        <p class="lead text-primary text-24 mb-2" style="text-align: left;">{{$total_merchant_resign}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            </a>
                                        </div>
                                </div>
                            </div>

                            
                            <div class="separator-breadcrumb border-top"></div>

                            <div class="panel-heading"><h4><p>Transaction Total {{$month}}</p></h4></div>
                            <div class="panel-body">
                                <div class='row'>
                                    <div class="col-sm-4">
                                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                                            <div class="card-body text-center">
                                                <i class="i-Financial"></i>
                                                <div class="content">
                                                    <p class="text-muted mt-0 mb-0">All</p>
                                                    <p class="lead text-primary text-24 mb-2" style="text-align: left;">{{$all_total_transaction}} trx</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                                            <div class="card-body text-center">
                                                <i class="i-Financial"></i>
                                                <div class="content">
                                                    <p class="text-muted mt-0 mb-0">PPOB</p>
                                                    <p class="lead text-primary text-24 mb-2" style="text-align: left;">{{$ppob_total_transaction}} trx</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                                            <div class="card-body text-center">
                                                <i class="i-Financial"></i>
                                                <div class="content">
                                                    <p class="text-muted mt-0 mb-0">Mini Banking</p>
                                                    <p class="lead text-primary text-24 mb-2" style="text-align: left;">{{$lakupandai_total_transaction}} trx</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="separator-breadcrumb border-top"></div>

                            <div class="panel-heading"><h4><p>Transaction Amount {{$month}}</p></h4></div>
                            <div class="panel-body">
                                <div class='row'>
                                    <div class="col-sm-4">
                                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                                            <div class="card-body text-center">
                                                <i class="i-Financial"></i>
                                                <div class="content">
                                                    <p class="text-muted mt-0 mb-0">All</p>
                                                    <p class="lead text-primary text-24 mb-2" style="text-align: left;">@currency($all_total_amount_transaction)</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                                            <div class="card-body text-center">
                                                <i class="i-Financial"></i>
                                                <div class="content">
                                                    <p class="text-muted mt-0 mb-0">PPOB</p>
                                                    <p class="lead text-primary text-24 mb-2" style="text-align: left;">@currency($ppob_total_amount_transaction)</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                                            <div class="card-body text-center">
                                                <i class="i-Financial"></i>
                                                <div class="content">
                                                    <p class="text-muted mt-0 mb-0">Mini Banking</p>
                                                    <p class="lead text-primary text-24 mb-2" style="text-align: left;">@currency($lakupandai_total_amount_transaction)</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>

            <div class="separator-breadcrumb border-top"></div>

                <div class="row">

                    <div class="col-sm-4">
                        <div>

                        <div class="panel panel-default">
                                    <div class="panel-heading"><h4><p>All Agent Fee</p></h4></div>
                                    <div class="panel-body">
                                    
                                    <div class="card overflow-hidden">
                                <div class="bg-primary bg-soft">
                                <div class="row">
                                <div class="col-7">
                                <div class="text-primary p-3">
                                <h4><p style="color:white">All Rank 1</p></h4>
                                <h5><p style="color:white">The most agent fee {{$month}}</p></h5>
                                </div>
                                </div>
                                </div>
                                </div>
                                <div class="card-body pt-0">
                                <div class="row">
                                <div class="col-sm-5">
                                <div class="avatar-md profile-user-wid mb-4">
                                <p> </p>
                                <img src="assets/images/icon_bintang/agent.png" alt="" class="img-thumbnail rounded-circle">
                                </div>

                                <h5 class="font-size-15 text-truncate">{{$fee_all->agent_name}}</h5>
                                <p class="text-muted mb-0">{{$fee_all->tid}}</p>
                                </div>
                                <div class="col-sm-7">
                                <div class="pt-4">
                                <div class="row">
                                <div class="col-10">

                                <h5 class="font-size-15" id="saldo">@currency($fee_all->total_amount_fee)</h5>
                                <p class="text-muted mb-0">Total Fee</p>
                                </div>
                                </div>
                                <div class="mt-4">
                                    <a id="dashboard-all" style="" href='#' type="button" class="btn btn-outline-secondary">Lihat Selengkapnya<i class="mdi mdi-arrow-right ms-1"></i></a>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>

                                    </div>
                                </div>

                        </div>
                    </div>

                    <div class="col-sm-4" >
                        <div>
                        <div class="panel panel-default">
                            <div class="panel-heading"><h4><p>PPOB Agent Fee</p></h4></div>
                                <div class="panel-body">
                                    
                                <div class="card overflow-hidden">
                                <div class="bg-primary bg-soft">
                                <div class="row">
                                <div class="col-7">
                                <div class="text-primary p-3">
                                <h4><p style="color:white">PPOB Rank 1</p></h4>
                                <h5><p style="color:white">The most agent fee {{$month}}</p></h5>
                                </div>
                                </div>
                                </div>
                                </div>
                                <div class="card-body pt-0">
                                <div class="row">
                                <div class="col-sm-5">
                                <div class="avatar-md profile-user-wid mb-4">
                                <p> </p>
                                <img src="assets/images/icon_bintang/agent.png" alt="" class="img-thumbnail rounded-circle">
                                </div>

                                <h5 class="font-size-15 text-truncate">{{$data->agent_name}}</h5>
                                <p class="text-muted mb-0">{{$data->tid}}</p>
                                </div>
                                <div class="col-sm-7">
                                <div class="pt-4">
                                <div class="row">
                                <div class="col-10">

                                <h5 class="font-size-15" id="saldo">@currency($data->total_amount_fee)</h5>

                                <p class="text-muted mb-0">Total Fee</p>
                                </div>
                                </div>
                                <div class="mt-4">
                                    <a id="dashboard-ppob" style="" href='#' type="button" class="btn btn-outline-secondary">Lihat Selengkapnya<i class="mdi mdi-arrow-right ms-1"></i></a>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>

                                </div>
                            </div>
                        </div>
                    </div>  

                    <div class="col-sm-4">
                        <div>

                        <div class="panel panel-default">
                                    <div class="panel-heading"><h4><p>Lakupandai Agent Fee</p></h4></div>
                                    <div class="panel-body">
                                    
                                    <div class="card overflow-hidden">
                                <div class="bg-primary bg-soft">
                                <div class="row">
                                <div class="col-7">
                                <div class="text-primary p-3">
                                <h4><p style="color:white">Lakupandai Rank 1</p></h4>
                                <h5><p style="color:white">The most agent fee {{$month}}</p></h5>
                                </div>
                                </div>
                                </div>
                                </div>
                                <div class="card-body pt-0">
                                <div class="row">
                                <div class="col-sm-5">
                                <div class="avatar-md profile-user-wid mb-4">
                                <p> </p>
                                <img src="assets/images/icon_bintang/agent.png" alt="" class="img-thumbnail rounded-circle">
                                </div>

                                <h5 class="font-size-15 text-truncate">{{$fee_lakupandai->agent_name}}</h5>
                                <p class="text-muted mb-0">{{$fee_lakupandai->tid}}</p>
                                </div>
                                <div class="col-sm-7">
                                <div class="pt-4">
                                <div class="row">
                                <div class="col-10">

                                <h5 class="font-size-15" id="saldo">@currency($fee_lakupandai->total_amount_fee)</h5>
                                <p class="text-muted mb-0">Total Fee</p>
                                </div>
                                </div>
                                <div class="mt-4">
                                    <a id="dashboard-lakupandai" style="" href='#' type="button" class="btn btn-outline-secondary">Lihat Selengkapnya<i class="mdi mdi-arrow-right ms-1"></i></a>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>

                                    </div>
                                </div>

                        </div>
                    </div>
                </div>

            <p>  </p>
            <div class="separator-breadcrumb border-top"></div>
            <div class="row">
                @if($is_reward == false)
                    <div class="col-sm-4">
                            <div>
                            <div class="panel panel-default">
                                        <div class="panel-heading"><h4><p>Agent Reward</p></h4></div>
                                        <div class="panel-body">
                                        
                                        <div class="card overflow-hidden">
                                    <div class="bg-primary bg-soft">
                                    <div class="row">
                                    <div class="col-7">
                                    <div class="text-primary p-3">
                                    <h4><p style="color:white">Reward Winner</p></h4>
                                    <h5><p style="color:white">Reward Agen bjb BiSA {{$month}}</p></h5>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="card-body pt-0">
                                    <div class="row">
                                    <div class="col-sm-5">
                                    <div class="avatar-md profile-user-wid mb-4">
                                    <p> </p>
                                    <img src="assets/images/icon_bintang/agent.png" alt="" class="img-thumbnail rounded-circle">
                                    </div>

                                    <h5 class="font-size-15 text-truncate">Belum tersedia</h5>
                                    <p class="text-muted mb-0">-</p>
                                    </div>
                                    <div class="col-sm-7">
                                    <div class="pt-4">
                                    <div class="row">
                                    <div class="col-10">

                                    <h5 class="font-size-15" id="saldo">@currency("0")</h5>
                                    <p class="text-muted mb-0">Total Reward</p>
                                    </div>
                                    </div>
                                    <div class="mt-4">
                                    <!-- <a href="dashboard/all" class="btn btn-primary waves-effect waves-light btn-sm">Lihat Selengkapnya<i class="mdi mdi-arrow-right ms-1"></i></a> -->
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>

                                        </div>
                                    </div>

                            </div>
                        </div>
                @endif

                @if($is_reward == true)
                    @foreach($reward_agent as $item)
                        @if ($item->reward_total > 0)
                            <div class="col-sm-4">
                                <div>
                                <div class="panel panel-default">
                                            <div class="panel-heading"><h4><p>Agent Reward</p></h4></div>
                                            <div class="panel-body">
                                            
                                            <div class="card overflow-hidden">
                                        <div class="bg-primary bg-soft">
                                        <div class="row">
                                        <div class="col-7">
                                        <div class="text-primary p-3">
                                        <h4><p style="color:white">Reward Winner</p></h4>
                                        <h5><p style="color:white">Reward Agen bjb BiSA {{$month}}</p></h5>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                        <div class="card-body pt-0">
                                        <div class="row">
                                        <div class="col-sm-5">
                                        <div class="avatar-md profile-user-wid mb-4">
                                        <p> </p>
                                        <img src="assets/images/icon_bintang/agent.png" alt="" class="img-thumbnail rounded-circle">
                                        </div>

                                        <h5 class="font-size-15 text-truncate">{{$item->agent_name}}</h5>
                                        <p class="text-muted mb-0">{{$item->tid}}</p>
                                        </div>
                                        <div class="col-sm-7">
                                        <div class="pt-4">
                                        <div class="row">
                                        <div class="col-10">

                                        <h5 class="font-size-15" id="saldo">@currency($item->reward_total)</h5>
                                        <p class="text-muted mb-0">Total Reward</p>
                                        </div>
                                        </div>
                                        <div class="mt-4">
                                            <a id="dashboard-reward" style="" href='#' type="button" class="btn btn-outline-secondary">Lihat Selengkapnya<i class="mdi mdi-arrow-right ms-1"></i></a>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                        </div>

                                            </div>
                                        </div>

                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
                    
            </div>  


@endsection


@section('page-js')
     <script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>
     <script src="{{asset('assets/js/vendor/pickadate/picker.js')}}"></script>
     <script src="{{asset('assets/js/vendor/pickadate/picker.date.js')}}"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/js/bootstrap-select.min.js" charset="utf-8"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script src="{{asset('assets/js/es5/chartjs.script.min.js')}}"></script>
     <script>
        var url = "{{url('/dashboard')}}";
        var Years = new Array();
        var Labels = new Array();
        var Prices = new Array();
        $(document).ready(function(){
          $.get(url, function(response){
            response.forEach(function(data){
                Years.push(data.stockYear);
                Labels.push(data.stockName);
                Prices.push(data.stockPrice);
            });
            var ctx = document.getElementById("canvas").getContext('2d');
                var myChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels:Years,
                      datasets: [{
                          label: 'Infosys Price',
                          data: Prices,
                          borderWidth: 1
                      }]
                  },
                  options: {
                      scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero:true
                              }
                          }]
                      }
                  }
              });
          });
        });
    </script>
    
    <script>
        $("#dashboard-ppob").on('click', function() {
                    window.location = "dashboard/ppob?"+$('#dashboard_filter_form').serialize()
        });
        $("#dashboard-lakupandai").on('click', function() {
                    window.location = "dashboard/lakupandai?"+$('#dashboard_filter_form').serialize()
        });
        $("#dashboard-all").on('click', function() {
                    window.location = "dashboard/all?"+$('#dashboard_filter_form').serialize()
        });
        $("#dashboard-reward").on('click', function() {
                    window.location = "dashboard/reward?"+$('#dashboard_filter_form').serialize()
        });
        var $dateFrom = $('.start_date').pickadate({
            format:'mmm yyyy',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            onClose: function(dateText, inst) { 
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            }
        }),
            dateFromPicker = $dateFrom.pickadate('picker');

        var $dateTo = $('.end_date').pickadate({
            format:'mmm yyyy',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            onClose: function(dateText, inst) { 
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            }
        }),
            dateToPicker = $dateTo.pickadate('picker');

        dateFromPicker.on({
        open: function(e) {
            console.log('Open start_date');
            if ($dateFrom.val()) {
            console.log('User is making a change to start_date');
            }
        },
        close: function(e) {
            if ($dateFrom.val() && !$dateTo.val()) {
            console.log('Open end_date via start_date');
            dateToPicker.open();
            }
            else if (!$dateFrom.val()) {
            console.log('User left start_date empty. Not popping end_date');
            }
            console.log('Close start_date');
            // workaround for github issue #160
            $(document.activeElement).blur();
        }
        });
        dateToPicker.on({
        open: function(e) {
            console.log('Poppped end_date');
            if ($dateTo.val()) {
            console.log('User is making a change to end_date');
            }
        },
        close: function(e) {
            if (!$dateTo.val()) {
            console.log('User left end_date empty. Not popping start_date or end_date');
            }
            console.log('Close end_date');
            // workaround for github issue #160
            $(document.activeElement).blur();
        }
        });



    </script>
@endsection
@section('bottom-js')
<script src="{{asset('assets/js/form.basic.script.js')}}"></script>


@endsection

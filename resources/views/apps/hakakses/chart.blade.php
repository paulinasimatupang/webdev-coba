@extends('layouts.master')

@section('page-css')
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/pickadate/classic.css') }}">
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/pickadate/classic.date.css') }}">
@endsection

@section('main-content')
<div class="breadcrumb">
    <h1>Master Data Chart</h1>
    <ul>
        <li><a href="{{ route('masterdata_chart') }}">Master Data List</a></li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row mb-4">
    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">Distribution of Master Data by Status</h4>
                <div style="width: 75%; margin: auto;">
                    <canvas id="masterDataChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('bottom-js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById('masterDataChart').getContext('2d');
        var chartData = @json($chartData);

        var myChart = new Chart(ctx, {
            type: 'line', // Menggunakan tipe grafik garis
            data: chartData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Distribution of Master Data by Status'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Categories'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Count'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection

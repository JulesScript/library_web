@extends('layouts.admin_layout')

@section('title', 'Dashboard')

@section('content')
<div class="pagetitle">
    <h1>Home</h1>
    <nav>
        <ol class="breadcrumb">
            <!-- <li class="breadcrumb-item"><a href="index.html">Home</a></li> -->
            <!-- <li class="breadcrumb-item">Home</li> -->
                <!-- <li class="breadcrumb-item active">Blank</li> -->
        </ol>
    </nav>
</div><!-- End Page Title -->

<div class="container">
    <h2 class="mb-4">Dashboard Overview</h2>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body p-3">
                    <h5>Total Research Files</h5>
                    <h3>{{ $totalResearches }}</h3>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body p-3">
                    <h5>Total Courses</h5>
                    <h3>{{ $totalCourses }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-warning text-white">
                <div class="card-body p-3">
                    <h5>Total Categories</h5>
                    <h3>{{ $totalCategories }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Research Uploads Per Month Chart -->
    <div class="mt-5">
        <h4>Research Uploads Per Month</h4>
        <canvas id="researchChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('researchChart').getContext('2d');
    var researchChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Research Files Uploaded',
                data: @json($data),
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
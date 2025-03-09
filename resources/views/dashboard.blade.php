@extends('layouts.admin_layout')

@section('title', 'Dashboard')

@section('content')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Home</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<div class="container">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card p-3">
                <div class="card-body">
                    <h2>Welcome, {{ auth()->user()->name }}!</h2>
                    <p>This dashboard provides you quick access to your research files, statistics, and useful tools.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Research Files</h5>
                    <p class="card-text display-6">{{ $totalResearchFiles }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Recent Uploads</h5>
                    <p class="card-text display-6">{{ $recentUploadsCount }}</p>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- Optionally, include Chart.js for future analytics -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
@extends('layouts.admin_layout')

@section('title', 'Settings')

@section('content')
<div class="pagetitle">
    <h1>Settings</h1>
    <nav>
        <ol class="breadcrumb">
            <!-- <li class="breadcrumb-item"><a href="index.html">Home</a></li> -->
            <!-- <li class="breadcrumb-item">Settings</li> -->
            <!-- <li class="breadcrumb-item active">Blank</li> -->
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Modules</h5>
            <!-- Row with max 4 columns -->
            <div class="row">
                <div class="col-md-3 text-center">
                    <a href="{{ route('settings-categories.index') }}" class="category-link text-dark">
                        <i class="bi bi-window-plus text-dark" style="font-size: 24px;"></i>
                        <span>Category</span>
                    </a>
                </div>
                <div class="col-md-3 text-center">
                    <a href="{{ route('settings-grades.index') }}" class="category-link text-dark">
                        <i class="bi bi-mortarboard text-dark" style="font-size: 24px;"></i>
                        <span>Grade</span>
                    </a>
                </div>
                <div class="col-md-3 text-center">
                    <a href="{{ route('settings-courses.index') }}" class="category-link text-dark">
                        <i class="bi bi-folder-plus text-dark" style="font-size: 24px;"></i>
                        <span>Courses</span>
                    </a>
                </div>
                <div class="col-md-3 text-center">
                    <a href="{{ route('settings.researches.index') }}" class="category-link text-dark">
                        <i class="bi bi-file-earmark-text text-dark" style="font-size: 24px;"></i>
                        <span>Research</span>
                    </a>
                </div>

                {{-- <div class="col-md-3 text-center">
                    <a href="" class="category-link text-dark">
                        <i class="bi bi-person text-dark" style="font-size: 24px;"></i>
                        <span>Students</span>
                    </a>
                </div>  --}}
            </div>
        </div>
    </div>
</section>

@endsection
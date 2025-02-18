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

<section class="section">
    <div class="row">
        <div class="col-lg-6">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Example Card</h5>
                    <p>Lorem ipsum dolor sit amet consectetur.</p>
                </div>
            </div>

        </div>

        <div class="col-lg-6">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Example Card</h5>
                    <p>Lorem ipsum dolor sit amet consectetur..</p>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
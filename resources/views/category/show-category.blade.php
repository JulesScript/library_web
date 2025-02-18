
@extends('layouts.admin_layout')

@section('title', 'Category')

@section('content')

<div class="pagetitle">
    <h1>Category</h1>
    <nav>
        <ol class="breadcrumb">
            {{-- <li class="breadcrumb-item">Settings</li>
            <li class="breadcrumb-item active">Category</li> --}}
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="row p-3">
                @foreach($categories as $category)
                    <div class="col-md-4">
                        <div class="card category-card">
                            <div class="card-body">
                                <h5 class="card-title text-white text-center" style="text-transform: uppercase;">{{ $category->name }}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<style>
    .category-card {
        background-color: #470303;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .category-card:hover {
        transform: scale(1.05); /* Slight zoom effect */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3); /* Adds shadow on hover */
    }
</style>



@section('scripts')
<script>
    const categoryStoreUrl = "{{ route('settings-categories.store') }}";
    var categoryIndexUrl = @json(route('settings-categories.index'));
</script>
<script src="{{ asset('assets/js/category.js') }}"></script>
@endsection


@endsection
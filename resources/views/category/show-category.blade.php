@extends('layouts.admin_layout')

@section('title', 'Category')

@section('content')

<div class="pagetitle">
    <h1>List of Category</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Category</li>
            {{-- <li class="breadcrumb-item active">Category</li> --}}
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section" id="category-section">
    <div class="card">
        <div class="card-body">
            <div class="row p-3">
                @foreach ($categories as $category)
                <div class="col-md-4">
                    <div class="card category-card category-btn" data-id="{{ $category->id }}">
                        <div class="card-body">
                            <h5 class="card-title text-white text-center" style="text-transform: uppercase;">
                                {{ $category->name }}
                            </h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Year Levels Section (Initially Hidden) -->
<section class="section" id="year-level-section" style="display: none;">
    <div class="card p-3">
        <div class="card-body">
            <button id="back-to-categories" class="btn btn-secondary mb-3">← Back to Categories</button>
            <h4 id="year-level-title"></h4>
            <div class="row p-3" id="year-level-container"></div>
        </div>
    </div>
</section>



<!-- Courses Section (Initially Hidden) -->
<!-- <section class="section" id="courses-section" style="display: none;">
        <div class="card p-3">
            <div class="card-body">
                <button id="back-btn" class="btn btn-secondary mb-3">← Back</button>
                <h4 id="category-title"></h4>
                <div class="row p-3" id="courses-container"></div>
            </div>
        </div>
    </section> -->
<section class="section" id="courses-section" style="display: none;">
    <div class="card p-3">
        <div class="card-body">
            <button id="back-btn" class="btn btn-secondary mb-3">← Back</button>
            <h4 id="category-title"></h4>
            <div class="row p-3" id="courses-container"></div>
        </div>
    </div>
</section>

<!-- Research Files Section (Initially Hidden) -->
<section class="section" id="research-section" style="display: none;">
    <div class="card p-3">
        <div class="card-body">
            <button id="courses-back-btn" class="btn btn-secondary mb-3">← Back to Courses</button>
            <h4 id="course-title"></h4>
            <div id="loadingIndicator" class="text-center" style="display: none;">
                <p>Loading research files...</p>
            </div>
            <div class="mb-3">
                <input type="text" id="searchResearch" class="form-control" placeholder="Search research files...">
            </div>
            <div class="row p-3" id="researchContainer"></div>
        </div>
    </div>
</section>

<style>
    .category-card, .yearlevel-card , .course-card{
        background-color: #470303;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
       color:white;
    }
    .category-card:hover, .yearlevel-card:hover, .course-card:hover {
        transform: scale(1.05);
        /* Slight zoom effect */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        /* Adds shadow on hover */
    }
    #1{
        color:red;
    }
</style>



@section('scripts')
<script>
    const coursesFilterUrl = "{{ route('courses.filter') }}";
    const yearlevelFilterUrl = "{{ route('yearlevels.filter') }}";
    var researchesIndexUrl = @json(route('researches.index'));
    const categoryStoreUrl = "{{ route('settings-categories.store') }}";
    var categoryIndexUrl = @json(route('settings-categories.index'));
</script>
<script src="{{ asset('assets/js/category.js') }}"></script>
@endsection


@endsection
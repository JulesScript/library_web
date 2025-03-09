@extends('layouts.admin_layout')

@section('title', 'Year Level')

@section('content')

<div class="pagetitle">
    <h1>Year Level</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Settings</li>
            <li class="breadcrumb-item active">Year level</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">Year level List</h5>
                <!-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCoursesModal">
                    <i class="bi bi-plus-lg"></i> Add Courses
                </button> -->
            </div>

            <!-- Add Category Modal -->
            <div class="modal fade" id="addCoursesModal" tabindex="-1" aria-labelledby="addCoursesModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCoursesModalLabel">Add Courses</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addCoursesForm" method="POST" action="{{ route('settings-courses.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-control" id="category" name="category_id" required>
                                        <option value="" disabled selected>Select Category</option>
                               
                                    </select>
                                </div>
                            
                                <div class="mb-3">
                                    <label for="CoursesName" class="form-label">Courses Name</label>
                                    <input type="text" class="form-control" id="CoursesName" name="Courses_name" required>
                                </div>
                            
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Course</button>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- DataTable -->
            <div class="table-responsive">
                <table id="yearlevelTable" class="table table-striped"  data-index-url="{{ route('settings-grades.index') }}">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Year Level</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

@section('scripts')
<script>
</script>
<script src="{{ asset('assets/js/yearlevel.js') }}"></script>
@endsection


@endsection
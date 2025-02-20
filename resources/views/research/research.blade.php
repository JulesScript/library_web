@extends('layouts.admin_layout')

@section('title', 'Research')

@section('content')

<div class="pagetitle">
    <h1>Research</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Settings</li>
            <li class="breadcrumb-item active">Research</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">Research List</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addResearchModal">
                    <i class="bi bi-plus-lg"></i> Add Research
                </button>
            </div>

            <!-- Add Category Modal -->
            <div class="modal fade" id="addResearchModal" tabindex="-1" aria-labelledby="addResearchModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addResearchModalLabel">Add Research</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addResearchForm" method="POST" action="{{ route('settings.researches.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="course" class="form-label">Course</label>
                                    <select class="form-control" id="course" name="course_id" required>
                                        <option value="" disabled selected>Select Course</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->name }} - {{ $course->category_name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="researchName" class="form-label">Research Name</label>
                                    <input type="text" class="form-control" id="researchName" name="research_name" required>
                                </div>
                            
                                <div class="mb-3">
                                    <label for="researchFile" class="form-label">Upload Research File</label>
                                    <input type="file" class="form-control" id="researchFile" name="file_path" required>
                                </div>
                            
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Research</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- DataTable -->
            <div class="table-responsive">
                <table id="researchTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Courses</th>
                            <th>Research File Name</th> <!-- Added for file_path -->
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                        
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

@section('scripts')
<script>
    const researchStoreUrl = "{{ route('settings.researches.store') }}";
    var researchesIndexUrl = @json(route('settings.researches.index'));
</script>
<script src="{{ asset('assets/js/research.js') }}"></script>
@endsection


@endsection
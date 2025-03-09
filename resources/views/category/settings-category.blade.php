@extends('layouts.admin_layout')

@section('title', 'Category')

@section('content')

<div class="pagetitle">
    <h1>Category</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Settings</li>
            <li class="breadcrumb-item active">Category</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">Category List</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    <i class="bi bi-plus-lg"></i> Add Category
                </button>
            </div>

            <!-- Add Category Modal -->
            <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addCategoryForm" method="POST" action="{{ route('settings-categories.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="categoryName" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" id="categoryName" name="category_name"
                                        required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Category</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- DataTable -->
            <div class="table-responsive">
                <table id="categoryTable" class="table table-striped" id="categoryTable" data-index-url="{{ route('settings-categories.index') }}">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
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
    const coursesFilterUrl = "{{ route('courses.filter') }}";
    // var researchesIndexUrl = @json(route('researches.index'));
    const categoryStoreUrl = "{{ route('settings-categories.store') }}";
    // var categoryIndexUrl = {!! json_encode(route('settings-categories.index')) !!};
</script>
<script src="{{ asset('assets/js/category.js') }}"></script>
@endsection


@endsection
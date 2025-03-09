$(document).ready(function () {
    $("#searchResearch").on("keyup", function () {
        let searchText = $(this).val().toLowerCase().trim(); // Trim spaces for better matching

        $("#researchContainer .col-md-4").each(function () {
            let fileName = $(this).find("a").text().toLowerCase();

            if (fileName.includes(searchText) || searchText === "") {
                $(this).show(); // Show the card if it matches or if search is empty
            } else {
                $(this).hide(); // Hide if it doesn't match
            }
        });
    });

    var categoryIndexUrl = $("#categoryTable").data("index-url");

    if ($("#categoryTable").length) {
        $("#categoryTable").DataTable({
            processing: true,
            serverSide: true,
            ajax: categoryIndexUrl, // Use the variable instead of Blade syntax
            columns: [
                { data: "id", name: "id" },
                { data: "name", name: "name" },
                {
                    data: "created_at",
                    name: "created_at",
                    render: function (data, type, row) {
                        return moment(data).format("MM/DD/YYYY"); // Format the date here
                    },
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                },
            ],
        });
    }

    // Get the category store URL
    const categoryStoreUrl = $("#addCategoryForm").attr("action");

    $("#addCategoryForm").submit(function (event) {
        event.preventDefault(); // Prevent normal form submission

        let categoryName = $("#categoryName").val(); // Get the category name
        let courseName = $("#category").val();

        $.ajax({
            url: categoryStoreUrl, // Use the form's action URL (which is the store route)
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"), // CSRF token
                category_name: categoryName,
            },
            success: function (response) {
                // Show a SweetAlert success message
                Swal.fire({
                    title: "Success!",
                    text: "Category added successfully!",
                    icon: "success",
                    confirmButtonText: "Okay",
                });

                $("#addCategoryModal").modal("hide");
                $("#addCategoryForm")[0].reset(); // Reset the form fields

                // Re-fetch the data and reinitialize the DataTable
                $("#categoryTable").DataTable().ajax.reload();
            },
            error: function (error) {
                // Show a SweetAlert error message
                Swal.fire({
                    title: "Error!",
                    text: "Error adding category!",
                    icon: "error",
                    confirmButtonText: "Try Again",
                });

                console.log(error);
            },
        });
    });

    // Delete category
    $("#categoryTable").on("click", ".delete-category", function () {
        var categoryId = $(this).data("id"); // Get the category ID from the button's data-id attribute

        // Show SweetAlert2 confirmation dialog
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, keep it",
        }).then((result) => {
            if (result.isConfirmed) {
                // Make the AJAX call to delete the category
                $.ajax({
                    url: "/settings-categories/" + categoryId, // Use the resource route for deletion
                    method: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"), // CSRF token
                    },
                    success: function (response) {
                        // Show success alert
                        Swal.fire({
                            title: "Deleted!",
                            text: "The category has been deleted.",
                            icon: "success",
                            confirmButtonText: "Okay",
                        });

                        // Reload the DataTable to reflect the changes
                        $("#categoryTable").DataTable().ajax.reload();
                    },
                    error: function (error) {
                        // Show error alert
                        Swal.fire({
                            title: "Error!",
                            text: "There was an error deleting the category.",
                            icon: "error",
                            confirmButtonText: "Try Again",
                        });
                    },
                });
            }
        });
    });
});


$(document).ready(function () {
    // Global state variables
    var currentCategoryId = null;       // The selected category
    var currentYearlevelId = null;      // The selected year level
    var currentCoursesView = "yearlevels"; // "yearlevels" or "courses"

    // ----- 1. Category Click: Load Year Levels -----
    $(".category-btn").click(function () {
        currentCategoryId = $(this).data("id");
        var categoryName = $(this).find(".card-title").text();
        currentCoursesView = "yearlevels"; // Starting with year levels view

        // Hide category section, show courses section (used for displaying year levels)
        $("#category-section").hide();
        $("#courses-section").show();
        $("#category-title").text("Year Levels under " + categoryName);

        // Update breadcrumb: Category > Year Levels
        $(".breadcrumb").html(`
            <li class="breadcrumb-item"><a href="#" id="back-to-categories">Category</a></li>
            <li class="breadcrumb-item active">Year Levels</li>
        `);

        // Set back button text for year levels view
        $("#back-btn").text("← Back to Categories");

        $("#courses-container").html("<p class='text-center'>Loading year levels...</p>");
        $.ajax({
            url: yearlevelFilterUrl, // Endpoint to get year levels by category
            method: "GET",
            data: { category_id: currentCategoryId },
            success: function (response) {
                $("#courses-container").html("");
                if (response.yearlevels && response.yearlevels.length > 0) {
                    response.yearlevels.forEach(function (yearlevel) {
                        $("#courses-container").append(`
                            <div class="col-md-4">
                                <div class="card yearlevel-card" data-yearlevel-id="${yearlevel.id}">
                                    <div class="card-body">
                                        <h5 class="card-title text-center" style="color:white;">${yearlevel.name}</h5>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                } else {
                    $("#courses-container").html("<p class='text-center'>No year levels found for this category.</p>");
                }
            },
            error: function () {
                $("#courses-container").html("<p class='text-center text-danger'>Error loading year levels. Please try again.</p>");
            }
        });
    });

    // ----- 2. Year Level Click: Load Courses -----
    $(document).on("click", ".yearlevel-card", function () {
        currentYearlevelId = $(this).data("yearlevel-id");
        currentCoursesView = "courses"; // Now showing courses

        $("#category-title").text("Courses under Year Level");
        // Update breadcrumb: Category > Year Levels > Courses
        $(".breadcrumb").html(`
            <li class="breadcrumb-item"><a href="#" id="back-to-categories">Category</a></li>
            <li class="breadcrumb-item"><a href="#" id="back-to-yearlevels">Year Levels</a></li>
            <li class="breadcrumb-item active">Courses</li>
        `);

        // Set back button text for courses view
        $("#back-btn").text("← Back to Year Levels");

        $("#courses-container").html("<p class='text-center'>Loading courses...</p>");
        $.ajax({
            url: coursesFilterUrl, // Endpoint to get courses by year level
            method: "GET",
            data: { yearlevel_id: currentYearlevelId },
            success: function (response) {
                $("#courses-container").html("");
                if (response.courses && response.courses.length > 0) {
                    response.courses.forEach(function (course) {
                        $("#courses-container").append(`
                            <div class="col-md-4">
                                <div class="card course-card" data-course-id="${course.id}">
                                    <div class="card-body">
                                        <h5 class="card-title text-center text-white">${course.name}</h5>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                } else {
                    $("#courses-container").html("<p class='text-center'>No courses found for this year level.</p>");
                }
            },
            error: function () {
                $("#courses-container").html("<p class='text-center text-danger'>Error loading courses. Please try again.</p>");
            }
        });
    });

    // ----- 3. Course Click: Load Research Files -----
    $(document).on("click", ".course-card", function () {
        var courseId = $(this).data("course-id");
        var courseName = $(this).find(".card-title").text();

        // Hide courses section, show research section
        $("#courses-section").hide();
        $("#research-section").show();
        $("#course-title").text("Research Files for " + courseName);

        // Update breadcrumb: Category > Year Levels > Courses > Research
        $(".breadcrumb").html(`
            <li class="breadcrumb-item"><a href="#" id="back-to-categories">Category</a></li>
            <li class="breadcrumb-item"><a href="#" id="back-to-yearlevels">Year Levels</a></li>
            <li class="breadcrumb-item"><a href="#" id="back-to-courses">Courses</a></li>
            <li class="breadcrumb-item active">Research</li>
        `);

        $("#researchContainer").html("");
        $("#loadingIndicator").show();
        $.ajax({
            url: researchesIndexUrl, // Endpoint to get research files by course
            method: "GET",
            data: { course_id: courseId },
            success: function (response) {
                $("#loadingIndicator").hide();
                $("#researchContainer").html("");
                if (response.data && response.data.length > 0) {
                    var researchHtml = "";
                    response.data.forEach(function (research) {
                        researchHtml += `
                            <div class="col-md-4">
                                <div class="card p-3 d-flex align-items-center">
                                    <i class="bi bi-file-earmark-pdf text-danger" style="font-size: 24px;"></i>
                                    <a href="/storage/${research.file_path}" target="_blank" class="text-dark">
                                        ${research.file_name}
                                    </a>
                                </div>
                            </div>
                        `;
                    });
                    $("#researchContainer").html(researchHtml);
                } else {
                    $("#researchContainer").html("<p class='text-center'>No research files available.</p>");
                }
            },
            error: function () {
                $("#loadingIndicator").hide();
                $("#researchContainer").html("<p class='text-center text-danger'>Failed to load research files.</p>");
            }
        });
    });

    // ----- 4. Back Buttons -----
    // Back button in Courses Section (#back-btn)
    $("#back-btn").click(function () {
        // If currently in courses view (courses loaded), then back should return to the year levels view.
        if (currentCoursesView === "courses") {
            currentCoursesView = "yearlevels";
            $("#courses-container").html("<p class='text-center'>Loading year levels...</p>");
            $.ajax({
                url: yearlevelFilterUrl,
                method: "GET",
                data: { category_id: currentCategoryId },
                success: function (response) {
                    $("#courses-container").html("");
                    if (response.yearlevels && response.yearlevels.length > 0) {
                        response.yearlevels.forEach(function (yearlevel) {
                            $("#courses-container").append(`
                                <div class="col-md-4">
                                    <div class="card yearlevel-card" data-yearlevel-id="${yearlevel.id}">
                                        <div class="card-body">
                                            <h5 class="card-title text-center text-white">${yearlevel.name}</h5>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });
                    } else {
                        $("#courses-container").html("<p class='text-center'>No year levels found.</p>");
                    }
                    $("#category-title").text("Year Levels");
                    // Update breadcrumb: Category > Year Levels
                    $(".breadcrumb").html(`
                        <li class="breadcrumb-item"><a href="#" id="back-to-categories">Category</a></li>
                        <li class="breadcrumb-item active">Year Levels</li>
                    `);
                    // Set back button text for year levels view
                    $("#back-btn").text("← Back to Categories");
                },
                error: function () {
                    $("#courses-container").html("<p class='text-center text-danger'>Error loading year levels.</p>");
                }
            });
        } else if (currentCoursesView === "yearlevels") {
            // If in year levels view, back should return to the category section.
            $("#courses-section").hide();
            $("#category-section").show();
            $("#courses-container").html("");
            $(".breadcrumb").html(`<li class="breadcrumb-item active">Category</li>`);
        }
    });

    // Back button in Research Section (#courses-back-btn)
    $("#courses-back-btn").click(function () {
        $("#research-section").hide();
        $("#courses-section").show();
        $("#researchContainer").html("");
        // Update breadcrumb to: Category > Year Levels > Courses
        $(".breadcrumb").html(`
            <li class="breadcrumb-item"><a href="#" id="back-to-categories">Category</a></li>
            <li class="breadcrumb-item"><a href="#" id="back-to-yearlevels">Year Levels</a></li>
            <li class="breadcrumb-item active">Courses</li>
        `);
    });
});





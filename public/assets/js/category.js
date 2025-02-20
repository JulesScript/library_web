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
    // Handle category click to load courses
    $(".category-btn").click(function () {
        let categoryId = $(this).data("id"); // Get category ID
        let categoryName = $(this).find(".card-title").text(); // Get category name

        // Hide category section and show courses section
        $("#category-section").hide();
        $("#courses-section").show();
        $("#category-title").text("Courses under " + categoryName);

        // Update breadcrumb
        $(".breadcrumb").html(`
            <li class="breadcrumb-item"><a href="#" id="back-to-categories">Category</a></li>
            <li class="breadcrumb-item active">Courses</li>
        `);

        // Clear previous courses and show loading message
        $("#courses-container").html(
            "<p class='text-center'>Loading courses...</p>"
        );

        // Make AJAX request to get courses
        $.ajax({
            url: coursesFilterUrl, // Route to get courses
            method: "GET",
            data: { category_id: categoryId },
            success: function (response) {
                $("#courses-container").html(""); // Remove loading text

                if (response.courses.length > 0) {
                    response.courses.forEach((course) => {
                        $("#courses-container").append(`
                            <div class="col-md-4">
                                <div class="card course-card course-link" data-course-id="${course.id}">
                                    <div class="card-body category-card">
                                        <h5 class="card-title text-center text-white">${course.name}</h5>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                } else {
                    $("#courses-container").html(
                        "<p class='text-center'>No courses found for this category.</p>"
                    );
                }
            },
            error: function () {
                $("#courses-container").html(
                    "<p class='text-center text-danger'>Error loading courses. Please try again.</p>"
                );
            },
        });
    });

    $(document).ready(function () {
        $(document).on("click", ".course-card", function () {
            let courseId = $(this).data("course-id");
            let courseName = $(this).find(".card-title").text();
            console.log("Clicked course ID:", courseId);

            // Hide courses section, show research section
            $("#courses-section").hide();
            $("#research-section").show();
            $("#course-title").text("Research Files for " + courseName);

            // Update breadcrumb
            $(".breadcrumb").html(`
            <li class="breadcrumb-item"><a href="#" id="back-to-categories">Category</a></li>
            <li class="breadcrumb-item">Course</li>
            <li class="breadcrumb-item active">Research</li>
        `);

            $("#researchContainer").html(""); // ✅ CLEAR research files before loading new ones
            $("#loadingIndicator").show(); // Show loading indicator

            $.ajax({
                url: researchesIndexUrl,
                method: "GET",
                data: { course_id: courseId },
                success: function (response) {
                    console.log("Research Response:", response);

                    $("#loadingIndicator").hide();
                    $("#researchContainer").html(""); // ✅ Clear again to prevent duplicate data

                    if (!response.data || response.data.length === 0) {
                        $("#researchContainer").html(
                            "<p class='text-center'>No research files available.</p>"
                        );
                        return;
                    }

                    let researchHtml = "";
                    response.data.forEach(function (research) {
                        researchHtml += `
                            <div class="col-md-4">
                                <div class="card p-3 d-flex align-items-center">
                                    <i class="bi bi-file-earmark-pdf text-danger" style="font-size: 24px;"></i>
                                    <a href="/storage/${research.file_path}" target="_blank" class="text-dark">
                                        ${research.file_name}
                                    </a>
                                </div>
                            </div>`;
                    });

                    $("#researchContainer").html(researchHtml);
                },
                error: function () {
                    $("#loadingIndicator").hide();
                    $("#researchContainer").html(
                        "<p class='text-danger text-center'>Failed to load research files.</p>"
                    );
                },
            });
        });

        // Back to courses functionality
        $("#courses-back-btn").click(function () {
            $("#research-section").hide();
            $("#courses-section").show();
            $("#researchContainer").html(""); // ✅ Clear research files when going back
        });

        // Back to categories functionality
        $("#back-btn").click(function () {
            $("#courses-section").hide();
            $("#category-section").show();
            $("#courses-container").html(""); // ✅ Clear courses when going back
        });
    });

    // Back button to return to category selection
    $("#back-btn").click(function () {
        $("#courses-section").hide();
        $("#category-section").show();
        $("#courses-container").html(""); // Clear courses when going back
    });
});

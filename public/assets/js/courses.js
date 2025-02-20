$(document).ready(function () {
    console.log("sadasd");
    if ($("#coursesTable").length) {
        $("#coursesTable").DataTable({
            processing: true,
            serverSide: true,
            ajax: coursesIndexUrl, // Use the variable instead of Blade syntax
            columns: [
                { data: "id", name: "id" },
                { data: "category_name", defaultContent: "No Category" }, // Fetch category name
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

    // Get the course store URL
    const coursesStoreUrl = $("#addCoursesForm").attr("action");

    $("#addCoursesForm").submit(function (event) {
        event.preventDefault(); // Prevent normal form submission

        let categoryId = $("#category").val(); // Corrected category selection
        let courseName = $("#CoursesName").val(); // Course name

        $.ajax({
            url: coursesStoreUrl, // Use the form's action URL
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"), // CSRF token
                category_id: categoryId, // Corrected ID field
                course_name: courseName, // Match Laravel validation field
            },
            success: function (response) {
                Swal.fire({
                    title: "Success!",
                    text: "Course added successfully!",
                    icon: "success",
                    confirmButtonText: "Okay",
                });

                $("#addCoursesModal").modal("hide");
                $("#addCoursesForm")[0].reset(); // Reset form fields

                $("#coursesTable").DataTable().ajax.reload();
            },
            error: function (error) {
                Swal.fire({
                    title: "Error!",
                    text: "Error adding course!",
                    icon: "error",
                    confirmButtonText: "Try Again",
                });

                console.log(error);
            },
        });
    });


        // Delete category
        $("#coursesTable").on("click", ".delete-courses", function () {
            var courseId = $(this).data("id"); // Get the category ID from the button's data-id attribute
    
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
                        url: "/settings-courses/" + courseId, // Use the resource route for deletion
                        method: "DELETE",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr("content"), // CSRF token
                        },
                        success: function (response) {
                            // Show success alert
                            Swal.fire({
                                title: "Deleted!",
                                text: "The course has been deleted.",
                                icon: "success",
                                confirmButtonText: "Okay",
                            });
    
                            // Reload the DataTable to reflect the changes
                            $("#coursesTable").DataTable().ajax.reload();
                        },
                        error: function (error) {
                            // Show error alert
                            Swal.fire({
                                title: "Error!",
                                text: "There was an error deleting the course.",
                                icon: "error",
                                confirmButtonText: "Try Again",
                            });
                        },
                    });
                }
            });
        });


});

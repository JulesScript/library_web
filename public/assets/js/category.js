$(document).ready(function () {
      
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

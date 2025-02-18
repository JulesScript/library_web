// $(document).ready(function () {
//     // Initialize DataTable
//     $('#categoryTable').DataTable();
// });

$(document).ready(function () {
    // Get the category store URL
    const categoryStoreUrl = $('#addCategoryForm').attr('action');

    $('#addCategoryForm').submit(function (event) {
        event.preventDefault();  // Prevent normal form submission

        let categoryName = $('#categoryName').val();  // Get the category name

        $.ajax({
            url: categoryStoreUrl,  // Use the form's action URL (which is the store route)
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token
                category_name: categoryName
            },
            success: function (response) {
                alert("Category added successfully!");
                $('#addCategoryModal').modal('hide');
                $('#addCategoryForm')[0].reset();  // Reset the form fields

                // Assuming the response contains the new category data
                var newCategory = response.category;
                $('#categoryTable').DataTable().row.add([
                    newCategory.id,
                    newCategory.name,
                    '<button class="btn btn-danger delete-category">Delete</button>'
                ]).draw();  // Add the new category to your table
            },
            error: function (error) {
                console.log(error);
                alert("Error adding category!");
            }
        });
    });
});

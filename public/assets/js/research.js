$(document).ready(function () {


    var researchesIndexUrl = $("#researchTable").data("index-url");
    if ($("#researchTable").length) {
        $("#researchTable").DataTable({
            processing: true,
            serverSide: true,
            ajax: researchesIndexUrl, // Make sure this variable points to your research AJAX endpoint
            pageLength: 10, // Limits rows per page
            columns: [
                { data: "id", name: "id" },
                { data: "category_name", name: "category.name", defaultContent: "No Category" },
                { data: "year_level", name: "year_level", defaultContent: "No Year Level" },
                { data: "course_name", name: "course.name", defaultContent: "No Course" },
                { data: "file_name", name: "file_name" },
                {
                    data: "created_at",
                    name: "created_at",
                    render: function (data, type, row) {
                        return moment(data).format("MM/DD/YYYY");
                    }
                },
                { data: "action", name: "action", orderable: false, searchable: false },
            ],
        });
    }


    // Get the research store URL
    const researchStoreUrl = $("#addResearchForm").attr("action");

    $("#addResearchForm").submit(function (event) {
        event.preventDefault(); // Prevent normal form submission

        let formData = new FormData(this); // Use FormData for file upload

        $.ajax({
            url: researchStoreUrl, // Form's action URL
            method: "POST",
            data: formData,
            processData: false, // Required for FormData
            contentType: false, // Required for FormData
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                Swal.fire({
                    title: "Success!",
                    text: "Research file added successfully!",
                    icon: "success",
                    confirmButtonText: "Okay",
                });

                $("#addResearchModal").modal("hide");
                $("#addResearchForm")[0].reset(); // Reset form fields

                // Reload DataTable
                $("#researchTable").DataTable().ajax.reload();
            },
            error: function (error) {
                Swal.fire({
                    title: "Error!",
                    text: "Error adding research file!",
                    icon: "error",
                    confirmButtonText: "Try Again",
                });

                console.log(error);
            },
        });
    });
});

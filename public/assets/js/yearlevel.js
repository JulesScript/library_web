$(document).ready(function () {

    var categoryIndexUrl = $("#yearlevelTable").data("index-url");


    if ($("#yearlevelTable").length) {
        $("#yearlevelTable").DataTable({
            processing: true,
            serverSide: true,
            ajax: categoryIndexUrl, // Use the variable instead of Blade syntax
            columns: [
                { data: "id", name: "id" },
                { data: "category_id", name: "category_id" },
                { data: "name", name: "name" },
                {
                    data: "created_at",
                    name: "created_at",
                    render: function (data, type, row) {
                        return moment(data).format("MM/DD/YYYY"); // Format the date here
                    },
                }

            ],
        });
    }
});
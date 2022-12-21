$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
    },
});

const table = $("#example1").DataTable({
    lengthMenu: [
        [10, 25, 50, 100, 500, -1],
        [10, 25, 50, 100, 500, "All"],
    ],
    searching: false,
    responsive: true,
    lengthChange: true,
    autoWidth: false,
    order: [],
    pagingType: "full_numbers",
    language: {
        search: "_INPUT_",
        searchPlaceholder: "Cari...",
        processing:
            '<div class="spinner-border text-info" role="status">' +
            '<span class="sr-only">Loading...</span>' +
            "</div>",
        paginate: {
            Search: '<i class="icon-search"></i>',
            first: "<i class='fas fa-angle-double-left'></i>",
            previous: "<i class='fas fa-angle-left'></i>",
            next: "<i class='fas fa-angle-right'></i>",
            last: "<i class='fas fa-angle-double-right'></i>",
        },
    },
    oLanguage: {
        sSearch: "",
    },
    processing: true,
    serverSide: true,
    ajax: {
        url: `${url}/admin/popup/dataTable`,
        method: "POST",
        data: function (d) {
            d.name = $('input[name="name"]').val();
            d.date = $('input[name="date"]').val();
            d.status = $('select[name="status"]').val();
            d.type = $('select[name="type"]').val();
            return d;
        },
    },
    columns: [
        {
            name: "created_at",
            data: "DT_RowIndex",
        },
        {
            name: "title",
            data: "content",
            orderable: false,
        },

    ],
});

$('input[name="name"]').on('keyup', function() {
    table.draw();
});

$('input[name="date"]').on('change', function() {
    table.draw();
});

$('select[name="status"]').on('change', function() {
    table.draw();
});

$('select[name="type"]').on('change', function() {
    table.draw();
});


table.on("click", ".btn-hapus", function (e) {
    e.preventDefault();
    const id = $(this).data("id");
    const nama = $(this).data("title");
    const urlTarget = `${url}/admin/popup/${id}`
    deleteDataTable(nama, urlTarget, table)
});

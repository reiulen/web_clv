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
        url: `${url}/admin/counter-section/dataTable`,
        method: "POST",
        data: function (d) {
            d.name = $('input[name="name"]').val();
            d.date = $('input[name="date"]').val();
            d.content = $('input[name="content"]').val();
            return d;
        },
    },
    columns: [
        {
            name: "created_at",
            data: "DT_RowIndex",
        },
        {
            name: "name",
            data: "content",
            orderable: false,
        },

    ],
});

$('#filterName').on('keyup', function() {
    table.draw();
});

$('#filterContent').on('keyup', function() {
    table.draw();
});

$('#filterDate').on('change', function() {
    table.draw();
});

table.on("click", ".btn-hapus", function (e) {
    e.preventDefault();
    const id = $(this).data("id");
    const nama = $(this).data("title");
    const urlTarget = `${url}/admin/counter-section/${id}`
    deleteDataTable(nama, urlTarget, table)
});


$(function() {
    $('.btnAdd').on('click', function() {
        $('#modalInput').modal('show');
    });

    table.on('click', '.btnEdit', function() {
        const form = $('#submitInput');
        const id = $(this).data('id');
        const name = $(this).data('name');
        const status = $(this).data('status');
        const content = $(this).data('content');
        const modal = $('#modalInput');
        modal.modal('show');
        form.find('[name="id"]').val(id);
        form.find('[name="name"]').val(name);
        form.find('[name="content"]').val(content);
    });

    $('#submitInput').on('change', function() {
        checkValue();
    }).on('keyup', function() {
        checkValue();
    }).on('submit', async function(e) {
        e.preventDefault();
        const form = $(this);
        const buttonSubmit = $('#submitBtn');
        buttonSubmit.attr('disabled', true);
        buttonSubmit.html('Loading...');
        const data = form.serialize();

       const result = await sendData(`${url}/admin/counter-section`, 'POST', data);
        if (result.status == 'success') {
            buttonSubmit.attr('disabled', false).html('Simpan');
            $('#modalInput').modal('hide');
            table.draw();
            Swal.fire(`Berhasil disimpan`, result.message, "success");
        }else {
            buttonSubmit.attr('disabled', false).html('Simpan');
            Swal.fire(`Gagal`, result.message, "error");
        }
    });

    $('#modalInput').on('hide.bs.modal', function (e) {
        const form = $(this).find('#submitInput');
        form.find('[name="id"]').val('');
        form.trigger('reset');
    });

    function checkValue() {
        const submitBtn = $('#submitBtn');
        const name = $('#name').val();
        const status = $('#status').val();
        const link = $('#link').val();

        if (name == '' || status == '' || link == '') {
            submitBtn.attr('disabled', true);
        } else {
            submitBtn.attr('disabled', false);
        }
    }
})

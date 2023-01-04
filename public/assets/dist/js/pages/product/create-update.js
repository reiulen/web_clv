$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
    },
});


//summary detail
const tableSummary = $("#summary").DataTable({
    lengthMenu: [
        [10, 25, 50, 100, 500, -1],
        [10, 25, 50, 100, 500, "All"],
    ],
    searching: false,
    responsive: true,
    lengthChange: true,
    autoWidth: false,
    info: false,
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
            previous: "<i class='fas fa-angle-left'></i>",
            next: "<i class='fas fa-angle-right'></i>",
        },
    },
    oLanguage: {
        sSearch: "",
    },
    processing: true,
    serverSide: true,
    ajax: {
        url: `${url}/admin/product/dataTable/summaryDataTable`,
        method: "POST",
        data: function (d) {
            d.summaryDetail = $('input[name="summaryDetail"]').val();
            return d;
        },
    },
    columns: [
        {
            name: "name",
            data: "content",
        },

    ],
});

tableSummary.on("click", ".btn-trash", function (e) {
    e.preventDefault();
    const id = $(this).data("id");
    const nama = $(this).data("title");
    const urlTarget = `${url}/admin/product/summaryDetail/delete/${id}`
    deleteDataTable(nama, urlTarget, tableSummary)
});


//detail

const tableProductDetail = $("#productDetail").DataTable({
    lengthMenu: [
        [10, 25, 50, 100, 500, -1],
        [10, 25, 50, 100, 500, "All"],
    ],
    searching: false,
    responsive: true,
    lengthChange: true,
    autoWidth: false,
    info: false,
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
            previous: "<i class='fas fa-angle-left'></i>",
            next: "<i class='fas fa-angle-right'></i>",
        },
    },
    oLanguage: {
        sSearch: "",
    },
    processing: true,
    serverSide: true,
    ajax: {
        url: `${url}/admin/product/dataTable/detailDataTable`,
        method: "POST",
        data: function (d) {
            d.detailProduct = $('input[name="detailProduct"]').val();
            return d;
        },
    },
    columns: [
        {
            name: "name",
            data: "content",
        },

    ],
});

tableProductDetail.on("click", ".btn-trash", function (e) {
    e.preventDefault();
    const id = $(this).data("id");
    const nama = $(this).data("title");
    const urlTarget = `${url}/admin/product/detail/delete/${id}`
    deleteDataTable(nama, urlTarget, tableProductDetail)
});


$(function() {

    // tableSummary.on('click', '.btnEdit', function() {
    //     const form = $('#submitInputSummary');
    //     const id = $(this).data('id');
    //     const name = $(this).data('name');
    //     const status = $(this).data('status');
    //     const icon = $(this).data('icon');
    //     const modal = $('#modalInput');
    //     modal.modal('show');
    //     form.find('[name="id"]').val(id);
    //     form.find('[name="name"]').val(name);
    //     form.find('[name="status"]').val(status);
    //     form.find('[name="icon"]').val(icon);
    // });

    $('#submitInputSummary').on('change', function() {
        checkValueSummary();
    }).on('keyup', function() {
        checkValueSummary();
    }).on('submit', async function(e) {
        e.preventDefault();
        const form = $(this);
        const buttonSubmitSummary = $('#submitBtnSummary');
        buttonSubmitSummary.attr('disabled', true);
        buttonSubmitSummary.html('Loading...');
        const data = form.serialize();
        const inputSummaryDetail = $('#summaryDetail');

       const result = await sendData(`${url}/admin/product/summaryDetail/store`, 'POST', data);
        if (result.status == 'success') {
            inputSummaryDetail.val(inputSummaryDetail.val() + ' ' + result.data);
            buttonSubmitSummary.attr('disabled', false).html('Simpan');
            $('#modalSummaryDetail').modal('hide');
            tableSummary.draw();
            Swal.fire(`Berhasil disimpan`, result.message, "success");
        }else {
            buttonSubmitSummary.attr('disabled', false).html('Simpan');
            Swal.fire(`Gagal`, result.message, "error");
        }
    });

    $('#submitInputDetail').on('change', function() {
        checkValueDetail();
    }).on('keyup', function() {
        checkValueDetail();
    }).on('submit', async function(e) {
        e.preventDefault();
        const form = $(this);
        const submitBtnDetail = $('#submitBtnDetail');
        submitBtnDetail.attr('disabled', true);
        submitBtnDetail.html('Loading...');
        const data = new FormData(this);
        const detailProduct = $('#detailProduct');

       const result = await sendDataFile(`${url}/admin/product/detail/store`, 'POST', data);
        if (result.status == 'success') {
            detailProduct.val(detailProduct.val() + ' ' + result.data);
            submitBtnDetail.attr('disabled', false).html('Simpan');
            $('#modalDetailProduct').modal('hide');
            tableProductDetail.draw();
            Swal.fire(`Berhasil disimpan`, result.message, "success");
        }else {
            submitBtnDetail.attr('disabled', false).html('Simpan');
            Swal.fire(`Gagal`, result.message, "error");
        }
    });

    $('#modalSummaryDetail').on('hide.bs.modal', function (e) {
        const form = $(this).find('#submitInputSummary');
        $('#icon').val(null).trigger('change');
        form.trigger('reset');
    });

    $('#modalDetailProduct').on('hide.bs.modal', function (e) {
        const form = $(this).find('#submitInputDetail');
        form.trigger('reset');
        form.find('#detailProductInput').summernote('reset');
        form.find('.img-preview#foto').attr('style', '');
    });

    function checkValueSummary() {
        const submitBtnSummary = $('#submitBtnSummary');
        const name = $('#nameSummary').val();
        const icon = $('#icon').val();
        const detail = $('#detail').val();

        if (name == '' || detail == '' || icon == '') {
            submitBtnSummary.attr('disabled', true);
        } else {
            submitBtnSummary.attr('disabled', false);
        }
    }

    function checkValueDetail() {
        const submitBtnDetail = $('#submitBtnDetail');
        const name = $('#nameDetail').val();

        if (name == '') {
            submitBtnDetail.attr('disabled', true);
        } else {
            submitBtnDetail.attr('disabled', false);
        }
    }
})


function formatState (state) {
    if (!state.id) {
        return state.text;
    }

    return $(`
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="${state.icon}"></i>
            <span>${state.text}</span>
        </div>
    `);
};

function formatList (state) {

    if (!state.id) {
        return state.text;
    }

    return $(`
        <div style="display: flex; align-items: center; gap: 20px;">
            <i class="${state.icon}"></i>
            <span>${state.text}</span>
        </div>
    `);
};

$("#icon").select2({
    templateResult: formatList,
    templateSelection: formatState,
    ajax: {
        url: `${url}/admin/icon/getData/select2`,
        dataType: 'json',
        delay: 250,
        data: function (data) {
            return {
                keyword: data.term
            };
        },
        processResults: function (response) {
            return {
                results:response
            };
        },
        cache: true
    }
});

$(".logout").click(function () {
    const nama = $(this).data("nama");
    Swal.fire({
        title: "Apakah yakin?",
        text: `Anda akan keluar dari Sistem ${nama}`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#6492b8da",
        cancelButtonColor: "#d33",
        confirmButtonText: "Keluar",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            const logout = `${url}/logout`;
            const formLogout = $('#logoutForm');
            formLogout.attr('action', logout);
            formLogout.submit();
        }
    });
});

function hapus(id) {
    data = $(`#hapus${id}`).attr("data");
    Swal.fire({
        title: "Apakah yakin?",
        text: `Data ${data} akan Dihapus`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#6492b8da",
        cancelButtonColor: "#d33",
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $(`#form-hapus${id}`).submit();
        }
    });
}

function deleteDataTable(nama, urlTarget, table) {
    Swal.fire({
        title: "Apakah yakin?",
        text: `Data ${nama} akan dihapus`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#6492b8da",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yakin",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: urlTarget,
                method: "post",
                data: [{ name: "_method", value: "DELETE" }],
                success: function (res) {
                    table.draw();
                    Swal.fire(`Berhasil dihapus`, res.message, "success");
                },
                error: function (res) {
                    console.log(res);
                    Swal.fire(`Gagal`, `${res.responseJSON.message}`, "error");
                },
            });
        }
    });
}

async function sendData(url, type, data) {
    const config = {
        method: type,
        url: url,
        data: data,
    };
    const result = await axios(config)
                    .then((res) => res.data)
                    .then(async (res) => {
                        return res;
                    }).catch(async (err) => {
                        Swal.fire(`Gagal`, err.responseJSON.message, "error");
                        return err.response;
                    });

    return result;
}


async function sendDataFile(url, type, data) {
    const header = {
        "Content-Type": "multipart/form-data",
    };

    const config = {
        method: type,
        url: url,
        header: header,
        data: data
    };

    const result = await axios(config)
                    .then((res) => res.data)
                    .then(async (res) => {
                        return res;
                    }).catch(async (err) => {
                        Swal.fire(`Gagal`, err.responseJSON.message, "error");
                        return err.response;
                    });

    return result;
}

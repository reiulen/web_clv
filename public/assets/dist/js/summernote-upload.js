$(target).summernote({
    height: heightRow,
    toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['insert', ['table', 'picture']],
        ['Misc', ['codeview','fullscreen']]
    ],
    callbacks: {
        onImageUpload: function(files) {
            for (let i = 0; i < files.length; i++) {
                $.upload(files[i], uploadUrl);
            }
        },
        onMediaDelete: function(target) {
            $.delete(target[0].src, deleteUrl);
        }
    },
});

$.upload = function(file, url_tambah) {
    let out = new FormData();
    out.append('file', file, file.name);
    $.ajax({
        method: 'POST',
        url: url_tambah,
        contentType: false,
        cache: false,
        processData: false,
        data: out,
        success: function(img) {
            $('.text-editor').summernote('insertImage', img);
        },
        error: function(err) {
            alert('Gambar tidak di izinkan!');
        }
    });
};

$.delete = function(src, url_delete) {
    $.ajax({
        method: 'POST',
        url: url_delete,
        cache: false,
        data: {
            src: src,
        },
        success: function(response) {
            alert(response.message)
        },
    });
};

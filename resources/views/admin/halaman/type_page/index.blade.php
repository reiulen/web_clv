<x-app-layout title="Tipe Halaman">
    <x-content_header>
        <div class="col-sm-6">
            <h4>Artikel</h4>
        </div>

        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">{{ __('Blog') }}</li>
            <li class="breadcrumb-item item">{{ __('Artikel') }}</li>
        </x-breadcrumb>
    </x-content_header>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-header">
                        <div class="row">
                            <div class="d-md-flex">
                                <div>
                                    <div role="button" class="btn btn-primary border-0 btnAdd">
                                        <i class="fa fa-plus px-1"></i>
                                        Tambah
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered  table-hover">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>Tipe Halaman</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>
                                        <div class="row" style="gap: 6px;">
                                            <div class="col-sm-4">
                                                <input class="form-control" placeholder="Cari nama" name="name" type="text" id="filterName">
                                            </div>
                                            <div class="col-sm-4">
                                                <input class="form-control" name="date" type="date" id="filterDate">
                                            </div>
                                            <div class="col-sm-3">
                                                <select class="form-control" name="status" id="filterStatus">
                                                    <option value="">Pilih Status</option>
                                                    <option value="1">Publish</option>
                                                    <option value="2">Draft</option>
                                                </select>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    @push('modals')
    <div class="modal fade" id="modalInput" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Tipe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="submitInput">
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="name">Nama Tipe</label>
                        <input type="text"
                                class="form-control"
                                id="name"
                                name="name">
                    </div>
                    <div class="form-group mb-3">
                        <label for="status">
                            Status
                        </label>
                        @php
                            $status = [
                                1 => 'Publish',
                                2 => 'Draft',
                            ]
                        @endphp
                        <select class="form-control @error('status') is-invalid @enderror" name="status" id="status">
                            <option value="">Pilih status</option>
                            @foreach ($status as $key => $st)
                                <option value="{{ $key }}">{{ $st }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button id="submitBtn" disabled="true" class="btn btn-primary">Simpan</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    @endpush


    @include('lib.datatable')
    @push('script')
    <script src="{{ asset('assets/dist/js/pages/type_page/index.js') }}"></script>
    <script>
        $(function() {
            $('.btnAdd').on('click', function() {
                $('#modalInput').modal('show');
            });

            table.on('click', '.btnEdit', function() {
                const form = $('#submitInput');
                const id = $(this).data('id');
                const name = $(this).data('name');
                const status = $(this).data('status');
                const modal = $('#modalInput');
                modal.modal('show');
                form.find('[name="id"]').val(id);
                form.find('[name="name"]').val(name);
                form.find('[name="status"]').val(status);
            });

            $('#submitInput').on('change', function() {
                checkValue();
            }).on('keyup', function() {
                checkValue();
            }).on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const buttonSubmit = $('#submitBtn');
                buttonSubmit.attr('disabled', true);
                buttonSubmit.html('Loading...');
                $.ajax({
                    url: "{{ route('page.type_page.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(res) {
                        buttonSubmit.attr('disabled', false).html('Simpan');
                        $('#modalInput').modal('hide');
                        table.draw();
                        Swal.fire(`Berhasil disimpan`, res.message, "success");
                    },
                    error: function(err) {
                        buttonSubmit.attr('disabled', false).html('Simpan');
                        Swal.fire(`Gagal`, err.responseJSON.message, "danger");
                    }
                });
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

                if (name == '' || status == '') {
                    submitBtn.attr('disabled', true);
                } else {
                    submitBtn.attr('disabled', false);
                }
            }
        })
    </script>
    @endpush
</x-app-layout>

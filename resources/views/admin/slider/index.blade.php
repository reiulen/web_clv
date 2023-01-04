<x-app-layout title="Fasilitas">
    <x-content_header>
        <div class="col-sm-6">
            <h4>Fasilitas</h4>
        </div>

        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item item">{{ __('Fasilitas') }}</li>
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
                                    <th>Nama</th>
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
                <h5 class="modal-title" id="exampleModalLabel">Input Fasilitas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="submitInput">
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="name">Nama</label>
                        <input type="text"
                                class="form-control"
                                id="name"
                                name="name">
                    </div>
                    <div class="form-group mb-3">
                        <label for="description">Deskripsi</label>
                        <textarea class="form-control"
                            id="description"
                            name="description"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="link">Link</label>
                        <input type="text"
                                class="form-control"
                                id="link"
                                name="link">
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <div id="image-preview" class="image-preview sm p-2">
                            <div class="gallery gallery-sm">
                                <div class="gallery-item img-preview sm" id="foto">
                                    <label for="image-upload">Pilih Gambar</label>
                                    <input type="file" class="fotoDetail" name="foto">
                                </div>
                            </div>
                        </div>
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
    <script src="{{ asset('assets/dist/js/gallery.js') }}"></script>
    <script src="{{ asset('assets/dist/js/pages/slider/index.js') }}"></script>
    @endpush
</x-app-layout>

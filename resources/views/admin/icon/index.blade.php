<x-app-layout title="Icon">
    <x-content_header>
        <div class="col-sm-6">
            <h4>Icon</h4>
        </div>

        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item item">{{ __('Icon') }}</li>
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
                                <tr>
                                    <th></th>
                                    <th>
                                        <div class="row" style="gap: 6px;">
                                            <div class="col-sm-3">
                                                <input class="form-control" placeholder="Cari nama" name="name" id="filterName" type="text">
                                            </div>
                                            <div class="col-sm-3">
                                                <input class="form-control" placeholder="Cari icon" name="icon" id="filterIcon" type="text">
                                            </div>
                                            <div class="col-sm-2">
                                                <input class="form-control" name="date" type="date" id="filterDate">
                                            </div>
                                            <div class="col-sm-2">
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
                <h5 class="modal-title" id="exampleModalLabel">Input Icon</h5>
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
                        <label for="icon">Icon</label>
                        <input type="text"
                                class="form-control"
                                id="icon"
                                name="icon">
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
                    <div class="form-group mb-2">
                        <a href="https://fontawesome.com/v5/icons/" target="_blank">
                            Lihat format icon
                        </a>
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
    <script src="{{ asset('assets/dist/js/pages/icons/index.js') }}"></script>
    @endpush
</x-app-layout>

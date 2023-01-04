<x-app-layout title="Produk">
    <x-content_header>
        <div class="col-sm-6">
            <h4>Produk</h4>
        </div>

        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item item">{{ __('Produk') }}</li>
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
                                    <a class="btn btn-primary border-0" href="{{ route('product.create') }}"><i class="fa fa-plus px-1"></i> Tambah</a>
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
                                    <th>Judul</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>
                                        <div class="row" style="gap: 6px;">
                                            <div class="col-sm-4">
                                                <input class="form-control" placeholder="Cari judul" name="title" type="text">
                                            </div>
                                            <div class="col-sm-3">
                                                <input class="form-control" name="date" type="date">
                                            </div>
                                            <div class="col-sm-3">
                                                <select class="form-control" name="status" id="status">
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


    @include('lib.datatable')
    @push('script')
    <script src="{{ asset('assets/dist/js/pages/product/index.js') }}"></script>
    @endpush
</x-app-layout>

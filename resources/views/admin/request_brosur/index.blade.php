<x-app-layout title="Request Brosur">
    <x-content_header>
        <div class="col-sm-6">
            @if (isset($product))
                <a href="{{ route('product.index') }}"
                    class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
                @else
                <h4>Request Brosur</h4>
            @endif
        </div>

        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item item">{{ __('Request Brosur') }}</li>
        </x-breadcrumb>
    </x-content_header>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered  table-hover">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No Whatsapp</th>
                                    <th>Dikirim pada</th>
                                    <th>Product</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>
                                        <input class="form-control" placeholder="Cari nama" name="name" type="text">
                                    </th>
                                    <th>
                                        <input class="form-control" placeholder="Cari email" name="email" type="text">
                                    </th>
                                    <th>
                                        <input class="form-control" placeholder="Cari no whatsapp" name="phone" type="text">
                                    </th>
                                    <th>
                                        <input class="form-control" placeholder="Cari no whatsapp" name="created_at" type="date">
                                    </th>
                                    <th></th>
                                    <th></th>
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
    <script>
        const product = "{{ request('product') }}";
    </script>
    <script src="{{ asset('assets/dist/js/pages/request-brosur/index.js') }}"></script>
    @endpush
</x-app-layout>

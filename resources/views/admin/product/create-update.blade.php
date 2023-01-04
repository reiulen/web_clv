<x-app-layout title="{{ isset($data) ? 'Edit' : 'Tambah' }} Produk">
    <x-content_header>
        <div class="col-sm-6">
            <h4>{{ isset($data) ? 'Edit' : 'Tambah' }} Produk</h4>
        </div>

        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item item">
                <a href="{{ route('product.index') }}">{{ __('Produk') }}</a>
            </li>
            <li class="breadcrumb-item item active">{{ __( (isset($data) ? 'Edit' : 'Tambah') . ' Produk') }}</li>
        </x-breadcrumb>
    </x-content_header>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form method="post" action="{{ isset($data) ? route('product.update', $data->id) : route('product.store') }}" enctype="multipart/form-data">
                @csrf
                @if (isset($data))
                    @method('PUT')
                @endif
                <div class="row">
                    <div class="col-12">
                        <x-jet-validation-errors/>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-outline">
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="name">
                                        Nama Produk
                                    </label>
                                    <input type="text"
                                        name="name"
                                        value="{{ old('name', ($data->name ?? '')) }}"
                                        class="form-control @error('name') is-invalid @enderror" id="name">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="type_product">
                                        Tipe Produk
                                    </label>
                                    <input type="text"
                                        name="type_product"
                                        value="{{ old('type_product', ($data->type_product ?? '')) }}"
                                        class="form-control @error('type_product') is-invalid @enderror" id="type_product">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="location">
                                        Lokasi
                                    </label>
                                    <input type="text"
                                        name="location"
                                        value="{{ old('location', ($data->location ?? '')) }}"
                                        class="form-control @error('location') is-invalid @enderror" id="location">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="description">
                                        Deskrpsi
                                    </label>
                                    <textarea class="form-control text-editor description @error('description') is-invalid @enderror" name="description" id="description">{{ old('description', ($data->description ?? '')) }}</textarea>
                                </div>
                                <div class="form-group mb-4">
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
                                        @foreach ($status as $key => $st)
                                            <option value="{{ $key }}" {{ $key == old('status', ($data->status ?? 0)) ? 'selected' : '' }}>{{ $st }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="">
                                    <button class="btn btn-primary">
                                        <i class="fa fa-save"></i>
                                        Simpan
                                    </button>
                                    <a href="{{ route('product.index') }}" class="btn btn-danger">
                                        <i class="fa fa-times"></i>
                                        Batal
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            {{-- <div class="col-12">
                                <div class="card card-outline">
                                    <div class="card-body">
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
                                                @foreach ($status as $key => $st)
                                                    <option value="{{ $key }}" {{ $key == old('status', ($data->status ?? 0)) ? 'selected' : '' }}>{{ $st }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <div class="card card-outline">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="foto">Foto</label>
                                            <div id="image-preview" class="image-preview sm p-2">
                                                <div class="gallery gallery-sm">
                                                    <div class="gallery-item img-preview sm" id="foto" style="background-image: url('{{ asset($data->foto ?? '') }}');">
                                                        @if (isset($data->foto))
                                                            <button type="button" class="btn btn-danger float-right btn-remove-image" data-key="foto">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                            @else
                                                            <label for="image-upload">Pilih Gambar</label>
                                                            <input type="file" name="foto">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            Summary Detail
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" name="summaryDetail" id="summaryDetail" value="{{ $summaryProduct ?? old('summaryDetail') }}">
                                        <div role="button"
                                            class="btn btn-primary btn-sm border-0"
                                            data-toggle="modal"
                                            data-target="#modalSummaryDetail">
                                            <i class="fa fa-plus px-1"></i> Tambah
                                        </div>
                                        <div class="mt-4">
                                            <table class="table" id="summary">
                                                <thead>
                                                    <tr>
                                                        <th>Nama</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            Detail
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" name="detailProduct" id="detailProduct" value="{{ $detailProduct ?? old('detailProduct') }}">
                                        <div role="button"
                                            class="btn btn-primary btn-sm border-0"
                                            data-toggle="modal"
                                            data-target="#modalDetailProduct">
                                            <i class="fa fa-plus px-1"></i> Tambah
                                        </div>
                                        <div class="mt-4">
                                            <table class="table" id="productDetail">
                                                <thead>
                                                    <tr>
                                                        <th>Nama</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->

    @push('modals')
    <div class="modal fade" id="modalSummaryDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Summary Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="submitInputSummary">
                @if (isset($data))
                <input type="hidden" name="product_id" value="{{ $data->id }}">
                @endif
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="icon">
                            Icon
                        </label>
                        <select
                            class="form-control @error('icon') is-invalid @enderror"
                            name="icon"
                            id="icon">
                            <option value="">Pilih icon</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nameSummary">Nama</label>
                        <input type="text"
                                class="form-control"
                                id="nameSummary"
                                name="name">
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail">Detail</label>
                        <input type="text"
                                class="form-control"
                                id="detail"
                                name="detail">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button id="submitBtnSummary" disabled="true" class="btn btn-primary">Simpan</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDetailProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Detail Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="submitInputDetail">
                @if (isset($data))
                <input type="hidden" name="product_id" value="{{ $data->id }}">
                @endif
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="nameDetail">Nama</label>
                        <input type="text"
                                class="form-control"
                                id="nameDetail"
                                name="name">
                    </div>
                    <div class="form-group mb-3">
                        <label for="detailProductInput">Detail</label>
                        <textarea class="form-control text-editor description" name="detail" id="detailProductInput"></textarea>
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
                    <button id="submitBtnDetail" disabled="true" class="btn btn-primary">Simpan</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    @endpush

    @include('lib.summernote')
    @include('lib.datatable')
    @include('lib.select2')
    @push('script')
    <script>
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
            },
        });
        const target = '.description';
        const uploadUrl = '{{ route("uploadPhoto") }}';
        const deleteUrl = '{{ route("deletePhoto") }}';
        const heightRow = 250;
    </script>
    <script src="{{ asset('assets/dist/js/summernote-upload.js') }}"></script>
    <script src="{{ asset('assets/dist/js/gallery.js') }}"></script>
    <script src="{{ asset('assets/dist/js/pages/product/create-update.js') }}"></script>
    @endpush
</x-app-layout>

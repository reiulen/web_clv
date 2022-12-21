<x-app-layout title="Popup">
    <x-content_header>
        <div class="col-sm-6">
            <h4>{{ isset($data) ? 'Edit' : 'Tambah' }} Popup</h4>
        </div>

        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item item">
                <a href="{{ route('popup.index') }}">{{ __('Popup') }}</a>
            </li>
            <li class="breadcrumb-item item active">{{ __( (isset($data) ? 'Edit' : 'Tambah') . ' Popup') }}</li>
        </x-breadcrumb>
    </x-content_header>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form method="post" action="{{ isset($data) ? route('popup.update', $data->id) : route('popup.store') }}" enctype="multipart/form-data">
                @csrf
                @if (isset($data))
                    @method('PUT')
                @endif
                <div class="row">
                    <div class="col-12">
                        <x-jet-validation-errors/>
                    </div>
                    <div class="col-12">
                        <div class="card card-outline">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group mb-3">
                                            <label for="name">
                                                Nama Popup
                                            </label>
                                            <input type="text"
                                                name="name"
                                                value="{{ old('name', ($data->name ?? '')) }}"
                                                class="form-control @error('name') is-invalid @enderror" id="name">
                                        </div>
                                    </div>
                                    <div class="col-4">
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label for="type">
                                                Tipe Popup
                                            </label>
                                            @php
                                                $type = [
                                                    1 => 'Foto',
                                                    2 => 'Judul & Content',
                                                    3 => 'Judul, Content, Foto',
                                                ]
                                            @endphp
                                            <select class="form-control select2 @error('type') is-invalid @enderror" name="type" id="type">
                                                <option value="">Pilih Tipe Popup</option>
                                                @foreach ($type as $key => $st)
                                                    <option value="{{ $key }}" {{ $key == old('type', ($data->type ?? 0)) ? 'selected' : '' }}>{{ $st }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="image">Foto</label>
                                            <div id="image-preview" class="image-preview sm p-2">
                                                <div class="gallery gallery-sm">
                                                    <div class="gallery-item img-preview sm" id="image" style="background-image: url('{{ asset($data->image ?? '') }}');">
                                                        @if (isset($data->image))
                                                            <button type="button" class="btn btn-danger float-right btn-remove-image" data-key="image">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                            @else
                                                            <label for="image-upload">Pilih Gambar</label>
                                                            <input type="file" name="image">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="link">Link</label>
                                            <input type="text" id="link"
                                                    class="form-control"
                                                    value="{{ old('link', ($data->link ?? '')) }}"
                                                    name="link">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="title">
                                        Judul
                                    </label>
                                    <input type="text"
                                        name="title"
                                        value="{{ old('title', ($data->title ?? '')) }}"
                                        class="form-control @error('title') is-invalid @enderror" id="title">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="title">
                                        Konten
                                    </label>
                                    <textarea class="form-control text-editor @error('content') is-invalid @enderror" name="content" id="content">{{ old('content', ($data->content ?? '')) }}</textarea>
                                </div>
                                <div class="">
                                    <button class="btn btn-primary">
                                        <i class="fa fa-save"></i>
                                        Simpan
                                    </button>
                                    <a href="{{ route('popup.index') }}" class="btn btn-danger">
                                        <i class="fa fa-times"></i>
                                        Batal
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->

    @include('lib.summernote')
    @include('lib.select2')
    @push('script')
    <script>
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
            },
        });
        const target = '#content';
        const uploadUrl = '{{ route("uploadPhoto") }}';
        const deleteUrl = '{{ route("deletePhoto") }}';
        const heightRow = 200;
        $('.select2').select2();
    </script>
    <script src="{{ asset('assets/dist/js/summernote-upload.js') }}"></script>
    <script src="{{ asset('assets/dist/js/gallery.js') }}"></script>
    @endpush
</x-app-layout>

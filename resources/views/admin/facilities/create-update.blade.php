<x-app-layout title="Tambah Halaman">
    <x-content_header>
        <div class="col-sm-6">
            <h4>{{ isset($data) ? 'Edit' : 'Tambah' }} Halaman</h4>
        </div>

        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item item">
                <a href="{{ route('page.halaman.index') }}">{{ __('Halaman') }}</a>
            </li>
            <li class="breadcrumb-item item active">{{ __( (isset($data) ? 'Edit' : 'Tambah') . ' Halaman') }}</li>
        </x-breadcrumb>
    </x-content_header>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form method="post" action="{{ isset($data) ? route('page.halaman.update', $data->id) : route('page.halaman.store') }}" enctype="multipart/form-data">
                @csrf
                @if (isset($data))
                    @method('PUT')
                @endif
                <div class="row">
                    <div class="col-12">
                        <x-jet-validation-errors/>
                    </div>
                    <div class="col-md-9">
                        <div class="card card-outline">
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
                                    <a href="{{ route('page.halaman.index') }}" class="btn btn-danger">
                                        <i class="fa fa-times"></i>
                                        Batal
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-12">
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
                                        <div class="form-group col-12 mb-3">
                                            <label for="type_page_id">
                                                Tipe Halaman
                                            </label>
                                            <select class="form-control select2 @error('type_page_id') is-invalid @enderror" name="type_page_id" id="type_page_id">
                                                <option value="">Pilih tipe</option>
                                                @foreach ($type_page as $key => $st)
                                                    <option value="{{ $key }}" {{ $key == old('type_page_id', ($data->type_page_id ?? 0)) ? 'selected' : '' }}>{{ $st }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                            {{-- <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        SEO
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label for="tag">Tag</label>
                                            <input type="text" class="form-control"
                                                name="tag" id="tag">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="title_seo">Judul</label>
                                            <input type="text" class="form-control"
                                                name="title_seo" id="title_seo">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="description_seo">Deskripsi</label>
                                            <textarea name="description_seo" id="description_seo" style="width:100%" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="thumbnail">Thumbnail</label>
                                            <div id="image-preview" class="image-preview sm p-2">
                                                <div class="gallery gallery-sm">
                                                    <div class="gallery-item img-preview sm" id="thumbnail" style="background-image: url('{{ asset($data->thumbnail ?? '') }}');">
                                                        @if (isset($data->thumbnail))
                                                            <button type="button" class="btn btn-danger float-right btn-remove-image" data-key="thumbnail">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                            @else
                                                            <label for="image-upload">Pilih Gambar</label>
                                                            <input type="file" name="thumbnail">
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
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="link_youtube">Tautan Youtube</label>
                                            <input type="text" id="link_youtube"
                                                    class="form-control"
                                                    value="{{ old('link_youtube', ($data->link_youtube ?? '')) }}"
                                                    name="link_youtube">
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
        const heightRow = 400;
        $('.select2').select2();
    </script>
    <script src="{{ asset('assets/dist/js/summernote-upload.js') }}"></script>
    <script src="{{ asset('assets/dist/js/gallery.js') }}"></script>
    @endpush
</x-app-layout>

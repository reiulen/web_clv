<x-app-layout title="Setting">
    <x-content_header>
        <div class="col-sm-6">
            <h4>Setting</h4>
        </div>

        <x-breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item item">{{ __('Setting') }}</li>
        </x-breadcrumb>
    </x-content_header>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#situs" role="tab"
                                            aria-controls="home" aria-selected="true">Situs</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#contact" role="tab"
                                            aria-controls="contact" aria-selected="false">Contact</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-9">
                                <form action="{{ route('setting.store') }}" method="post" id="form-setting" enctype="multipart/form-data">
                                @csrf
                                    <div class="tab-content" id="nav-tabContent">
                                        <div id="situs" class="tab-pane fade show active">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>Situs</h5>
                                                </div>
                                                <div class="card-body">
                                                    @include('admin.setting.situs')
                                                </div>
                                            </div>
                                        </div>
                                        <div id="contact" class="tab-pane">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>Contact</h5>
                                                </div>
                                                <div class="card-body">
                                                    @include('admin.setting.contact')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4 row ml-2">
                                        <button class="btn btn-primary btn-submit"><i class="fa fa-save"></i>&nbsp;Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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
    @include('lib.summernote')
    @push('script')
    <script src="{{ asset('assets/dist/js/pages/setting/create-update.js') }}"></script>
    <script src="{{ asset('assets/dist/js/gallery.js') }}"></script>
    <script>
        $(function() {
            $('[name="setting_chat_wa"]').each(function() {
                var link = $(this).val();
                var text = link;
                text = text.replace(/%0A/g, "\n");
                text = text.replace(/%20/g, " ");
                $(this).val(text);
            });
        });
    </script>

    @endpush
</x-app-layout>

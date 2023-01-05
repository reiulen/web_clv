<div class="form-group row mb-4">
    <label class="col-sm-3 col-form-label">Judul Situs</label>
    <div class="col-sm-9">
        <input type="text" name="title" value="{{ $setting->title ?? '' }}" class="form-control" />
    </div>
</div>
<div class="form-group row mb-4">
    <label class="col-sm-3 col-form-label">Keyword</label>
    <div class="col-sm-9">
        <input type="text" name="keyword" value="{{ $setting->keyword ?? '' }}" class="form-control" />
    </div>
</div>
<div class="form-group row mb-4">
    <label class="col-sm-3 col-form-label">Deskripsi</label>
    <div class="col-sm-9">
        <textarea class="form-control" name="description" rows="4">{{ $setting->description ?? '' }}</textarea>
    </div>
</div>
<div class="form-group row mb-4">
    <label class="col-sm-3 col-form-label">Popup</label>
    <div class="col-sm-9">
        <select id="selectPopup" name="popup_id" class="form-control">
            <option value="">Pilih popup</option>
        </select>
        <div class="form-check mt-2">
            <input class="form-check-input" name="is_popup" type="checkbox" value="1" id="is_popup"
                {{ ($setting->is_popup ?? 0) == 1 ? 'checked' : '' }}>
            <label class="form-check-label" for="is_popup">
                Tampilkan Popup
            </label>
        </div>
    </div>
</div>
<div class="form-group row mb-4">
    <label class="col-sm-3 col-form-label">Favicon</label>
    <div class="col-sm-4">
        <div id="image-preview" class="image-preview p-2">
            <div class="gallery gallery-lg">
                <div class="gallery-item img-preview" id="favicon"
                    style="background-image: url('{{ asset($setting->favicon ?? '') }}');">
                    <button type="button" class="btn btn-danger float-right btn-remove-image" data-key="favicon">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group row mb-4">
    <label class="col-sm-3 col-form-label">Logo</label>
    <div class="col-sm-4">
        <div id="image-preview" class="image-preview p-2">
            <div class="gallery gallery-lg">
                <div class="gallery-item img-preview" id="logo"
                    style="background-image: url('{{ asset($setting->logo ?? '') }}');">
                    <button type="button" class="btn btn-danger float-right btn-remove-image" data-key="logo">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-sm-3 col-form-label">Bakground Header</label>
    <div class="col-sm-4">
        <div id="image-preview" class="image-preview p-2">
            <div class="gallery gallery-lg">
                <div class="gallery-item img-preview" id="background_header"
                    style="background-image: url('{{ asset($setting->background_header ?? '') }}');">
                    <button type="button" class="btn btn-danger float-right btn-remove-image"
                        data-key="background_header">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

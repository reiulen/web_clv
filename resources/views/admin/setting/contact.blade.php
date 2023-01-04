<div class="form-group row mb-4">
    <label class="col-sm-3 col-form-label">Nama Perusahaan</label>
    <div class="col-sm-9">
        <input type="text" name="corporate_name" value="{{ $setting->corporate_name ?? '' }}" class="form-control"/>
    </div>
</div>
<div class="form-group row mb-4">
    <label class="col-sm-3 col-form-label">Alamat</label>
    <div class="col-sm-9">
        <textarea class="form-control" name="address" rows="4">{{ $setting->address ?? '' }}</textarea>
    </div>
</div>
<div class="form-group row mb-4">
    <label class="col-sm-3 col-form-label">Link Maps</label>
    <div class="col-sm-9">
        <input type="text" name="link_maps" value="{{ $setting->link_maps ?? '' }}" class="form-control"/>
    </div>
</div>
<div class="form-group row mb-4">
    <label class="col-sm-3 col-form-label">Whatsapp</label>
    <div class="col-sm-9">
        <input type="text" name="whatsapp" value="{{ $setting->whatsapp ?? '' }}" class="form-control"/>
    </div>
</div>
<div class="form-group row mb-4">
    <label class="col-sm-3 col-form-label">No Telepon</label>
    <div class="col-sm-9">
        <input type="text" name="phone" value="{{ $setting->phone ?? '' }}" class="form-control"/>
    </div>
</div>
<div class="form-group row mb-4">
    <label class="col-sm-3 col-form-label">Email</label>
    <div class="col-sm-9">
        <input type="text" name="email" value="{{ $setting->email ?? '' }}" class="form-control"/>
    </div>
</div>
<div class="form-group row mb-4">
    <label class="col-sm-3 col-form-label">Pesan Chat Whatsapp</label>
    <div class="col-sm-9">
        <textarea class="form-control" name="setting_chat_wa" rows="4">{{ $setting->setting_chat_wa ?? '' }}</textarea>
    </div>
</div>

<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $setting = Setting::with('popup')
                            ->latest()
                            ->first();
        return view('admin.setting.index', compact('setting'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'favicon' => 'image|mimes:jpeg,png,jpg|max:2048',
            'background_header' => 'image|mimes:jpeg,png,jpg|max:2048',
            'logo' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $image = [
            'favicon',
            'background_header',
            'logo',
        ];

        $input = $request->all();
        $data = Setting::latest()->first() ?? new Setting;
        $setting_chat_wa = $request->setting_chat_wa;
        $setting_chat_wa = str_replace("\r\n", "%0A", $setting_chat_wa);
        $setting_chat_wa = str_replace(" ", "%20", $setting_chat_wa);
        $input['setting_chat_wa'] = $setting_chat_wa;
        $input['is_popup'] = $request->is_popup ? 1 : 0;

        foreach($image as $img) {
            if($request->hasFile($img)) {
                $input[$img] = upload_image($request->file($img), 'set', $img);
                if($data->$img)
                    File::delete($data->$img);
            }
        }

        $data->fill($input);
        $data->save();

        return redirect(route('setting.index'))
                        ->with('success', 'Data berhasil disimpan');
    }

    public function getData(Request $request)
    {
        $setting = Setting::with('popup')
                            ->latest()
                            ->first();
        return response()->json($setting);
    }
}

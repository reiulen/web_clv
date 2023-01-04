<?php


if (!function_exists('set_active')) {
    function set_active($url, $output = 'active')
    {
        if (is_array($url)) {
            foreach ($url as $u) {
                if (Route::is($u)) {
                    return $output;
                }
            }
        } else {
            if (Route::is($url)) {
                return $output;
            }
        }
    }
}

if (!function_exists('set_active_sub')) {
    function set_active_sub($url, $output = 'active-sub')
    {
        if (is_array($url)) {
            foreach ($url as $u) {
                if (Route::is($u)) {
                    return $output;
                }
            }
        } else {
            if (Route::is($url)) {
                return $output;
            }
        }
    }
}

if (!function_exists('set_menu_open')) {
    function set_menu_open($url, $output = 'menu-open')
    {
        if (is_array($url)) {
            foreach ($url as $u) {
                if (Route::is($u)) {
                    return $output;
                }
            }
        } else {
            if (Route::is($url)) {
                return $output;
            }
        }
    }
}

if(!function_exists('upload_image')){
    function upload_image($file, $path, $name, $width = null, $height = null){
        $file = $file;
        $filename = $name . time(). rand(1,9999) .'.' . $file->getClientOriginalExtension();
        $destinationPath = 'uploads/images/' . $path;

        if (!File::isDirectory($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true, true);
        }

        $image  = Image::make($file);

        if(isset($width) && isset($height)) {
            $image->fit($width, $height, function($contraint){
                $contraint->aspectRatio();
            });
        }

        $image->resize($width ?? 850, $height, function ($constraint) {
            $constraint->aspectRatio();
        });

        $image->save($destinationPath . '/' . $filename);

        return $destinationPath . '/' . $filename;
    }
}


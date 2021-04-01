<?php

namespace App\Http\Controllers\Helpers;

trait ImageTool
{
    private static $default_cover = 'images/default_cover.png';
    private static $default_avatar = 'images/default_avatar.png';

    public function getAbsoluteImagePath(string $path):string
    {
        if (strpos($path, 'http') === false){
            return config('app.image_path').$path;
        }
        return $path;
    }

    public function handleCoverImg(string $path = null):string
    {
        if ($path){
            return 'storage/'.$path;
        }else{
            return self::$default_cover;
        }
    }

    public function handleAvatarImg(string $path = null):string
    {
        if ($path && strpos($path, 'http') === false){
            return 'storage/'.$path;
        }elseif(!$path){
            return self::$default_avatar;
        }
        return $path;
    }
}

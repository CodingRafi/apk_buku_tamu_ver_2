<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuTamu extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function create_image($img){
        $folderPath = "storage/";
        $image_parts = explode(";base64,", $img);
        foreach ($image_parts as $key => $image){
            $image_base64 = base64_decode($image);
        }
        $fileName = uniqid() . '.png';
        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);

        return $fileName;
    }

    public static function create_sinature($signed){
        $folderPath2 = "tandaTangan/";
        $img_parts =  explode(";base64,", $signed);
        $img_type_aux = explode("image/", $img_parts[0]);
        $img_type = $img_type_aux[1];
        $img_base64 = base64_decode($img_parts[1]);
        $namaTandaTangan =   uniqid() . '.'.$img_type;
        $file = $folderPath2 . $namaTandaTangan;
        file_put_contents($file, $img_base64);

        return $namaTandaTangan;
    }
}

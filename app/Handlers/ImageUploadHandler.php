<?php

namespace App\Handlers;

class ImageUploadHandler
{
    //定义允许上传图片的扩展名
    protected $allowed_ext = ["png", "jpg", "gif", "jpeg"];

    public function save($file, $folder, $file_prefix)
    {
        //构建图片存储文件夹
        $folder_name = "uploads/images/$folder/" . date("Ym/d", time());

        //拼接图片存储物理路径
        $upload_path = public_path() . '/' . $folder_name;

        //获取图片后缀名
        $extension = strtolower($file->getClientOriginalExtension()) ? : 'png';

        //拼接图片名
        $filename = $file_prefix . '_' . time() . '_' . str_random(10) . '.' . $extension;

        //如果不是允许的扩展名将阻止上传
        if( ! in_array($extension, $this->allowed_ext)){
            return false;
        }

        //将图片移动到目标存储路径
        $file->move($upload_path, $filename);

        return [
            'path' => config('app.url') . "/$folder_name/$filename"
        ];
    }
}

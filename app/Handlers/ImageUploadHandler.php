<?php

namespace App\Handlers;

use Image;

class ImageUploadHandler
{
    //定义允许上传图片的扩展名
    protected $allowed_ext = ["png", "jpg", "gif", "jpeg"];

    public function save($file, $folder, $file_prefix, $max_width = false)
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

        //如果限制了图片宽度就进行裁剪
        if ($max_width && $extension != 'gif') {
            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }

        return [
            'path' => config('app.url') . "/$folder_name/$filename"
        ];
    }

    public function reduceSize($file_path, $max_width)
    {
        //先实例化，传参是图片的磁盘物理路径
        $image = Image::make($file_path);

        //进行大小调整操作
        $image->resize($max_width, null, function ($constraint) {

            //设定宽度是 $max_width, 高度等比例收缩
            $constraint->aspectRatio();

            //防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        //保存修剪后的图片
        $image->save();
    }
}

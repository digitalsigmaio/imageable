<?php
/**
 * Created by PhpStorm.
 * User: Manson
 * Date: 6/27/2018
 * Time: 2:54 PM
 */
namespace Digitalsigma\ImageUpload\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait ImageUpload {
    /**
     * @param UploadedFile $img
     * @return void
     */
    private $imgPath = 'public/img';

    public function uploadImage(UploadedFile $img) : void
    {
        $filename = $img->store($this->imgPath);
        $this->img_path = $filename;
        $this->img = Storage::url($filename);
    }

    public function deleteImage()
    {
        if($this->img_path !== null) {
            Storage::delete($this->img_path);
        }
    }
}
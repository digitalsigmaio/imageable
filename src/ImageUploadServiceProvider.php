<?php
/**
 * Created by PhpStorm.
 * User: Manson
 * Date: 11/26/2018
 * Time: 3:58 PM
 */
namespace Digitalsigma\ImageUploader;


use Illuminate\Support\ServiceProvider;

class ImageUploadServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . './config/filesystems.php', 'filesystems'
        );
    }
}
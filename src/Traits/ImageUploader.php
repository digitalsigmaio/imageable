<?php
/**
 * User: Manson
 * Date: 6/27/2018
 * Time: 2:54 PM
 * Update: 3/14/2019
 */

namespace Digitalsigma\ImageUploader\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait ImageUploader
{
    public $imagePath = 'img';

    /**
     * Stores image in storage/app/public/img
     * and returns hashed file name
     *
     * @param UploadedFile $file
     * @param string $format
     *
     * @return string
     */
    public function uploadImage( UploadedFile $file, string $format = null ): string
    {
        return $this->optimizeImage( $file, $format );
    }

    /**
     * Replace an existing image with a new one
     * and return the file name of the new image
     *
     * @param UploadedFile $file
     * @param string $oldFileName
     *
     * @return string
     */
    public function updateImage( UploadedFile $file, string $oldFileName ): string
    {
        if ( Storage::disk( config( 'filesystems.default' ) )->exists( $oldFileName ) ) {
            if ( $this->deleteImage( $oldFileName ) ) {
                return $this->uploadImage( $file );
            }
            return null;
        }
        return null;
    }

    /**
     * Delete image from storage/app/public/img
     *
     * @param string $fileName
     *
     * @return bool
     */
    public function deleteImage( string $fileName ): bool
    {
        if ( Storage::disk( config( 'filesystems.default' ) )->exists( $fileName ) ) {
            return Storage::delete( $fileName );
        }
        return false;
    }

    /**
     * Return an http response with the raw file
     *
     * @param string $fileName
     *
     * @return mixed
     */
    public function downloadImage( string $fileName )
    {
        return Storage::download( $fileName );
    }

    /**
     * Get the full image url
     *
     * @param string $fileName
     *
     * @return string
     */
    public function getImageUrl( ?string $fileName ): string
    {
        return $fileName ? Storage::url( $fileName ) : '';
    }

    /**
     * Optimize image size and optionally formatting it
     *
     * @param UploadedFile $file
     * @param string|null $format
     *
     * @return string
     */
    protected function optimizeImage( UploadedFile $file, ?string $format ): string
    {
        $extension = $format ?? $file->getClientOriginalExtension();
        return $this->storeImage( Image::make( $file->getRealPath() )->encode( $extension ), $extension );
    }

    /**
     * @param $image
     * @param string $extension
     *
     * @return string
     */
    protected function storeImage( $image, $extension ): string
    {
        $optimizedName = Str::random( 40 ) . '.' . $extension;
        $path = storage_path( 'app/public/' . $this->imagePath . '/' . $optimizedName );
        $image->save( $path );
        return $this->imagePath . '/' . $optimizedName;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Manson
 * Date: 11/26/2018
 * Time: 3:58 PM
 */
namespace Digitalsigma\Imageable;


use Illuminate\Support\ServiceProvider;

class ImageableServiceProvider extends ServiceProvider
{
    public function register()
    {
        $ds = DIRECTORY_SEPARATOR;
        $this->mergeConfigFrom(
            __DIR__."{$ds}config{$ds}imageable.php", 'imageable'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $ds = DIRECTORY_SEPARATOR;
        $this->publishes([
            __DIR__."{$ds}config{$ds}imageable.php" => config_path('imageable.php'),
        ], 'config');
    }
}
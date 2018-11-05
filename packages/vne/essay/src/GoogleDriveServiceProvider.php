<?php
namespace Vne\Essay;
use Illuminate\Support\ServiceProvider;
class GoogleDriveServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \Storage::extend('google', function($app, $config) {
            $config['accessToken'] 
            = 'ya29.GltLBsO9tI_mGblSrhbLdbg103gh7sRly_6TAOhRwxRQwSi5YMlHK26G2VQhOyXWYmF3JKYIUsfi3rFbSNAFp2v3hTFlH9deCAJqaHeD3Vm5Whtx4gyBfss4GjdN';
            $client = new \Google_Client();
            $client->setClientId($config['clientId']);
            $client->setClientSecret($config['clientSecret']);
            $client->setAccessToken($config['accessToken']);
            $client->refreshToken($config['refreshToken']);
            $service = new \Google_Service_Drive($client);
            $adapter = new \Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter($service, $config['folderId']);
            return new \League\Flysystem\Filesystem($adapter);
        });
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
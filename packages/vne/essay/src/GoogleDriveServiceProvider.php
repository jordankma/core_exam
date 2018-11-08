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
            = 'ya29.GltOBmt6zekzMKPGJZOymQh9Hoz0yxLZrUWup_JZ7wrXXtrcNob-XeRMtFFcyVW6mIu12vb3XjJKLozEykQKIy1M_AHLMw10ptm94Mr7MBYm4MF2ROK29HXkipY9';
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
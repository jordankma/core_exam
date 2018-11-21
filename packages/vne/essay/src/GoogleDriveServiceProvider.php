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
            // $config['accessToken'] 
            // = 'ya29.GltPBrvp0w7EgB6V5dENBv41kmUlbQA1ZmTF-mJwisGRitnlXnQe851ivCfC22f6X8WgiRHqf_xuF-9xZUk_lKfRED0Vqy_UPbNg3NCu--gaZxITep1WWSNK6OIA';
            // dd($config);
            $client = new \Google_Client();
            $client->setClientId($config['clientId']);
            $client->setClientSecret($config['clientSecret']);
            // $client->setAccessToken($config['accessToken']);
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
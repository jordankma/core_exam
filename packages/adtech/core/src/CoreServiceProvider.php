<?php

namespace Adtech\Core;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
use Validator;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $vendor = 'adtech';

    /**
     * @var string
     */
    protected $package = 'core';

    protected $namespace = __NAMESPACE__ . '\App\Http\Controllers';

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $routesDir = __DIR__ . '/routes';
        $ls = @scandir($routesDir);
        if ($ls) {
            foreach ($ls as $index => $routeFile) {
                switch (substr($routeFile, 0, -4)) {
                    case 'web':
                        Route::middleware('web')
                            ->namespace($this->namespace)
                            ->group(__DIR__ . '/routes/web.php');
                    case 'api':
                        Route::prefix('api')
                            ->middleware('api')
                            ->namespace($this->namespace)
                            ->group(__DIR__ . '/routes/api.php');
                        break;
                }
            }
        }

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        /** load views **/
        $groupName = config('site.group_name');
        $groupName = $groupName ? $groupName : 'default';
        $desktopTemplate = config('site.desktop.template');
        $desktopTemplate = $desktopTemplate ? $desktopTemplate : 'default';
        $templateName = $groupName . '/' . $desktopTemplate;
//        $this->app['view']->addLocation(realpath(__DIR__ . '/views/' . $templateName . '/views'));
        $this->loadViewsFrom(__DIR__ . '/views/' . $templateName . '/views', strtoupper($this->vendor . '-' . $this->package));

        /** publishes **/
        $skin = config('site.desktop.skin');
        $skin = $skin ? $skin : 'default';
        $this->publishes([
        __DIR__ . '/views/' . $groupName . '/' . $skin . '/public' => public_path('vendor/' . $groupName . '/' . $skin),
        ], 'core_public');

        /** load translations **/
        $this->loadTranslationsFrom(__DIR__ . '/translations', $this->vendor . '-' . $this->package);

        $this->app['router']->middlewareGroup('adtech.locale', ['\Adtech\Core\App\Middleware\LocaleMiddleware']);
        $this->app['router']->middlewareGroup('adtech.auth', ['\Adtech\Core\App\Middleware\AuthMiddleware']);
        $this->app['router']->middlewareGroup('adtech.acl', ['\Adtech\Core\App\Middleware\AclMiddleware']);
//        $this->app['router']->middlewareGroup('adtech.cors', ['\Adtech\Core\App\Middleware\CorsMiddleware']);

        Validator::extend('recaptcha', function ($attribute, $value, $parameters, $validator){
            $client = new Client();
            $response = $client->post(
                'https://www.google.com/recaptcha/api/siteverify',
                ['form_params'=>
                    [
                        'secret'=>env('GOOGLE_RECAPTCHA_SECRET'),
                        'response'=>$value
                    ]
                ]
            );
            $body = json_decode((string)$response->getBody());
            return $body->success;
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}

<?php

//$modulesConfig = [];
//$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null;
//if ($host) {
//    $newString = 'adtech.api,core';
//    $variable = 'APP_MODULES_' . strtoupper(str_replace('.', '_', $host));
//    $path = base_path('.env');
//    if (file_exists($path)) {
//        if (strpos(file_get_contents($path), $variable . '=') > 0) {
//            $appModules = (env($variable) != '') ? env($variable) : $newString;
//            $packagesList = explode('_', $appModules);
//            if (count($packagesList) > 0) {
//                if (!in_array($newString, $packagesList))
//                    array_unshift($packagesList, $newString);
//                foreach ($packagesList as $packages) {
//                    $modules = explode('.', $packages);
//                    $modulesConfig[$modules[0]] = explode(',', $modules[1]);
//                }
//            }
//        } else {
//            file_put_contents($path, file_get_contents($path) . "\r\n" . $variable . '=' . $newString);
//            header("Refresh:0");
//        }
//    }
//}
$modulesConfig = [];
$modules = '{"adtech":["core"]}';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null;
if ($host) {
    $variable = 'APP_MODULES_' . strtoupper(str_replace('.', '_', $host));
    $path = base_path('modules/' . $variable . '.json');
    if (file_exists($path)) {
        $modules = file_get_contents($path);
    }
}
$modulesConfig = json_decode($modules, true);
krsort($modulesConfig);
return [
    'version' => '1.0.0',
    /*
    |--------------------------------------------------------------------------
    | Google Recaptcha
    |--------------------------------------------------------------------------
    */
    'google_recaptcha' => [
        'site_key' => '6LcOqQ4TAAAAABtzBkFsBf9RoqXtKICQ9bqoEPKf',
        'secret' => '6LcOqQ4TAAAAAN4uiSDcki1-v9IGsc-U4tS1i3go',
    ],

    /*
    |--------------------------------------------------------------------------
    | Exception class
    |--------------------------------------------------------------------------
    */
    'exception_handler' => '\Adtech\Application\Cms\Exceptions\Handler',

    /*
    |--------------------------------------------------------------------------
    | Config user activation
    |--------------------------------------------------------------------------
    */
    'user_activation' => true,

    /*
    |--------------------------------------------------------------------------
    | Website backend url
    |--------------------------------------------------------------------------
    */
    'url_storage' => 'http://exam.local.vn',
    'url_static' => 'http://exam.local.vn',
    'api_prefix' => '/resource/dev/get',
    'admin_prefix' => '/admin',
    'homepage' => [
        'frontend' => [
            'method' => 'get',
            'uri' => '/',
            'middleware' => [],
            'action' => 'Adtech\Core\App\Http\Controllers\DashboardController@frontend',
        ],
        'backend' => [
            'method' => 'get',
            'uri' => '/',
            'middleware' => [],
            'action' => 'Adtech\Core\App\Http\Controllers\DashboardController@backend',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Website template
    |--------------------------------------------------------------------------
    */
    'group_name' => 'vnedutech-cms',
    'angular_js' => true,
    'desktop' => [
        'template' => 'default',
        'skin' => 'default'
    ],
    'mobile' => [
        'template' => 'default',
        'skin' => 'default'
    ],
    'modules' => $modulesConfig,
//    'modules' => [
//        /**
//         * vendor => [packages or modules]
//         * example: 'adtech' => ['core', 'blog']
//         */
//        'adtech' => ['core']
//    ],
    'firebase' => [
        'domain' => '',
        'app_key' => '',
        'url_message' => '',
    ],
    'news_box' => [
        'thongbaobtc' => 'thongbaobtc',
        'biendaovietnamtailieuthamkhaochocuocthi' => 'biendaovietnamtailieuthamkhaochocuocthi',
        'videonoibat' => 'videonoibat',
        'tintucchung' => 'tintucchung'
    ],
    'news_cat' => [
        'thongbaobtc' => 'thong-bao-btc',
        'biendaovietnamtailieuthamkhaochocuocthi' => 'bien-dao-viet-nam-tai-lieu-tham-khao-cho-cuoc-thi',
        'videonoibat' => 'videonoibat',
        'tintucchung' => 'tintucchung'
    ],
    'city_id_default' => 62,
    'table_a_id' => 1,
    'table_b_id' => 2
];

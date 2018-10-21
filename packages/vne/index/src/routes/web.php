<?php
$adminPrefix = '';
// use Illuminate\Support\Facades\Cache
//$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {

    Route::get('/', 'IndexController@index')->name('index')->where('as','Trang chủ');
    // Route::get('/clear-cache', function(){
    // 	shell_exec('php artisan config:cache');
	   //  shell_exec('php artisan config:clear');
	   //  shell_exec('php artisan view:clear');
	   //  Cache::flush();
    // });
    Route::get('tin-tuc-box/{alias?}', 'IndexController@getNewByBox')->name('vne.index.news.box');

    Route::group(['middleware' => ['register']], function () {
    	Route::get('thi-thu', 'IndexController@getTryExam')->name('vne.index.try.exam');
        Route::get('thi-that', 'IndexController@getRealExam')->name('vne.index.real.exam');
    });
});
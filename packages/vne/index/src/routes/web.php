<?php
$adminPrefix = '';
//$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {

    Route::get('/', 'IndexController@index')->name('index')->where('as','Trang chủ');
    Route::get('tin-tuc-box/{alias?}', 'IndexController@getNewByBox')->name('vne.index.news.box');
});
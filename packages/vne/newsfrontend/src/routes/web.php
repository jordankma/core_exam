<?php
$adminPrefix = '';
//$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::get('tin-tuc/{alias?}', 'NewsfrontendController@list')->name('vne.newsfrontend.news.list')
    ->where('as','Tin tức - frontend')
    ->where('type','news')
    ->where('view','list');

    Route::get('vi-tri/{alias?}', 'NewsfrontendController@listBox')->name('vne.newsfrontend.news.list.box');

    Route::get('chi-tiet/{alias}.html', 'NewsfrontendController@detail')->name('vne.newsfrontend.news.detail')
    ->where('type','news')
    ->where('view','detail')
    ->where('as','Tin tức - Chi tiết');
});
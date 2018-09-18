<?php
$adminPrefix = '';
//$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::get('tin-tuc/{alias?}', 'NewsfrontendController@list')->name('vne.newsfrontend.news.list')->where('as','Tin tức - frontend');

    Route::get('chi-tiet/{alias}_{news_id}.html', 'NewsfrontendController@detail')->name('vne.newsfrontend.news.detail');
});
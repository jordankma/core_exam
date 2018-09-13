<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::group(array('prefix' => 'vne/banner/banner'), function() {
            Route::get('log', 'BannerController@log')->name('vne.banner.banner.log');
            Route::get('data', 'BannerController@data')->name('vne.banner.banner.data');
            Route::get('manage', 'BannerController@manage')->name('vne.banner.banner.manage')->where('as','Banner - Danh sách');
            Route::get('create', 'BannerController@create')->name('vne.banner.banner.create');
            Route::post('add', 'BannerController@add')->name('vne.banner.banner.add');
            Route::get('show', 'BannerController@show')->name('vne.banner.banner.show');
            Route::post('update', 'BannerController@update')->name('vne.banner.banner.update');
            Route::get('delete', 'BannerController@delete')->name('vne.banner.banner.delete');
            Route::get('confirm-delete', 'BannerController@getModalDelete')->name('vne.banner.banner.confirm-delete');

        });

        Route::group(array('prefix' => 'vne/banner/position'), function() {
            Route::get('log', 'PositionController@log')->name('vne.banner.position.log');
            Route::get('data', 'PositionController@data')->name('vne.banner.position.data');
            Route::get('manage', 'PositionController@manage')->name('vne.banner.position.manage')->where('as','Banner - Vị trí');
            Route::get('create', 'PositionController@create')->name('vne.banner.position.create');
            Route::post('add', 'PositionController@add')->name('vne.banner.position.add');
            Route::get('show', 'PositionController@show')->name('vne.banner.position.show');
            Route::post('update', 'PositionController@update')->name('vne.banner.position.update');
            Route::get('delete', 'PositionController@delete')->name('vne.banner.position.delete');
            Route::get('confirm-delete', 'PositionController@getModalDelete')->name('vne.banner.position.confirm-delete');
        });
    });
});
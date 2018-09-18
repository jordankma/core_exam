<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {
        Route::group(array('prefix' => 'vne/news/news'), function() {
            Route::get('log', 'NewsController@log')->name('vne.news.news.log');
            Route::get('data', 'NewsController@data')->name('vne.news.news.data');
            Route::get('manager', 'NewsController@manager')->name('vne.news.news.manager')->where('as','Tin tức - Danh sách');
            Route::get('create', 'NewsController@create')->name('vne.news.news.create');
            Route::post('add', 'NewsController@add')->name('vne.news.news.add');
            Route::get('show/{news_id}', 'NewsController@show')->where('news_id', '[0-9]+')->name('vne.news.news.show');
            Route::post('update/{news_id}', 'NewsController@update')->where('news_id', '[0-9]+')->name('vne.news.news.update');
            Route::get('delete', 'NewsController@delete')->name('vne.news.news.delete');
            Route::get('confirm-delete', 'NewsController@getModalDelete')->name('vne.news.news.confirm-delete');

            Route::get('alias', 'NewsController@alias')->name('vne.news.news.alias');
        });
        //route news cat
        Route::group(array('prefix' => 'vne/news/cat'), function() {
            Route::get('log', 'NewsCatController@log')->name('vne.news.cat.log');
            Route::get('data', 'NewsCatController@data')->name('vne.news.cat.data');
            Route::get('manager', 'NewsCatController@manager')->name('vne.news.cat.manager')->where('as','Tin tức - Danh mục');
            Route::get('create', 'NewsCatController@create')->name('vne.news.cat.create');
            Route::post('add', 'NewsCatController@add')->name('vne.news.cat.add');
            Route::get('show', 'NewsCatController@show')->where('news_cat_id', '[0-9]+')->name('vne.news.cat.show');
            Route::post('update', 'NewsCatController@update')->where('news_cat_id', '[0-9]+')->name('vne.news.cat.update');
            Route::get('delete', 'NewsCatController@delete')->name('vne.news.cat.delete');
            Route::get('confirm-delete', 'NewsCatController@getModalDelete')->name('vne.news.cat.confirm-delete');

            Route::get('api/list', 'NewsCatController@getCateApi')->name('vne.api.news.category');
        });

        //route new tag 
        Route::group(array('prefix' => 'vne/news/tag'), function() {
            Route::get('log', 'NewsTagController@log')->name('vne.news.tag.log');
            Route::get('data', 'NewsTagController@data')->name('vne.news.tag.data');
            Route::get('manager', 'NewsTagController@manager')->name('vne.news.tag.manager')->where('as','Tin tức - Tag');
            Route::get('create', 'NewsTagController@create')->name('vne.news.tag.create');
            Route::post('add', 'NewsTagController@add')->name('vne.news.tag.add');
            Route::get('show', 'NewsTagController@show')->where('news_id', '[0-9]+')->name('vne.news.tag.show');
            Route::post('update', 'NewsTagController@update')->where('news_id', '[0-9]+')->name('vne.news.tag.update');
            Route::get('delete', 'NewsTagController@delete')->name('vne.news.tag.delete');
            Route::get('confirm-delete', 'NewsTagController@getModalDelete')->name('vne.news.tag.confirm-delete');

            Route::post('ajax/add', 'NewsTagController@addAjax')->name('vne.news.tag.ajax.add');
        });

        //route new box 
        Route::group(array('prefix' => 'vne/news/box'), function() {
            Route::get('log', 'NewsBoxController@log')->name('vne.news.box.log');
            Route::get('data', 'NewsBoxController@data')->name('vne.news.box.data');
            Route::get('manager', 'NewsBoxController@manager')->name('vne.news.box.manager')->where('as','Tin tức - box');
            Route::get('create', 'NewsBoxController@create')->name('vne.news.box.create');
            Route::post('add', 'NewsBoxController@add')->name('vne.news.box.add');
            Route::get('show', 'NewsBoxController@show')->where('news_id', '[0-9]+')->name('vne.news.box.show');
            Route::post('update', 'NewsBoxController@update')->where('news_id', '[0-9]+')->name('vne.news.box.update');
            Route::get('delete', 'NewsBoxController@delete')->name('vne.news.box.delete');
            Route::get('confirm-delete', 'NewsBoxController@getModalDelete')->name('vne.news.box.confirm-delete');

            Route::post('ajax/add', 'NewsBoxController@addAjax')->name('vne.news.box.ajax.add');
        });

        //page
        Route::group(array('prefix' => 'vne/news/page'), function() {
            Route::get('log', 'PageController@log')->name('vne.news.page.log');
            Route::get('data', 'PageController@data')->name('vne.news.page.data');
            Route::get('manager', 'PageController@manager')->name('vne.news.page.manager')->where('as','Trang tĩnh - Danh sách');
            Route::get('create', 'PageController@create')->name('vne.news.page.create');
            Route::post('add', 'PageController@add')->name('vne.news.page.add');
            Route::get('show', 'PageController@show')->where('news_id', '[0-9]+')->name('vne.news.page.show');
            Route::post('update', 'PageController@update')->where('news_id', '[0-9]+')->name('vne.news.page.update');
            Route::get('delete', 'PageController@delete')->name('vne.news.page.delete');
            Route::get('confirm-delete', 'PageController@getModalDelete')->name('vne.news.page.confirm-delete');
        });

    });
});

Route::group(array('prefix' => ''), function() {
    Route::group(['middleware' => []], function () {
        Route::get('frontend/news/category', function () { })->name('news.frontend.cate')
            ->where('type','news')
            ->where('view','list')
            ->where('as','Tin tức - Theo danh mục');

        Route::get('frontend/news/detail', function () { })->name('news.frontend.detail')
            ->where('type','news')
            ->where('view','detail')
            ->where('as','Tin tức - Chi tiết');
    });
});
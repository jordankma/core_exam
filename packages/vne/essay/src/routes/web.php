<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {
        Route::group(array('prefix' => 'vne/essay/essay'), function() {
            Route::get('log', 'EssayController@log')->name('vne.essay.essay.log');
            Route::get('data', 'EssayController@data')->name('vne.essay.essay.data');
            Route::get('manage', 'EssayController@manage')->name('vne.essay.essay.manage');
            Route::get('create', 'EssayController@create')->name('vne.essay.essay.create');
            Route::post('add', 'EssayController@add')->name('vne.essay.essay.add');
            Route::get('show', 'EssayController@show')->name('vne.essay.essay.show');
            Route::post('update', 'EssayController@update')->name('vne.essay.essay.update');
            Route::get('delete', 'EssayController@delete')->name('vne.essay.essay.delete');
            Route::get('confirm-delete', 'EssayController@getModalDelete')->name('vne.essay.essay.confirm-delete');

            
        }); 

        Route::group(array('prefix' => 'vne/essay/topic'), function() {
            Route::get('log', 'EssayTopicController@log')->name('vne.essay.topic.log');
            Route::get('data', 'EssayTopicController@data')->name('vne.essay.topic.data');
            Route::get('manage', 'EssayTopicController@manage')->name('vne.essay.topic.manage');
            Route::get('create', 'EssayTopicController@create')->name('vne.essay.topic.create');
            Route::post('add', 'EssayTopicController@add')->name('vne.essay.topic.add');
            Route::get('show', 'EssayTopicController@show')->name('vne.essay.topic.show');
            Route::post('update', 'EssayTopicController@update')->name('vne.essay.topic.update');
            Route::get('delete', 'EssayTopicController@delete')->name('vne.essay.topic.delete');
            Route::get('confirm-delete', 'EssayTopicController@getModalDelete')->name('vne.essay.topic.confirm-delete');

            Route::get('test-upload-gg', 'EssayTopicController@testUploadGG');
        });
    });
});
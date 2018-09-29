<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['prefix' => 'api/contest', 'as' => 'api.contest.'], function () {
        Route::post('get_list_data', 'ApiController@getListData')->name('get_list_data');
        Route::get('data', 'ApiController@data')->name('data');
    });
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::group(['prefix' => 'contest/contestmanage/contest', 'as' => 'contest.contestmanage.contest.'], function () {
            Route::get('log', 'ContestController@log')->name('log');
            Route::get('data', 'ContestController@data')->name('data');
            Route::get('manage', 'ContestController@manage')->where('as','Danh sách cuộc thi')->name('manage');
            Route::get('create', 'ContestController@create')->name('create');
            Route::post('add', 'ContestController@add')->name('add');
            Route::get('show', 'ContestController@show')->name('show');
            Route::put('update', 'ContestController@update')->name('update');
            Route::get('delete', 'ContestController@delete')->name('delete');
            Route::get('confirm-delete', 'ContestController@getModalDelete')->name('confirm-delete');
        });
        Route::group(['prefix' => 'contest/contestmanage/contest_season', 'as' => 'contest.contestmanage.contest_season.'], function () {
            Route::get('log', 'ContestSeasonController@log')->name('log');
            Route::get('data', 'ContestSeasonController@data')->name('data');
            Route::get('manage', 'ContestSeasonController@manage')->where('as','Danh sách mùa thi')->name('manage');
            Route::get('create', 'ContestSeasonController@create')->name('create');
            Route::post('add', 'ContestSeasonController@add')->name('add');
            Route::get('show', 'ContestSeasonController@show')->name('show');
            Route::put('update', 'ContestSeasonController@update')->name('update');
            Route::get('delete', 'ContestSeasonController@delete')->name('delete');
            Route::get('confirm-delete', 'ContestSeasonController@getModalDelete')->name('confirm-delete');
        });
        Route::group(['prefix' => 'contest/contestmanage/contest_config', 'as' => 'contest.contestmanage.contest_config.'], function () {
            Route::get('log', 'ContestConfigController@log')->name('log');
            Route::get('data', 'ContestConfigController@data')->name('data');
            Route::post('list_data', 'ContestConfigController@listData')->name('list_data');
            Route::get('manage', 'ContestConfigController@manage')->where('as','Danh sách cấu hình')->name('manage');
            Route::get('create', 'ContestConfigController@create')->name('create');
            Route::post('add', 'ContestConfigController@add')->name('add');
            Route::post('list_target_id', 'ContestConfigController@listTargetId')->name('list_target_id');
            Route::get('show', 'ContestConfigController@show')->name('show');
            Route::put('update', 'ContestConfigController@update')->name('update');
            Route::get('delete', 'ContestConfigController@delete')->name('delete');
            Route::get('confirm-delete', 'ContestConfigController@getModalDelete')->name('confirm-delete');
        });
        Route::group(['prefix' => 'contest/contestmanage/contest_round', 'as' => 'contest.contestmanage.contest_round.'], function () {
            Route::get('log', 'ContestRoundController@log')->name('log');
            Route::get('data', 'ContestRoundController@data')->name('data');
            Route::get('manage', 'ContestRoundController@manage')->where('as','Danh sách vòng thi')->name('manage');
            Route::get('create', 'ContestRoundController@create')->name('create');
            Route::post('add', 'ContestRoundController@add')->name('add');
            Route::get('show', 'ContestRoundController@show')->name('show');
            Route::put('update', 'ContestRoundController@update')->name('update');
            Route::get('delete', 'ContestRoundController@delete')->name('delete');
            Route::get('confirm-delete', 'ContestRoundController@getModalDelete')->name('confirm-delete');
        });
        Route::group(['prefix' => 'contest/contestmanage/contest_topic', 'as' => 'contest.contestmanage.contest_topic.'], function () {
            Route::get('log', 'ContestTopicController@log')->name('log');
            Route::get('data', 'ContestTopicController@data')->name('data');
            Route::get('manage', 'ContestTopicController@manage')->where('as','Danh sách màn thi')->name('manage');
            Route::get('create', 'ContestTopicController@create')->name('create');
            Route::post('add', 'ContestTopicController@add')->name('add');
            Route::get('show', 'ContestTopicController@show')->name('show');
            Route::put('update', 'ContestTopicController@update')->name('update');
            Route::get('delete', 'ContestTopicController@delete')->name('delete');
            Route::get('confirm-delete', 'ContestTopicController@getModalDelete')->name('confirm-delete');
        });
        Route::group(['prefix' => 'contest/contestmanage/topic_round', 'as' => 'contest.contestmanage.topic_round.'], function () {
            Route::get('log', 'TopicRoundController@log')->name('log');
            Route::get('data', 'TopicRoundController@data')->name('data');
            Route::get('manage', 'TopicRoundController@manage')->where('as','Danh sách vòng thi trong màn')->name('manage');
            Route::get('create', 'TopicRoundController@create')->name('create');
            Route::post('add', 'TopicRoundController@add')->name('add');
            Route::get('show', 'TopicRoundController@show')->name('show');
            Route::put('update', 'TopicRoundController@update')->name('update');
            Route::get('delete', 'TopicRoundController@delete')->name('delete');
            Route::get('confirm-delete', 'TopicRoundController@getModalDelete')->name('confirm-delete');
        });

        Route::group(['prefix' => 'contest/contestmanage/contest_client', 'as' => 'contest.contestmanage.contest_client.'], function () {
            Route::get('log', 'ContestClientController@log')->name('log');
            Route::get('data', 'ContestClientController@data')->name('data');
            Route::get('manage', 'ContestClientController@manage')->where('as','Danh sách client')->name('manage');
            Route::get('create', 'ContestClientController@create')->name('create');
            Route::post('add', 'ContestClientController@add')->name('add');
            Route::get('show', 'ContestClientController@show')->name('show');
            Route::put('update', 'ContestClientController@update')->name('update');
            Route::get('delete', 'ContestClientController@delete')->name('delete');
            Route::get('confirm-delete', 'ContestClientController@getModalDelete')->name('confirm-delete');
        });
    });
});
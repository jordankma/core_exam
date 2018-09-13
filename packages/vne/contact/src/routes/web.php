<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::get('vne/contact/demo/log', 'DemoController@log')->name('vne.contact.demo.log');
        Route::get('vne/contact/demo/data', 'DemoController@data')->name('vne.contact.demo.data');
        Route::get('vne/contact/demo/manage', 'DemoController@manage')->name('vne.contact.demo.manage');
        Route::get('vne/contact/demo/create', 'DemoController@create')->name('vne.contact.demo.create');
        Route::post('vne/contact/demo/add', 'DemoController@add')->name('vne.contact.demo.add');
        Route::get('vne/contact/demo/show', 'DemoController@show')->name('vne.contact.demo.show');
        Route::put('vne/contact/demo/update', 'DemoController@update')->name('vne.contact.demo.update');
        Route::get('vne/contact/demo/delete', 'DemoController@delete')->name('vne.contact.demo.delete');
        Route::get('vne/contact/demo/confirm-delete', 'DemoController@getModalDelete')->name('vne.contact.demo.confirm-delete');
    });
});
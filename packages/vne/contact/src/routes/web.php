<?php
$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {

        Route::get('vne/contact/contact/log', 'ContactController@log')->name('vne.contact.contact.log');
        Route::get('vne/contact/contact/data', 'ContactController@data')->name('vne.contact.contact.data');
        Route::get('vne/contact/contact/manage', 'ContactController@manage')->name('vne.contact.contact.manage')->where('as','Liên hệ - Danh sách');
        Route::get('vne/contact/contact/delete', 'ContactController@delete')->name('vne.contact.contact.delete');
        Route::get('vne/contact/contact/confirm-delete', 'ContactController@getModalDelete')->name('vne.contact.contact.confirm-delete');
    });
});
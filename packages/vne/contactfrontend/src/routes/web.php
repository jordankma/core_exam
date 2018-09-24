<?php
$adminPrefix = '';
//$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {
	// Route::group(['middleware' => ['register']], function () {
	    Route::get('lien-he', 'ContactfrontendController@contact')->name('vne.contactfrontend.contact')->where('as','Trang liên hệ');
	    Route::post('lien-he', 'ContactfrontendController@addContact')->name('vne.contactfrontend.contact.add');
    // });
});
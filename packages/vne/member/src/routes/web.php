<?php
$adminPrefix = config('site.admin_prefix');

/**
 * Frontend Routes
 */
Route::group(array('prefix' => null), function () {
    Route::match(['get', 'post'], 'login', 'Auth\LoginController@login')->name('vne.member.auth.login');

    Route::post('vne/member/member/register', 'Auth\LoginController@register')->name('vne.member.member.register');
    Route::post('verify', 'Auth\LoginController@verify');
    Route::group(['middleware' => ['vne.auth']], function () {
        // Route::get('', '\Adtech\Core\App\Http\Controllers\FrontendController@index')->name('frontend.homepage');

        Route::get('logout', 'Auth\LoginController@logout')->name('vne.member.auth.logout')->where('as','Đăng xuất');
    });
});

Route::group(array('prefix' => $adminPrefix), function() {
    Route::post('vne/member/member/check-username-exist', 'MemberController@checkUserNameExist')->name('vne.member.member.check-username-exist');
    Route::post('vne/member/member/check-email-exist', 'MemberController@checkEmailExist')->name('vne.member.member.check-email-exist');
    Route::post('vne/member/member/check-phone-exist', 'MemberController@checkPhoneExist')->name('vne.member.member.check-phone-exist');
    //thanh pho quan huyen
    Route::get('vne/member/member/get/district', 'MemberController@getDistrict')->name('vne.member.member.get.district');
    Route::get('vne/member/member/get/school', 'MemberController@getSchool')->name('vne.member.member.get.school');
    Route::get('vne/member/member/get/class', 'MemberController@getClass')->name('vne.member.member.get.class');
     Route::get('vne/member/member/sync_mongo', 'MemberController@syncMongo')->name('vne.member.member.sync_mongo');
    Route::group(['middleware' => ['adtech.auth', 'adtech.acl']], function () {
        //member
        Route::get('vne/member/member/log', 'MemberController@log')->name('vne.member.member.log');
        Route::get('vne/member/member/data', 'MemberController@data')->name('vne.member.member.data');
        Route::get('vne/member/member/manage', 'MemberController@manage')->name('vne.member.member.manage')->where('as','Người dùng - danh sách');
        Route::get('vne/member/member/create', 'MemberController@create')->name('vne.member.member.create');
        Route::post('vne/member/member/add', 'MemberController@add')->name('vne.member.member.add');
        Route::get('vne/member/member/show', 'MemberController@show')->name('vne.member.member.show');
        Route::post('vne/member/member/update', 'MemberController@update')->name('vne.member.member.update');

        Route::get('vne/member/member/delete', 'MemberController@delete')->name('vne.member.member.delete');
        Route::get('vne/member/member/confirm-delete', 'MemberController@getModalDelete')->name('vne.member.member.confirm-delete');

        Route::get('vne/member/member/reset', 'MemberController@reset')->name('vne.member.member.reset');
        Route::get('vne/member/member/confirm-reset', 'MemberController@getModalReset')->name('vne.member.member.confirm-reset');

        Route::get('vne/member/member/block', 'MemberController@block')->name('vne.member.member.block');
        Route::get('vne/member/member/confirm-block', 'MemberController@getModalBlock')->name('vne.member.member.confirm-block');

        //import export member excel
        Route::get('vne/member/member/excel/get/import', 'MemberController@getImport')->name('vne.member.member.excel.get.import')->where('as','Upload excel');
        Route::post('vne/member/member/excel/post/import', 'MemberController@postImport')->name('vne.member.member.excel.post.import');
    });

});
    

// Route::group(array('prefix' => 'resource/dev'), function() {
//     Route::post('post/login', 'ApiMemberController@postLogin');
//     Route::get('get/register', 'ApiMemberController@getRegister');
//     Route::get('get/getuserinfo', 'ApiMemberController@getUserInfo');
//     Route::put('put/user/change-password', 'ApiMemberController@putChangePass');

//     Route::get('get/list/group', 'ApiMemberController@getListGroup');
//     Route::get('get/list/member/group', 'ApiMemberController@getListMemberGroup');
// });

<?php
$adminPrefix = config('site.admin_prefix');

/**
 * Frontend Routes
 */
Route::group(array('prefix' => null), function () {
    Route::match(['get', 'post'], 'login', 'Auth\LoginController@login')->name('vne.member.auth.login');

    Route::group(['middleware' => ['vne.auth']], function () {
        // Route::get('', '\Adtech\Core\App\Http\Controllers\FrontendController@index')->name('frontend.homepage');

        Route::get('logout', 'Auth\LoginController@logout')->name('vne.member.auth.logout')->where('as','Đăng xuất');
    });
});

Route::group(array('prefix' => $adminPrefix), function() {
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
        Route::get('vne/member/member/block', 'MemberController@block')->name('vne.member.member.block');
        Route::get('vne/member/member/confirm-block', 'MemberController@getModalBlock')->name('vne.member.member.confirm-block');

        Route::post('vne/member/member/check-username-exist', 'MemberController@checkUserNameExist')->name('vne.member.member.check-username-exist');
        Route::post('vne/member/member/check-email-exist', 'MemberController@checkEmailExist')->name('vne.member.member.check-email-exist');
        Route::post('vne/member/member/check-phone-exist', 'MemberController@checkPhoneExist')->name('vne.member.member.check-phone-exist');
        //import export member excel
        Route::get('vne/member/member/excel/get/import', 'MemberController@getImport')->name('vne.member.member.excel.get.import')->where('as','Upload excel');
        Route::post('vne/member/member/excel/post/import', 'MemberController@postImport')->name('vne.member.member.excel.post.import');
        //thanh pho quan huyen
        Route::get('vne/member/member/get/district', 'MemberController@getDistrict')->name('vne.member.member.get.district');
        Route::get('vne/member/member/get/school', 'MemberController@getSchool')->name('vne.member.member.get.school');
        Route::get('vne/member/member/get/class', 'MemberController@getClass')->name('vne.member.member.get.class');

        //group member 
        
        Route::get('vne/member/group/log', 'GroupController@log')->name('vne.member.group.log');
        Route::get('vne/member/group/data', 'GroupController@data')->name('vne.member.group.data');
        Route::get('vne/member/group/manage', 'GroupController@manage')->name('vne.member.group.manage')->where('as','Nhóm người dùng - Danh sách');
        Route::get('vne/member/group/create', 'GroupController@create')->name('vne.member.group.create');
        Route::post('vne/member/group/add', 'GroupController@add')->name('vne.member.group.add');
        Route::get('vne/member/group/show', 'GroupController@show')->name('vne.member.group.show');
        Route::post('vne/member/group/update', 'GroupController@update')->name('vne.member.group.update');
        Route::get('vne/member/group/delete', 'GroupController@delete')->name('vne.member.group.delete');
        Route::get('vne/member/group/confirm-delete', 'GroupController@getModalDelete')->name('vne.member.group.confirm-delete');

        //add member to group
        Route::get('vne/member/group/manage/add/member', 'GroupController@manageAddGroup')->name('vne.member.group.manage.add.member');
        Route::post('vne/member/group/add/member', 'GroupController@addMember')->name('vne.member.group.add.member');
        Route::get('vne/member/group/data/member', 'GroupController@dataMember')->name('vne.member.group.data.member');
        Route::get('vne/member/group/delete/member', 'GroupController@deleteMember')->name('vne.member.group.delete.member');
        Route::get('vne/member/group/confirm-delete/member', 'GroupController@getModalDeleteMember')->name('vne.member.group.confirm-delete.member');
        Route::get('vne/member/group/search/member', 'GroupController@searchMember')->name('vne.member.group.search.member');

        Route::get('vne/member/group/test', 'GroupController@test');

        //position
        Route::get('vne/member/position/log', 'PositionController@log')->name('vne.member.position.log');
        Route::get('vne/member/position/data', 'PositionController@data')->name('vne.member.position.data');
        Route::get('vne/member/position/manage', 'PositionController@manage')->name('vne.member.position.manage')->where('as','Chức vụ - Danh sách');
        Route::get('vne/member/position/create', 'PositionController@create')->name('vne.member.position.create');
        Route::post('vne/member/position/add', 'PositionController@add')->name('vne.member.position.add');
        Route::get('vne/member/position/show', 'PositionController@show')->name('vne.member.position.show');
        Route::post('vne/member/position/update', 'PositionController@update')->name('vne.member.position.update');
        Route::get('vne/member/position/delete', 'PositionController@delete')->name('vne.member.position.delete');
        Route::get('vne/member/position/confirm-delete', 'PositionController@getModalDelete')->name('vne.member.position.confirm-delete');
    });
    Route::get('api/member/group-list', 'GroupController@apiList');

});

Route::group(array('prefix' => 'resource/dev'), function() {
    Route::post('post/login', 'ApiMemberController@postLogin');
    Route::get('get/register', 'ApiMemberController@getRegister');
    Route::get('get/getuserinfo', 'ApiMemberController@getUserInfo');
    Route::put('put/user/change-password', 'ApiMemberController@putChangePass');

    Route::get('get/list/group', 'ApiMemberController@getListGroup');
    Route::get('get/list/member/group', 'ApiMemberController@getListMemberGroup');
});

<?php
$adminPrefix = '';
//$adminPrefix = config('site.admin_prefix');
Route::group(array('prefix' => $adminPrefix), function() {

    Route::get('cap-nhat-thong-tin', 'MemberfrontendController@show')->name('vne.memberfrontend.show');
    Route::post('cap-nhat-thong-tin', 'MemberfrontendController@update')->name('vne.memberfrontend.update');

    Route::get('danh-sach-thi-sinh', 'MemberfrontendController@list')->name('vne.memberfrontend.list')->where('as','tra cứu - danh sách thí sinh frontend');
	Route::get('search-danh-sach-thi-sinh', 'MemberfrontendController@search')->name('vne.memberfrontend.list.search');
    
	
    Route::get('ket-qua-thi-sinh/{member_id}', 'MemberfrontendController@resultMember')->name('vne.memberfrontend.result.member');
	
	Route::get('ket-qua', 'MemberfrontendController@result')->name('vne.memberfrontend.result')->where('as','tra cứu - danh sách kết quả thí sinh frontend');
    Route::get('search-ket-qua', 'MemberfrontendController@searchResult')->name('vne.memberfrontend.search.result.member');

    Route::get('top-thi-sinh-dangky', 'MemberfrontendController@listTopMember')->name('vne.memberfrontend.list.top.member')->where('as','tra cứu - top thí sinh đăng ký');
    Route::get('top-thi-sinh-da-thi', 'MemberfrontendController@listTopMemberExam')->name('vne.memberfrontend.list.top.member.exam')->where('as','tra cứu - top thí sinh đã thi');
    
});
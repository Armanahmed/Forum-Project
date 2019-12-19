<?php


Route::get('/', 'ManageController@entrypage');
Auth::routes();

Route::middleware('auth')->group(function() {
	
	Route::get('/adminhome', 'ManageController@index')->name('adminhome')->middleware('guardlogin:staff,admin,manager,coordinator');
	Route::resource('departments', 'DepartmentController')->middleware('guardlogin:admin,manager');

	// Route::resource('departments', 'DepartmentController', ['except' => ['create']]);
	Route::resource('periods', 'PeriodController')->middleware('guardlogin:admin,manager,coordinator');
	Route::resource('users', 'StudentController')->middleware('guardlogin:admin,manager,coordinator');
	Route::resource('staffs', 'StaffController')->middleware('guardlogin:admin,manager,coordinator');
	Route::resource('coordinators', 'CoordinatorController')->middleware('guardlogin:admin,manager');
	Route::resource('categories', 'CategoryController')->middleware('guardlogin:admin,manager');
	Route::resource('ideaadmin', 'IdeaadminController')->middleware('guardlogin:staff,admin,manager,coordinator');

	Route::get('ideacomment', ['uses' => 'IdeaadminController@ideacomment', 'as' => 'ideaadmin.comment']);
	Route::get('ideapopular', ['uses' => 'IdeaadminController@ideapopular', 'as' => 'ideaadmin.popular']);
	Route::get('ideaviewed', ['uses' => 'IdeaadminController@ideaviewed', 'as' => 'ideaadmin.viewed']);
	Route::get('/zipdownload/{post_id}', ['uses' => 'IdeaadminController@zipdownload', 'as' => 'zipdownload']);
	
	Route::post('comments/{post_id}', ['uses' => 'IdeaController@commentcreate', 'as' => 'comments.store']);
	Route::post('postlike', ['uses' => 'IdeaController@likestore', 'as' => 'postlike.store']);
	Route::post('postdislike', ['uses' => 'IdeaController@dislikestore', 'as' => 'postdislike.store']);
	Route::get('/download/{file}', ['uses' => 'IdeaController@getDownload', 'as' => 'getDownload.down']);
	// Route::resource('ideapanel.create', 'IdeaController@create')->middleware('guardlogin:student');
	Route::resource('ideapanel', 'IdeaController');
	
});



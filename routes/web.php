<?php

//HOME ROUTES
Route::get('/', 'HomeController@index')->name('home');
Route::get('/jobs', 'HomeController@jobs')->name('jobs');
Route::get('/services', 'HomeController@services')->name('services');
Route::get('/categories', 'HomeController@categories')->name('categories');
Route::get('/blogs', 'HomeController@blogs')->name('blogs');
Route::get('/users', 'HomeController@users')->name('users');

//ADMIN ROUTES
Route::get('/admin/categories', 'AdminController@categories')->name('admin.categories');
Route::post('/admin/category/store', 'AdminController@storeCategory')->name('admin.store.category');
Route::get('/admin/subcategories', 'AdminController@subcategories')->name('admin.subcategories');
Route::post('/admin/subcategory/store', 'AdminController@storeSubcategory')->name('admin.store.subcategory');

//AUTH ROUTES
Auth::routes();

//USERS ROUTES
Route::get('/user/{username}/services', 'UsersController@services')->name('user.services');
Route::get('/user/{username}/jobs', 'UsersController@jobs')->name('user.jobs');
Route::get('/user/{username}/profiles', 'UsersController@profiles')->name('user.profiles');
Route::get('/user/{username}/blogs', 'UsersController@blogs')->name('user.blogs');
Route::get('/user/{username}/about', 'UsersController@about')->name('user.about');

//SESSION ROUTES GET
Route::get('/session/services', 'SessionController@services')->name('session.services')->middleware('auth');
Route::get('/session/jobs', 'SessionController@jobs')->name('session.jobs')->middleware('auth');
Route::get('/session/profiles', 'SessionController@profiles')->name('session.profiles')->middleware('auth');
Route::get('/session/blogs', 'SessionController@blogs')->name('session.blogs')->middleware('auth');
Route::get('/session/about', 'SessionController@about')->name('session.about')->middleware('auth');
Route::get('/session/notifications', 'SessionController@notifications')->name('session.notifications')->middleware('auth');

//SESSION UPDATES ROUTES
Route::patch('/session/about/identity/update', 'SessionController@updateSessionIdentity')->name('session.update.identity')->middleware('auth');
Route::patch('/session/about/contacts/update', 'SessionController@updateSessionContacts')->name('session.update.contacts')->middleware('auth');
Route::patch('/session/about/about/update', 'SessionController@updateSessionAbout')->name('session.update.about')->middleware('auth');
Route::patch('/session/about/social/update', 'SessionController@updateSessionSocial')->name('session.update.social')->middleware('auth');
Route::patch('/session/about/bio/update', 'SessionController@updateSessionBio')->name('session.update.bio')->middleware('auth');
Route::patch('/session/about/image/profile/update', 'SessionController@updateProfileImage')->name('session.update.profile.image')->middleware('auth');

//SESSION NOTIFICATION ROUTES
Route::get('/session/notification/{id}/read', 'NotificationsController@read')->name('session.notification.read')->middleware('auth');
Route::get('/session/notification/{id}/destroy', 'NotificationsController@destroy')->name('session.notification.delete')->middleware('auth');
Route::get('/session/notifications/read/all', 'NotificationsController@readAll')->name('session.notifications.read.all')->middleware('auth');

//USER PROFILE ROUTES
Route::get('/profile/user/create', 'UserProfilesController@create')->name('user.profile.create')->middleware('auth');
Route::post('/profile/user/store', 'UserProfilesController@store')->name('user.profile.store')->middleware('auth');
Route::get('/profile/user/{id}/enc-dt-{uuid}', 'UserProfilesController@show')->name('user.profile.show');
Route::get('/profile/user/{id}/edit/enc-dt-{uuid}', 'UserProfilesController@edit')->name('user.profile.edit');
Route::patch('/profile/user/{id}/update/enc-dt-{uuid}', 'UserProfilesController@update')->name('user.profile.update');
Route::delete('/profile/user/{id}/delete/enc-dt-{uuid}', 'UserProfilesController@delete')->name('user.profile.delete');
Route::get('/profile/user/{id}/like/all', 'UserProfilesController@getLikes')->name('user.profile.likes.all');
Route::post('/profile/user/{id}/like/enc-dt-{uuid}', 'UserProfilesController@like')->name('user.profile.like');
Route::post('/profile/user/{id}/job/hire', 'UserProfilesController@hire')->name('user.profile.hire')->middleware('auth');

//USER PROFILE PREFERENCE ROUTES
Route::get('/profile/user/{id}/peferences/create/enc-dt-{uuid}', 'UserProfilesController@createProfilePreferences')->name('user.profile.peferences.create')->middleware('auth');
Route::post('/profile/user/{id}/peferences/store', 'UserProfilesController@storeProfilePreferences')->name('user.profile.peferences.store')->middleware('auth');
Route::delete('/profile/user/{prof}/peference/{pref}/destroy', 'UserProfilesController@destroyProfilePreference')->name('user.profile.peference.destroy')->middleware('auth');
Route::get('/profile/user/{id}/peferences/load', 'UserProfilesController@loadProfilePreferences')->name('user.profile.peferences.load')->middleware('auth');
Route::get('/profile/user/{id}/peferences/check', 'UserProfilesController@checkProfilePrferences')->name('user.profile.peferences.check')->middleware('auth');

//USER PROFILE FILES ROUTES
Route::get('/profile/user/{id}/files/create/enc-dt-{uuid}', 'UserProfilesController@createProfileFiles')->name('user.profile.files.create')->middleware('auth');
Route::post('/profile/user/{id}/files/store', 'UserProfilesController@storeProfileFiles')->name('user.profile.files.store')->middleware('auth');
Route::get('/profile/user/{id}/files/images/load', 'UserProfilesController@loadProfileImages')->name('user.profile.images.load')->middleware('auth');
Route::delete('/profile/user/{prof}/files/image/{img}/destroy', 'UserProfilesController@destroyProfileImage')->name('user.profile.image.destroy')->middleware('auth');

//USER PROFILE REVIEWS ROUTES
Route::get('/profile/user/{id}/reviews/all', 'ProfileReviewsController@index')->name('user.profile.reviews.all');
Route::post('/profile/user/{id}/reviews/store', 'ProfileReviewsController@store')->name('user.profile.reviews.store');
Route::patch('/profile/user/{profile}/review/{id}/update', 'ProfileReviewsController@update')->name('user.profile.review.update')->middleware('auth');
Route::delete('/profile/user/{profile}/review/{id}/destroy', 'ProfileReviewsController@destroy')->name('user.profile.review.destroy')->middleware('auth');

//CATEGORY AND SUBCATEGORY ROUTES
Route::get('/categories/all/json', 'CategoriesController@categoriesAllJson')->name('categories.json');
Route::get('/categories/filter/json', 'CategoriesController@categoriesFilterJson')->name('categories.filter.json');
Route::get('/category/{id}/subcategories', 'CategoriesController@category')->name('category.subcategories');
Route::get('/category/{id}/subcategories/filter/json', 'CategoriesController@subcategoriesFilterJson')->name('sucategories.filter.json');
Route::get('/category/{id}/subcategory/data/load', 'CategoriesController@subcategoriesAll')->name('category.subcategories.data.load');
Route::get('/category/{cat}/subcategory/{id}/data/get', 'CategoriesController@subcategory')->name('category.subcategory.data.get');

//JOB ROUTES
Route::get('/user/job/create', 'JobsController@create')->name('job.create')->middleware('auth');
Route::post('/user/job/store', 'JobsController@store')->name('job.store')->middleware('auth');
Route::get('/user/job/{id}/enc-dt-{uuid}', 'JobsController@show')->name('job.show');
Route::get('/user/job/{id}/edit/enc-dt-{uuid}', 'JobsController@edit')->name('job.edit')->middleware('auth');
Route::patch('/user/job/{id}/update', 'JobsController@update')->name('job.update')->middleware('auth');
Route::delete('/user/job/{id}/destroy', 'JobsController@destroy')->name('job.delete')->middleware('auth');
Route::get('/user/job/{id}/likes/all', 'JobsController@getLikes')->name('job.likes.all');
Route::post('/user/job/{id}/like', 'JobsController@like')->name('job.like')->middleware('auth');
Route::get('/user/job/jobs/all', 'JobsController@jobs')->name('job.jobs');
Route::get('/user/job/services/all', 'JobsController@services')->name('job.services');

//JOB PREFERENCES ROUTES
Route::get('/user/job/{id}/peferences/create/enc-dt-{uuid}', 'JobsController@createJobPreferences')->name('job.preferences.create')->middleware('auth');
Route::get('/user/job/{id}/peferences/load', 'JobsController@loadJobPreferences')->name('job.preferences.load')->middleware('auth');
Route::get('/user/job/{id}/peferences/check', 'JobsController@checkJobPreferences')->name('job.preferences.check')->middleware('auth');
Route::post('/user/job/{id}/peferences/store', 'JobsController@storeJobPreferences')->name('job.preferences.store')->middleware('auth');
Route::delete('/user/job/{jb}/peference/{pref}/destroy', 'JobsController@destroyJobPreference')->name('job.preference.destroy')->middleware('auth');

//JOB IMAGES ROUTE
Route::get('/user/job/{id}/images/create/enc-dt-{uuid}', 'JobsController@createJobImage')->name('job.images.create')->middleware('auth');
Route::get('/user/job/{id}/images/load', 'JobsController@loadJobImages')->name('job.images.load')->middleware('auth');
Route::post('/user/job/{id}/images/store', 'JobsController@storeJobImages')->name('job.images.store')->middleware('auth');
Route::post('/user/job/{jb}/image/{img}/destroy', 'JobsController@destroyJobImage')->name('job.image.destroy')->middleware('auth');

//JOB COMMENTS ROUTES
Route::get('/user/job/{id}/comments/all', 'JobCommentsController@index')->name('job.comments.all');
Route::post('/user/job/{id}/comment/store', 'JobCommentsController@store')->name('job.comment.store')->middleware('auth');
Route::patch('/user/job/{jb}/comment/{com}/update', 'JobCommentsController@update')->name('job.comment.update')->middleware('auth');
Route::delete('/user/job/{jb}/comment/{comm}/destroy', 'JobCommentsController@destroy')->name('job.comment.destroy')->middleware('auth');

//JOB SUGGESTIONS ROUTES
Route::get('/user/job/{id}/suggestions/load/all', 'JobSuggestionsController@index')->name('job.suggestions.load.all')->middleware('auth');
Route::get('/user/job/{id}/suggestions/manage/all/enc-dt-{uuid}', 'JobSuggestionsController@manage')->name('job.suggestions.manage.all')->middleware('auth');
Route::get('/user/job/{id}/suggestions/excel/export', 'JobSuggestionsController@exportExcel')->name('job.suggestions.export.excel')->middleware('auth');
Route::get('/user/job/{id}/suggestions/pdf/export', 'JobSuggestionsController@exportPDF')->name('job.suggestions.export.pdf')->middleware('auth');
Route::get('/user/job/{jb}/suggestion/{sug}/cv/download/enc-dt-{uuid}', 'JobSuggestionsController@downloadCV')->name('job.suggestion.cv.download')->middleware('auth');
Route::post('/user/job/{id}/suggestion/store', 'JobSuggestionsController@store')->name('job.suggestion.store')->middleware('auth');
Route::delete('/user/job/{jb}/suggestion/{sug}/destroy', 'JobSuggestionsController@destroy')->name('job.suggestion.destroy')->middleware('auth');
Route::patch('/user/job/{jb}/suggestion/{sug}/status/update', 'JobSuggestionsController@updateStatus')->name('job.suggestion.status.update')->middleware('auth');
Route::get('/user/job/{jb}/suggestion/{sug}/status/update/else', 'JobSuggestionsController@updateStatusElse')->name('job.suggestion.status.update.else')->middleware('auth');
Route::get('/user/job/{id}/suggestions/email/create/enc-dt-{uuid}', 'JobSuggestionsController@emailCreate')->name('job.suggestions.email.create')->middleware('auth');
Route::post('/user/job/{id}/suggestions/email/store', 'JobSuggestionsController@emailStore')->name('job.suggestions.email.store')->middleware('auth');

//MESSAGES ROUTES
Route::get('/session/messages/all', 'MessagesController@index')->name('session.messages.all')->middleware('auth');
Route::get('/session/messages/load/all', 'MessagesController@loadIndex')->name('session.messages.load.all')->middleware('auth');
Route::get('/session/message/{id}/load', 'MessagesController@readTextMessage')->name('session.text.message.load')->middleware('auth');
Route::get('/session/messages/{username}', 'MessagesController@show')->name('session.messages.user')->middleware('auth');
Route::get('/session/messages/{id}/a/load', 'MessagesController@load')->name('session.messages.load')->middleware('auth');
Route::post('/session/message/text/store', 'MessagesController@storeText')->name('session.message.text.store')->middleware('auth');
Route::post('/session/message/images/store', 'MessagesController@storeImages')->name('session.message.images.store')->middleware('auth');
Route::post('/session/message/location/store', 'MessagesController@storeLocation')->name('session.message.location.store')->middleware('auth');

//BLOG ROUTES
Route::get('/user/blog/create', 'BlogsController@create')->name('user.blog.create')->middleware('auth');
Route::post('/user/blog/store', 'BlogsController@store')->name('user.blog.store')->middleware('auth');
Route::get('/user/blog/{id}/enc-dt-{uuid}', 'BlogsController@show')->name('user.blog.show');
Route::get('/user/blog/{id}/likes/all', 'BlogsController@getLikes')->name('user.blog.likes.all');
Route::post('/user/blog/{id}/like', 'BlogsController@like')->name('user.blog.like')->middleware('auth');
Route::get('/user/blog/{id}/edit/enc-dt-{uuid}', 'BlogsController@edit')->name('user.blog.edit')->middleware('auth');
Route::patch('/user/blog/{id}/update', 'BlogsController@update')->name('user.blog.update')->middleware('auth');
Route::delete('/user/blog/{id}/destroy', 'BlogsController@destroy')->name('user.blog.delete')->middleware('auth');
Route::get('/user/blog/blogs/all', 'BlogsController@blogs')->name('user.blog.blogs');

//BLOG PREFERENCES ROUTES
Route::get('/user/blog/{id}/peferences/create/enc-dt-{uuid}', 'BlogsController@createBlogPreferences')->name('blog.preferences.create')->middleware('auth');
Route::get('/user/blog/{id}/peferences/load', 'BlogsController@loadBlogPreferences')->name('blog.preferences.load')->middleware('auth');
Route::get('/user/blog/{id}/peferences/check', 'BlogsController@checkBlogPreferences')->name('blog.preferences.check')->middleware('auth');
Route::post('/user/blog/{id}/peferences/store', 'BlogsController@storeBlogPreferences')->name('blog.preferences.store')->middleware('auth');
Route::delete('/user/blog/{jb}/peference/{pref}/destroy', 'BlogsController@destroyBlogPreference')->name('blog.preference.destroy')->middleware('auth');

//BLOG RESPONSES ROUTES
Route::get('/user/blog/{id}/responses/all', 'BlogResponsesController@index')->name('blog.responses.all');
Route::post('/user/blog/{id}/response/store', 'BlogResponsesController@store')->name('blog.response.store')->middleware('auth');
Route::patch('/user/blog/{bl}/response/{res}/update', 'BlogResponsesController@update')->name('blog.response.update')->middleware('auth');
Route::delete('/user/blog/{bl}/response/{res}/destroy', 'BlogResponsesController@destroy')->name('blog.response.destroy')->middleware('auth');
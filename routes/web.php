<?php

Auth::routes();

// Home
Route::get('/', 'PagesController@home')->name('pages.home');

// Resume
Route::get('resume', 'PagesController@resume')->name('pages.resume');

// Contact
Route::get('contact', 'PagesController@contact')->name('pages.contact');
Route::post('contact', 'PagesController@postContact')->name('pages.contact');

// Translate
Route::get('translate/{lang}', 'PagesController@translate')->name('pages.translate');

// Blog
Route::group(['prefix' => 'blog'], function () {
    Route::get('/', 'BlogController@index')->name('blog.index');
    Route::get('{slug}', 'BlogController@show')->name('blog.show');
    Route::get('tag/{slug}', 'BlogController@tag')->name('blog.tag');
});

// Works
Route::group(['prefix' => 'works'], function () {
    Route::get('/', 'WorkController@index')->name('works.index');
    Route::get('{slug}', 'WorkController@show')->name('works.show');
});

// Admin routes
Route::group(['namespace' => 'Admin', 'middleware' => 'auth', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    // Dashboard
    Route::get('/', 'DashboardController@index')->name('dashboard');

    // Settings
    Route::get('settings', 'SettingsController@edit')->name('settings.edit');
    Route::put('settings', 'SettingsController@update')->name('settings.update');

    // Posts
    Route::resource('posts', 'PostsController');

    // Works
    Route::resource('works', 'WorksController');

    // Customers
    Route::resource('customers', 'CustomersController');

    // Users
    Route::resource('users', 'UsersController');

    // Tags
    Route::resource('tags', 'TagsController');
    Route::get('tags.json', 'TagsController@indexRaw')->name('tags.index.raw');

    // Profile
    Route::get('profile', 'ProfileController@index')->name('profile');
});

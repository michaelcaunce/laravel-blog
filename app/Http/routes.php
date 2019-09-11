<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::group(['middle' => ['web']], function () {

  // Authentication Routes
  Route::get('auth/login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
  Route::post('auth/login', 'Auth\AuthController@postLogin');
  Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

  // Registration Routes
  Route::get('auth/register', 'Auth\AuthController@getRegister');
  Route::post('auth/register', 'Auth\AuthController@postRegister');

  // Password Resets
  Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
  Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
  Route::post('password/reset', 'Auth\PasswordController@reset');

  // Regular expression used, any letter, any number, a dash, an underscore, however many after. Restrictsthe slug to
  // only accept these characters.
  Route::get('blog/{slug}', ['as' => 'blog.single', 'uses' => 'BlogController@getSingle'])->where('slug', '[\w\d\-\_]+');
  Route::get('blog', ['uses' => 'BlogController@getIndex', 'as' => 'blog.index']);

  Route::get('/contact', 'PagesController@getContact');
  Route::post('contact', 'PagesController@postContact');

  Route::get('/find', 'PagesController@getFind');
  Route::get('/about', 'PagesController@getAbout');
  Route::get('/', 'PagesController@getIndex');

  // Comments
  Route::post('comments/{post_id}', ['uses' => 'CommentsController@store', 'as' => 'comments.store']);
  Route::get('comments/{id}/edit', ['uses' => 'CommentsController@edit', 'as' => 'comments.edit']);
  Route::put('comments/{id}', ['uses' => 'CommentsController@update', 'as' => 'comments.update']);
  Route::delete('comments/{id}', ['uses' => 'CommentsController@destroy', 'as' => 'comments.destroy']);
  Route::get('comments/{id}/delete', ['uses' => 'CommentsController@delete', 'as' => 'comments.delete']);

  // Route resource provides all the built in CRUD functions.
  Route::resource('/posts', 'PostController');
  // Categories
  // Tell Laravel not the create a 'create' route inside CategoryController. Third parameter (array) contains the function
  // that isn't required.
  Route::resource('categories', 'CategoryController', ['except' => ['create']]);

  // tags
  Route::resource('tags', 'TagController', ['except' => ['create']]);




  });

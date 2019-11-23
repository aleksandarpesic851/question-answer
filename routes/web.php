<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('user/activate', 'UserController@activate');
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	Route::resource('tag', 'TagController', ['except' => ['show']]);
// Question
	Route::resource('question', 'QuestionController', ['except' => ['show']]);
	Route::get('question/delete/{id}', 'QuestionController@destroy');
	Route::get('question/datatable', 'QuestionController@getDatatable');
	Route::get('question/activate', 'QuestionController@activate');
	Route::get('question/getquestion', 'QuestionController@getQuestion');
// Answer
	Route::get('answer/delete/{id}', 'AnswerController@destroy');
	Route::get('answer/add/{question_id}', 'AnswerController@addAnswer');
	Route::post('answer/create', 'AnswerController@createAnswer');
// Dashboard
	Route::get('home/datatable', 'HomeController@getQuestions');
});
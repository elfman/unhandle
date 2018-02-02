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

Route::get('/', 'QuestionsController@index')->name('root');

Auth::routes();

Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);
Route::resource('questions', 'QuestionsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);

Route::post('/upload_image', 'QuestionsController@uploadImage')->name('questions.upload_image');
Route::resource('answers', 'AnswersController', ['only' => ['store', 'update', 'edit', 'destroy']]);

Route::get('/questions/{question}/answer', 'AnswersController@create')->name('answers.create');
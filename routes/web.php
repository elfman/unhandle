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
Route::get('/questions/my', 'QuestionsController@my')->name('questions.my');
Route::resource('questions', 'QuestionsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);

Route::post('/upload_image', 'QuestionsController@uploadImage')->name('questions.upload_image');

Route::resource('answers', 'AnswersController', ['only' => ['create', 'store', 'update', 'edit', 'destroy']]);
Route::post('/answers/{answer}/accept', 'AnswersController@accept')->name('answers.accept');
Route::post('/answers/{answer}/cancelAccept', 'AnswersController@cancelAccept')->name('answers.cancelAccept');

//Route::get('/questions/{question}/answer', 'AnswersController@create')->name('answers.create');

Route::post('/questions/{question}/upvote', 'QuestionsController@vote')->name('questions.upvote');
Route::post('/questions/{question}/downvote', 'QuestionsController@vote')->name('questions.downvote');

Route::post('/answers/{answer}/upvote', 'AnswersController@vote')->name('answers.upvote');
Route::post('/answers/{answer}/downvote', 'AnswersController@vote')->name('answers.downvote');

Route::resource('comments', 'CommentsController', ['only' => ['store', 'update', 'destroy']]);
Route::post('/comments/reply', 'CommentsController@store')->name('comments.reply');

Route::get('/notifications', 'NotificationsController@index')->name('notifications.index');
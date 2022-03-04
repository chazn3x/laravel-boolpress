<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes(['verify' => true]);

Route::prefix('admin')->namespace('Admin')->middleware('verified')->group(function () {
    
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('posts', 'PostsController');
    Route::resource('categories', 'CategoriesController');
    Route::resource('tags', 'TagsController');
    Route::patch('comments/{comment}', 'CommentController@update')->name('comments.update');
    Route::delete('comments/{comment}', 'CommentController@destroy')->name('comments.destroy');

});

Route::get('{any?}', function() {
    return view('home');
})->where('any', '.*');


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
Route::get('/',['uses' => 'IndexController@index', 'as' => 'home']);
Route::get('/articles',['uses' => 'ArticlesController@allArticles', 'as' => 'articles']);
Route::post('/getArticles',['uses' => 'ArticlesController@getExternalArticles', 'as' => 'getArticles']);
// Route::get('/', function () {
//     return view('welcome');
// });

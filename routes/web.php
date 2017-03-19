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
Route::get('home',['as'=>'home','uses'=>function(){
    return view('home');
}]);
Route::get('/', ['as'=>'main', 'uses' => 'FolderController@index']);
Route::get('/edit', ['middleware'=>'auth','as'=>'edit', 'uses' => 'FolderController@edit']);
Route::post('/edit/create', ['middleware'=>'auth','as'=>'edit.create', 'uses' => 'FolderController@create']);
Route::post('/edit/remove',['middleware'=>'auth','as'=>'edit.remove', 'uses' => 'FolderController@remove']);
Route::post('/edit/update',['middleware'=>'auth','as'=>'edit.update', 'uses' => 'FolderController@update']);
Auth::routes();


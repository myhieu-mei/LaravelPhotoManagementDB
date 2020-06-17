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

Route::get('/', function () {
    return view('welcome');
});
Route::get("admin/categories", "Admin\CategoriesController@index");
Route::get("admin/photos", "Admin\PhotosController@index");
Route::get("admin/photos/create", "Admin\PhotosController@create");
Route::post("admin/photos", "Admin\PhotosController@store");


Route::delete('/admin/photo/{id}', 'Admin\PhotosController@destroy');
Route::get('/admin/photos/{id}/edit', 'Admin\PhotosController@edit');
Route::PATCH('/admin/photos/{id}', 'Admin\PhotosController@update');
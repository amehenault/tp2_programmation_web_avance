<?php

require_once __DIR__ . '/Route.php';

require_once __DIR__ . '/../controllers/HomeController.php';
require_once __DIR__ . '/../controllers/PostController.php';

Route::get('/', 'HomeController@index');
Route::get('/articles', 'PostController@index');
Route::get('/article', 'PostController@show');
Route::get('/article/create', 'PostController@create');
Route::get('/article/edit', 'PostController@edit');
Route::post('/article/store', 'PostController@store');
Route::post('/article/update', 'PostController@update');
Route::post('/article/delete', 'PostController@destroy');
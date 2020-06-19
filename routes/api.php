<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//1
Route::post('signup','userController@signup');

//2
Route::post('login','userController@login');


Route::group(['prefix' => 'category'], function () {
    //3
    Route::get('index','categoriesController@index');

    //4
    Route::get('show/{id}','categoriesController@show');

    //5
    Route::post('add','categoriesController@add');

    //6
    Route::put('update/{cate}','categoriesController@update');

    //7
    Route::delete('delete/{cate}','categoriesController@delete');

});


Route::group(['prefix' => 'news'], function () {
    //8
    Route::get('index','postsController@index');

    //9
    Route::get('show/{id}','postsController@show');

    //10
    Route::post('add','postsController@add');

    //11
    Route::put('update/{news}','postsController@update');

    //12
    Route::delete('delete/{news}','postsController@delete');
    
});
Route::group(['prefix' => 'pages'], function () {
    //13
    Route::get('index','pagesController@index');

    //14
    Route::get('show/{id}','pagesController@show');

    //15
    Route::post('add','pagesController@add');

    //16
    Route::put('update/{pages}','pagesController@update');

    //17
    Route::delete('delete/{pages}','pagesController@delete');
    
});

Route::group(['prefix' => 'upload'], function () {
    //18
    Route::post('image-upload','uploadController@imageUpload');

    //19
    Route::post('post-assets','uploadController@postAssets');

    //20
    Route::post('delete-assets','uploadController@deleteAssets');

});


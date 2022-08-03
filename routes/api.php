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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
    Route::post('register', 'App\Http\Controllers\AuthController@register');
});

Route::get('/movies', 'App\Http\Controllers\MovieController@index'); //All movies
Route::post('/movies', 'App\Http\Controllers\MovieController@store'); //Add movie
Route::put('/movies/{id}', 'App\Http\Controllers\MovieController@update');
Route::delete('/movies/{id}', 'App\Http\Controllers\MovieController@destroy'); //Del movie
Route::get('/movies/{id}', 'App\Http\Controllers\MovieController@show'); //Detail movie
Route::get('/movies/user/{id_user}', 'App\Http\Controllers\MovieController@byUser'); //Movies User
Route::get('/movies/image/{filename}', 'App\Http\Controllers\MovieController@posterMovie');

// Route::get('/comments', 'App\Http\Controllers\CommentController@index');
Route::post('/comments', 'App\Http\Controllers\CommentController@store'); //Add comment
// Route::put('/comments/{id}', 'App\Http\Controllers\CommentController@update');
// Route::delete('/comments/{id}', 'App\Http\Controllers\CommentController@destroy');
Route::get('/comments/movie/{id_movie}', 'App\Http\Controllers\CommentController@byMovie'); //Cmmt movie
// Route::get('/comments/user/{id_user}', 'App\Http\Controllers\CommentController@byUser');

// Route::get('/favorites', 'App\Http\Controllers\FavoriteController@index');
Route::post('/favorites', 'App\Http\Controllers\FavoriteController@store'); //Add Fav
Route::delete('/favorites/{id}', 'App\Http\Controllers\FavoriteController@destroy'); //Del Fav
// Route::get('/favorites/{id}', 'App\Http\Controllers\FavoriteController@show');
Route::get('/favorites/user/{id_user}', 'App\Http\Controllers\FavoriteController@byUser'); //Fav User
// Route::get('/favorites/movie/{id_movie}', 'App\Http\Controllers\FavoriteController@byMovie');

Route::get('/ratings', 'App\Http\Controllers\RatingController@index');
Route::post('/ratings', 'App\Http\Controllers\RatingController@store'); //Add Rate
Route::put('/ratings/{id}', 'App\Http\Controllers\RatingController@update'); //Update Rate
// Route::get('/ratings/{id}', 'App\Http\Controllers\RatingController@show');
Route::get('/ratings/movie/{id_movie}', 'App\Http\Controllers\RatingController@ratingMovie'); //Rating Movie
Route::get(
    '/ratings/user/{id_user}/movie/{id_movie}',
    'App\Http\Controllers\RatingController@ratingUserMovie'
); //Rating User Movie
Route::get('/ratings/top', 'App\Http\Controllers\RatingController@topRating');//Top Rating Movie

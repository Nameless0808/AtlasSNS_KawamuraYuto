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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/home', 'HomeController@index')->name('home');

//Auth::routes();


//ログアウト中のページ
Route::get('/login', 'Auth\LoginController@login')->name('login');
Route::post('/login', 'Auth\LoginController@login');

Route::get('/register', 'Auth\RegisterController@register');
Route::post('/register', 'Auth\RegisterController@register');

Route::get('/added', 'Auth\RegisterController@added');
Route::post('/added', 'Auth\RegisterController@added');

//ログイン中のページ
// Route::get('/top','PostsController@index'); // Remove this line
// Route::get('/profile','UsersController@profile'); // Remove this line
// Route::get('/search','UsersController@index'); // Remove this line
// Route::get('/follow-list','PostsController@index'); // Remove this line
// Route::get('/follower-list','PostsController@index'); // Remove this line

Route::get('/logout', 'Auth\LoginController@logout')->name('logout'); // セキュリティの観点から本来はpostリクエストのほうが好ましい

// Route::get('/top', 'PostsController@index')->name('top'); // Remove this line
// Route::post('/posts', 'PostsController@store'); // Remove this line

// 既存のルートにauthミドルウェアを適用
    Route::middleware(['auth'])->group(function () {
    Route::get('/top','PostsController@index')->name('top'); // Add name('top') here
    Route::post('/posts', 'PostsController@store'); // Add this line here
    Route::get('/profile','UsersController@profile')->name('profile'); // add name('profile') here
    Route::get('/user/{id}','UsersController@show');
    Route::get('/search','UsersController@index');
    Route::get('/search_result', 'UsersController@searchResult');
    Route::get('/followList','FollowsController@followList');
    Route::get('/followerList','FollowsController@followerList');
    Route::get('/posts/{post}/edit', 'PostsController@edit');
    Route::patch('/posts/{post}', 'PostsController@update');
    Route::delete('/posts/{id}', 'PostsController@destroy');
    Route::post('/follow', 'FollowsController@follow');
    Route::post('/unfollow', 'FollowsController@unfollow');
    Route::put('/profile', 'UsersController@update')->name('profile.update');
    Route::get('user/{user}', 'UsersController@show')->name('users.show');
});


    // 他のルートもここに追加

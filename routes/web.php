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

Route::get('/', function () {
    return view('vue-app')->with('public_key', config('webpush.vapid.public_key'));
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

/*
 * The following ensures that pages are not reloaded when using the vue
 * app. This is a catch all for all routes beginning with "app".
 */

Route::any('app/{all?}', function () {

    return view('vue-app')->with('public_key', config('webpush.vapid.public_key'));
})
->where(['all' => '.*']);

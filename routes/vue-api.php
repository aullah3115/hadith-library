<?php

use Illuminate\Http\Request;

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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::post('search', 'SearchController@search');

Route::post('submit/contact/form', 'MessageController@store');

Route::post('login', 'Auth\LoginController@login');

Route::post('register', 'Auth\RegisterController@register');

Route::get('authors', 'AuthorController@index');

Route::get('tree', 'BookController@getTree');

Route::get('bio_authors', 'BioAuthorController@index');

Route::get('narrators', 'NarratorController@index');

Route::get('commentators', 'CommentatorController@index');

Route::get('books', 'BookController@index');

Route::get('bio_books', 'BioBookController@index');

Route::get('books/book/{book_id}', 'BookController@get');

Route::get('commentaries/{book_id?}', 'CommentaryController@index');

Route::get('sections/{book_id}/{parent_id?}', 'SectionController@index');

Route::get('section/parent/{parent_id}', 'SectionController@getParent');

Route::get('hadith/in/section/{parent_id}', 'SectionController@getHadith');

Route::get('hadiths/hadith/{hadith_id}', 'HadithController@index');

Route::get('chain/for/hadith/{hadith_id}', 'HadithController@getChain');

Route::get('comments/for/hadith/{hadith_id}', 'HadithCommentController@commentsForHadith');

Route::post('related/comments', 'HadithCommentController@relatedComments');

Route::get('translations/for/hadith/{hadith_id}', 'HadithTranslationController@translationsForHadith');

Route::get('bios/for/narrator/{narrator_id}', 'BioController@biosForNarrator');

Route::get('languages', 'LanguageController@index');

Route::get('related/hadith/for/hadith/{hadith_id}', 'HadithController@getLinkedHadith');

Route::get('suggested/hadith/for/hadith/{hadith_id}', 'HadithController@getSuggestedHadith');

Route::get('narrators/narrator/{narrator_id}', 'NarratorController@getById');

Route::get('teachers/for/narrator/{narrator_id}', 'NarratorController@getTeachers');

Route::get('students/for/narrator/{narrator_id}', 'NarratorController@getStudents');

Route::get('narrations/of/{student_id}/from/{teacher_id}', 'NarratorController@getNarrations');

Route::get('narrations/for/narrator/{narrator_id}', 'NarratorController@getAllNarrations');

Route::get('text/for/hadith/comment/{comment_id}', 'HadithCommentController@getText');

Route::get('text/for/bio/{bio_id}', 'BioController@getText');
//Route::get('getBook/for/section/{section_id}', 'SectionController@getBook');

Route::middleware('token', 'auth:api')->group(function(){

  //Route::middleware('auth:api')->group(function () {

      Route::get('logout', 'Auth\LoginController@logout');

      Route::get('user', 'UserController@index');

      Route::post('author/create', 'AuthorController@store');

      Route::post('bio_author/create', 'BioAuthorController@store');

      Route::post('narrator/create', 'NarratorController@store');

      Route::post('commentator/create', 'CommentatorController@store');

      Route::post('commentary/create', 'CommentaryController@store');

      Route::post('book/create', 'BookController@store');

      Route::post('book/edit/', 'BookController@update');

      Route::post('bio_book/create', 'BioBookController@store');

      Route::post('bio/create', 'BioController@store');

      Route::post('section/create', 'SectionController@store');

      Route::post('section/edit', 'SectionController@update');

      Route::post('hadith/create', 'HadithController@store');

      Route::post('hadith/edit', 'HadithController@update');

      Route::post('hadith_comment/create', 'HadithCommentController@store');

      Route::post('hadith_translation/create', 'HadithTranslationController@store');

      Route::post('addLink/to/hadith', 'HadithController@addLink');

      Route::post('hadith/link/with/hadith', 'HadithController@linkHadith');

      Route::post('language/create', 'LanguageController@store');

      Route::post('save-subscription', 'UserController@subscribeToPush');


      Route::group(['middleware' => ['role:super-admin']], function () {

        Route::post('send/push', 'UserController@sendPush');

        Route::get('users', 'UserController@getAll');

        Route::get('roles/for/user/{user_id}', 'UserController@getUserRoles');

        Route::get('permissions/for/role/{role_id}', 'UserController@getRolePermissions');

        Route::get('roles', 'UserController@getRoles');

        Route::get('permissions', 'UserController@getPermissions');

        Route::get('messages', 'MessageController@index');

        Route::post('role', 'UserController@createRole');

        Route::post('permission', 'UserController@createPermission');
        
      });

  //});

});



/*
Route::group(['middleware' => 'auth:api'], function(){

  Route::post('get-details', 'API\PassportController@getDetails');

});
*/

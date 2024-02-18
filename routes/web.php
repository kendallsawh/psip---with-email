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

Route::group(['namespace' => 'App\Http\Controllers'], function()
{   
     /**
         * Login Routes
         */
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');
    /**
     * Home Routes
     */
    Route::get('/', 'HomeController@index')->name('home.index');
    Route::get('/dl', 'HomeController@download');
    Route::get('/del', 'HomeController@cleaner');


    
    Route::get('autocomplete', 'SearchController@autocomplete')->name('autocomplete');
    

    Route::get('/dl2', 'HomeController@download2')->name('test');

    Route::group(['middleware' => ['guest']], function() {
        /**
         * Register Routes
         */
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        /**
         * Login Routes
         */
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');

    });

    Route::group(['middleware' => ['auth', 'permission']], function() {
        /**
         * Logout Routes
         */
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');

        Route::post('/search', 'SearchController@searchresult')->name('searchform');
        /**
         * User Routes
         */
        Route::group(['prefix' => 'users'], function() {
            Route::get('/', 'UsersController@index')->name('users.index');
            Route::get('/create', 'UsersController@create')->name('users.create');
            Route::post('/create', 'UsersController@store')->name('users.store');
            Route::get('/{user}/show', 'UsersController@show')->name('users.show');
            Route::get('/{user}/edit', 'UsersController@edit')->name('users.edit');
            Route::patch('/{user}/update', 'UsersController@update')->name('users.update');
            Route::delete('/{user}/delete', 'UsersController@destroy')->name('users.destroy');
        });

        /**
         * User Routes
         */
        Route::group(['prefix' => 'posts'], function() {
            Route::get('/', 'PostsController@index')->name('posts.index');
            Route::get('/create', 'PostsController@create')->name('posts.create');
            Route::post('/create', 'PostsController@store')->name('posts.store');
            Route::get('/{post}/show', 'PostsController@show')->name('posts.show');
            Route::get('/{post}/edit', 'PostsController@edit')->name('posts.edit');
            Route::patch('/{post}/update', 'PostsController@update')->name('posts.update');
            Route::delete('/{post}/delete', 'PostsController@destroy')->name('posts.destroy');
        });

        Route::group(['prefix' => 'psipupload'],function(){
            //Route::get('/{psip}/adddoc', 'PsipDocumentController@create')->name('psipupload.create');
            Route::post('/{activity}/psip_upload', 'PsipDocumentController@store')->name('psipupload.store');
            
            Route::get('/{psip}/edit', 'PsipDocumentController@edit')->name('psipupload.edit');
            Route::patch('/{psip}/update', 'PsipDocumentController@update')->name('psipupload.update');

            Route::get('/create/{activity}', 'PsipDocumentController@create')->name('psipupload.create');
            Route::post('/document/update/', 'PsipDocumentController@update')->name('psipdocument.update');


            Route::get('/get-psips/{division}', 'PsipDocumentController@getPsips')->name('get.psips');
            Route::get('/get-activities/{psip}', 'PsipDocumentController@getActivities')->name('get.activities');
            Route::post('/screening-brief/{psip}', 'PsipDocumentController@addScreeningBrief')->name('psipupload.addscreeningbrief');
            Route::post('/ps-note/{psip}', 'PsipDocumentController@addPSNote')->name('psipupload.addpsnote');//new route to add to permissions

            //Route::get('/show', 'PsipDocumentController@show')->name('psipupload.show');
        });

        Route::group(['prefix' => 'assign'],function(){
            Route::get('/document', 'PsipDocumentController@assign')->name('assign.create');
            Route::post('/document/store', 'PsipDocumentController@store_assign')->name('assign.store');

            /*ajax*/
            Route::get('/get-psips/{division}', 'PsipDocumentController@getPsips')->name('get.psips');
            Route::get('/get-activities/{psip}', 'PsipDocumentController@getActivities')->name('get.activities');
            Route::post('/searchDocTypeDivision', 'PsipDocumentController@searchDocTypeDivision')->name('activities.filltable');
        });

        Route::group(['prefix' => 'psip'],function(){
            Route::get('/{division}/index', 'PsipController@index')->name('psip.index');
            Route::get('/{psip}/show', 'PsipController@show')->name('psip.show');
            Route::get('/previous-years', 'PsipController@prev_yrs')->name('psip.prev_yrs');
            Route::get('/add', 'PsipController@create')->name('psip.create');
            Route::post('/store', 'PsipController@store')->name('psip.store');
            Route::get('/{id}/edit', 'PsipController@edit')->name('psip.edit');
            Route::put('/{id}', 'PsipController@update')->name('psip.update');
            Route::post('/approved-estimate/{psip}', 'PsipController@updateApproved')->name('psip.updatedapproveest');
            Route::post('/revised-estimate/{psip}', 'PsipController@updateRevised')->name('psip.updaterevisedest');
            Route::get('/{psipname}/projection', 'PsipProjectionController@create')->name('psip.projection');
            Route::post('/projection/{psipname}', 'PsipProjectionController@store')->name('psip.store_projection');
            Route::post('/current-expenditure/{psip}', 'PsipController@updateCurrentExpenditure')->name('psip.updatecurrexp');
            Route::post('/surpress-psip/{psip}', 'PsipController@surpressPsip')->name('psip.cancelpsip');
            Route::post('/psip-detail-edit/{psip}', 'PsipController@updatePsipDetail')->name('psip.editpsipdetails');//new route to add to permissions
            
           
        });

        Route::group(['prefix' => 'division'],function(){
            Route::get('/add', 'DivisionController@create')->name('division.create');
            Route::post('/store', 'DivisionController@store')->name('division.store');
            Route::get('/{id}/edit', 'DivisionController@edit')->name('division.edit');
            Route::patch('/{id}/update', 'DivisionController@update')->name('division.update');
        });

        Route::group(['prefix' => 'activity'],function(){           
           
            Route::get('/add', 'ActivityController@create')->name('activities.create');
            Route::post('/store', 'ActivityController@store')->name('activities.store');
            Route::get('/activity-edit/{psip}', 'ActivityController@edit')->name('activities.edit');//new route to add to permissions
            Route::post('/activity-update/{psip}', 'ActivityController@update')->name('activities.update');//new route to add to permissions
            Route::post('/surpress-activity', 'ActivityController@surpressActivity')->name('activities.surpressactivity');
            Route::post('/cancel-activity', 'ActivityController@softDelete')->name('activities.removeactivity');
            
        });

        Route::group(['prefix' => 'activity-photo'],function(){           
           
            Route::get('image-gallery/{id}', 'ActivityPhotoController@index')->name('activityphoto.index');
            Route::post('image-gallery/{id}', 'ActivityPhotoController@upload')->name('activityphoto.upload');
            Route::delete('image-gallery/{id}', 'ActivityPhotoController@destroy')->name('activityphoto.destroy');
            
        });

        
        // admin routes
        Route::get('/update_financial', 'OptionsController@update_psip')->name('update.psip.financials');
        Route::post('/update_financial', 'OptionsController@update_psip_store')->name('update.psip.financials.store');
        Route::get('/start-process', 'PsipController@startProcess')->name('update.all.psip');
        Route::get('/dataentry/{id}', 'DataEntryController@create')->name('dataentry.create');
        Route::post('/start_dataentry/{psip}', 'DataEntryController@store')->name('dataentry.store');

        Route::resource('roles', RolesController::class);
        Route::resource('permissions', PermissionsController::class);
    });
});
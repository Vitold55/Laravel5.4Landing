<?php

Route::group([], function () {

    Route::match(['get', 'post'], '/', ['uses' => 'IndexController@execute', 'as' => 'home']);
    Route::get('/page/{alias}', 'PageController@execute')->name('page');

    Route::auth();

});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

    Route::get('/', function() {
        if (view()->exists('admin.index')) {
            return view('admin.index', [
                'title' => 'Admin panel'
            ]);
        }
    });

    Route::group(['prefix' => 'pages'], function() {
        Route::get('/', 'PagesController@execute')->name('pages');
        Route::match(['get', 'post'], '/add', 'PagesAddController@execute')->name('pagesAdd');
        Route::match(['get', 'post', 'delete'], '/edit/{page}', 'PagesEditController@execute')->name('pagesEdit');
    });

    Route::group(['prefix' => 'portfolios'], function() {
        Route::get('/', 'PortfolioController@execute')->name('portfolio');
        Route::match(['get', 'post'], '/add', 'PortfolioAddController@execute')->name('portfolioAdd');
        Route::match(['get', 'post', 'delete'], '/edit/{portfolio}', 'PortfolioEditController@execute')->name('portfolioEdit');
    });

    Route::group(['prefix' => 'services'], function() {
        Route::get('/', 'ServiceController@execute')->name('services');
        Route::match(['get', 'post'], '/add', 'ServiceAddController@execute')->name('serviceAdd');
        Route::match(['get', 'post', 'delete'], '/edit/{service}', 'ServiceEditController@execute')->name('serviceEdit');
    });

});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

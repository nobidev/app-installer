<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use NobiDev\AppInstaller\Constant;

Route::group([
    'prefix' => 'install',
    'as' => Constant::getName() . '::',
    'namespace' => 'NobiDev\AppInstaller\Controllers',
    'middleware' => ['web', Constant::getName()]
], static function () {
    Route::get('/', ['as' => 'install.welcome', 'uses' => 'InstallWelcomeController@index']);
    Route::get('/server', ['as' => 'install.server', 'uses' => 'InstallServerController@index']);
    Route::get('/permission', ['as' => 'install.permission', 'uses' => 'InstallPermissionController@index']);
    Route::get('/database', ['as' => 'install.database', 'uses' => 'InstallDatabaseController@database']);
    Route::post('/database', ['as' => 'install.setDatabase', 'uses' => 'InstallDatabaseController@setDatabase']);
    Route::get('/migrations', ['as' => 'install.migrations', 'uses' => 'InstallDatabaseController@migrations']);
    Route::post('/migrations', ['as' => 'install.runMigrations', 'uses' => 'InstallDatabaseController@runMigrations']);
    Route::get('/keys', ['as' => 'install.keys', 'uses' => 'InstallKeysController@index']);
    Route::post('/keys', ['as' => 'install.setKeys', 'uses' => 'InstallKeysController@setKeys']);
    Route::get('/finish', ['as' => 'install.finish', 'uses' => 'InstallIndexController@finish']);
});

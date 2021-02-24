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
    Route::get('/database', ['as' => 'install.database', 'uses' => 'InstallDatabaseController@index']);
    Route::post('/database', ['uses' => 'InstallDatabaseController@submit']);
    Route::get('/migration', ['as' => 'install.migration', 'uses' => 'InstallMigrationController@index']);
    Route::post('/migration', ['uses' => 'InstallMigrationController@submit']);
    Route::get('/system', ['as' => 'install.system', 'uses' => 'InstallKeysController@index']);
    Route::post('/system', ['uses' => 'InstallKeysController@setKeys']);
    Route::get('/finish', ['as' => 'install.finish', 'uses' => 'InstallIndexController@finish']);
});

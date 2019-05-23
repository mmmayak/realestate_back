<?php


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {

    Route::post('login', 'AuthJWTController@login');
    Route::post('logout', 'AuthJWTController@logout');
    Route::post('register', 'AuthJWTController@register');
    Route::post('refresh', 'AuthJWTController@refresh');
    Route::post('me', 'AuthJWTController@me');

});

<?php

Route::fallback(function(){
    return response()->json(['error' => 'Error!','message' => 'Page Not Found.'], 404);
});

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

Route::prefix('files')->group(function () {
    
    Route::get('/all', 'FileController@index')->middleware(['jwt.verify:api']);
    Route::get('/download/{file}','FileController@getFile')->middleware(['jwt.verify:api']);
    Route::post('/store','FileController@store')->middleware(['jwt.verify:api','admin']);
    Route::delete('/{file}','FileController@destroy')->middleware(['jwt.verify:api','admin']);
 
});

Route::prefix('devtest')->group(function () {
   
    Route::get('admin', function () {
        return 'admin middleware done!';
    })->middleware(['jwt.verify','admin']); 
 
});

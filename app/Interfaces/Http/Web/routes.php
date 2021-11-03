<?php

/*
|--------------------------------------------------------------------------
| Tests
|--------------------------------------------------------------------------
*/
Route::get('/test', '\Solutions\Interfaces\Http\Web\Controllers\TestController@test');

Route::fullApiResource('/analytics', '\Solutions\Interfaces\Http\Api\Controllers\AnalyticsController');

Route::any('/aws/sns', '\Rennokki\LaravelSnsEvents\Http\Controllers\SnsController@handle');

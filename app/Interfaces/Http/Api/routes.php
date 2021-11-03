<?php

Route::prefix('api')->middleware('api')->group(function ($route) {

});

Route::prefix('api')->middleware('auth:api')->group(function ($route) {
  $route->fullApiResource('example-entity', 'ExampleEntityController');
});

Route::prefix('wapi')->middleware('api')->group(function ($route) {

});

Route::prefix('capi')->middleware('client')->group(function($route){

});

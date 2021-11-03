<?php

return [

  /*
    |--------------------------------------------------------------------------
    | Bundle Namespace
    |--------------------------------------------------------------------------
    |
    | Set bundle root namespace (app directory).
    */
  'namespace' => env('APP_NAMESPACE', 'Solutions'),

  /*
    |--------------------------------------------------------------------------
    | Exceptions Handler
    |--------------------------------------------------------------------------
    */
  'exceptions' => [
    'handler' => \Bifrost\Exceptions\Handler::class,
  ],

  /*
    |--------------------------------------------------------------------------
    | Console and HTTP Kernel
    |--------------------------------------------------------------------------
    */
  'console' => [
    'kernel' => \Bifrost\Console\Kernel::class,
  ],
  'http' => [
    'kernel' => \Solutions\Interfaces\Http\Kernel::class,
    'service_provider' => \Solutions\Infrastructure\Providers\RouteServiceProvider::class,
    'proxies' => '*',
    'proxies_headers' => \Illuminate\Http\Request::HEADER_X_FORWARDED_AWS_ELB,
    'api' => [
      'rate_limit' => 60,
    ],
    'wapi' => [
      'connection' => 'passport',
      'table' => 'wapi_tokens',
      'key' => env('WAPI_KEY'),
    ],
  ],

  /*
    |--------------------------------------------------------------------------
    | Application ORM Driver
    |--------------------------------------------------------------------------
    |
    | This value determines the driver that your application must use
    | when dealing with data and persistence.
    |
    */
  'orm' => [
    'driver' => 'eloquent',
    'pagination' => [
      'default_per_page' => 25,
    ],
  ],

  /*
    |--------------------------------------------------------------------------
    | Application Modules
    |--------------------------------------------------------------------------
    |
    | Lists all bundles of your application, including some
    | important information about them.
    */
  'bundle_basedir' => 'app',
  'modules' => [],
];


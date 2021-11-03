<?php

use Illuminate\Support\Str;

return [

  /*
  |--------------------------------------------------------------------------
  | Default Cache Store
  |--------------------------------------------------------------------------
  |
  | This option controls the default cache connection that gets used while
  | using this caching library. This connection is used when another is
  | not explicitly specified when executing a given caching function.
  |
  | Supported: "apc", "array", "database", "file",
  |            "memcached", "redis", "dynamodb"
  |
  */

  'default' => env('CACHE_DRIVER', 'file'),

  /*
  |--------------------------------------------------------------------------
  | Cache Stores
  |--------------------------------------------------------------------------
  |
  | Here you may define all of the cache "stores" for your application as
  | well as their drivers. You may even define multiple stores for the
  | same cache driver to group types of items stored in your caches.
  |
  */

  'stores' => [

    'database' => [
      'driver' => 'database',
      'table' => 'cache',
      'connection' => null,
    ],

    'file' => [
      'driver' => 'file',
      'path' => storage_path('framework/cache/data'),
    ],

    'redis' => [
      'driver' => 'redis',
      'connection' => 'default',
    ],

    'session' => [
      'driver' => 'redis',
      'connection' => 'session',
    ],

    'shared' => env('APP_ENV') === 'production'
      ? [
      'driver' => 'redis',
      'connection' => 'shared',
    ] : [
      'driver' => 'dynamodb',
      'key' => env('AWS_USER_ACCESS_KEY_ID'),
      'secret' => env('AWS_USER_SECRET_ACCESS_KEY'),
      'region' => env('AWS_DYNAMODB_REGION', 'sa-east-1'),
      'table' => env('AWS_DYNAMODB_SHARED_CACHE_TABLE', 'platafoor-shared'),
      'endpoint' => env('AWS_DYNAMODB_ENDPOINT'),
    ],

    'responsecache' => env('APP_ENV') !== 'production'
      ? 'file'
      : [
      'driver' => 'redis',
      'connection' => 'responsecache',
    ],

    'dynamodb' => [
      'driver' => 'dynamodb',
      'key' => env('AWS_USER_ACCESS_KEY_ID'),
      'secret' => env('AWS_USER_SECRET_ACCESS_KEY'),
      'region' => env('AWS_DYNAMODB_REGION', 'sa-east-1'),
      'table' => env('AWS_DYNAMODB_CACHE_TABLE', 'cache'),
      'endpoint' => env('AWS_DYNAMODB_ENDPOINT'),
    ],

    'dynamodb_session' => [
      'driver' => 'dynamodb',
      'key' => env('AWS_USER_ACCESS_KEY_ID'),
      'secret' => env('AWS_USER_SECRET_ACCESS_KEY'),
      'region' => env('AWS_DYNAMODB_REGION', 'sa-east-1'),
      'table' => env('AWS_DYNAMODB_SESSION_TABLE', 'sessions'),
      'endpoint' => env('AWS_DYNAMODB_ENDPOINT'),
    ],

  ],

  /*
  |--------------------------------------------------------------------------
  | Cache Key Prefix
  |--------------------------------------------------------------------------
  |
  | When utilizing a RAM based store such as APC or Memcached, there might
  | be other applications utilizing the same cache. So, we'll specify a
  | value to get prefixed to all our keys so we can avoid collisions.
  |
  */

  'prefix' => env('CACHE_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . '_cache'),

];

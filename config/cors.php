<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Cross-Origin Resource Sharing (CORS) Configuration
  |--------------------------------------------------------------------------
  |
  | Here you may configure your settings for cross-origin resource sharing
  | or "CORS". This determines what cross-origin operations may execute
  | in web browsers. You are free to adjust these settings as needed.
  |
  | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
  |
  */

  'paths' => ['*'],

  'allowed_methods' => ['*'],

  'allowed_origins' => [],

  'allowed_origins_patterns' => [],

  'allowed_headers' => [
    'Content-Type',
    'X-Auth-Token',
    'Origin',
    'Authorization',
    'x-hmac',
  ],

  'exposed_headers' => [],

  'max_age' => 0,

  'supports_credentials' => false,

  /*
   * A cors profile determines which origins, methods, headers are allowed for
   * a given requests. If not set configurations will be read from this config file.
   *
   */
  'profile' => \Platafoor\Microservices\Interfaces\Http\CorsProfile::class,

];

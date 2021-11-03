<?php

$bifrostConfig = include realpath(__DIR__ . '/../config/bifrost.php');

$bifrostHttpKernel =
  isset($bifrostConfig['http']) && isset($bifrostConfig['http']['kernel']) &&
  is_string($bifrostConfig['http']['kernel']) && class_exists($bifrostConfig['http']['kernel'])
    ? $bifrostConfig['http']['kernel']
    : \Bifrost\Http\Kernel::class;

$bifrostConsoleKernel =
  isset($bifrostConfig['console']) && isset($bifrostConfig['console']['kernel']) &&
  is_string($bifrostConfig['console']['kernel']) && class_exists($bifrostConfig['console']['kernel'])
    ? $bifrostConfig['console']['kernel']
    : \Bifrost\Console\Kernel::class;

$bifrostExceptionsHandler =
  isset($bifrostConfig['exceptions']) && isset($bifrostConfig['exceptions']['handler']) &&
  is_string($bifrostConfig['exceptions']['handler']) && class_exists($bifrostConfig['exceptions']['handler'])
    ? $bifrostConfig['exceptions']['handler']
    : \Bifrost\Console\Kernel::class;

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
  realpath(__DIR__ . '/../')
);

/*
 * Allow overriding the storage path in production using an environment variable.
 */
$app->useStoragePath($_ENV['APP_STORAGE'] ?? $app->storagePath());

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
  Illuminate\Contracts\Http\Kernel::class,
  $bifrostHttpKernel
);

$app->singleton(
  Illuminate\Contracts\Console\Kernel::class,
  $bifrostConsoleKernel
);

$app->singleton(
  Illuminate\Contracts\Debug\ExceptionHandler::class,
  $bifrostExceptionsHandler
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;

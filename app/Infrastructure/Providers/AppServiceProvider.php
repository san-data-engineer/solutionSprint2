<?php

namespace Solutions\Infrastructure\Providers;

use Illuminate\Support\Facades\App;
use Bifrost\Providers\AppServiceProvider as BifrostAppServiceProvider;

/**
 * Class AppServiceProvider
 * @package Integration\Infrastructure\Providers
 */
class AppServiceProvider extends BifrostAppServiceProvider
{

  /**
   * All app modules fetched from kernel config.
   *
   * @var array
   */
  protected $modules = [];

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {

    $this->ensureCacheDirectoriesExists();
//    $this->ensurePassportKeysExists();

    /*
    |--------------------------------------------------------------------------
    | Locale config
    |--------------------------------------------------------------------------
    */
    App::setLocale('pt-BR');
    \Carbon\Carbon::setLocale('pt-BR');
  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * @return void
   */
  private function ensureCacheDirectoriesExists()
  {
    if (env('APP_ENV') === 'local') {
      return;
    }

    $viewCachePath = storage_path('storage/framework/views');
    if (! is_dir($viewCachePath)) {
      mkdir($viewCachePath, 0755, true);
    }

    $cachePath = storage_path('storage/framework/cache/data');
    if (! is_dir($cachePath)) {
      mkdir($cachePath, 0755, true);
    }
  }

  /**
   * @return void
   */
  private function ensurePassportKeysExists()
  {
    if (env('APP_ENV') === 'local') {
      return;
    }

    $privateKeyPath = storage_path('oauth-private.key');
    $publicKeyPath = storage_path('oauth-public.key');

    if (is_file($privateKeyPath) && is_readable($privateKeyPath) && is_file($publicKeyPath) && is_readable($publicKeyPath)) {
      return;
    }

    $keys = $this->getKeysFromSecretsManager();

    file_put_contents($privateKeyPath, $keys['private']);
    file_put_contents($publicKeyPath, $keys['public']);
    chmod($privateKeyPath, 0660);
    #chown($privateKeyPath, 'www-data');
    #chgrp($privateKeyPath, 'www-data');
    chmod($publicKeyPath, 0660);
    #chown($publicKeyPath, 'www-data');
    #chgrp($publicKeyPath, 'www-data');
  }

  /**
   * @return array
   */
  private function getKeysFromSecretsManager(): array
  {
    $sdk = new \Aws\Sdk(['credentials' => [
      'key' => env('ACCESS_KEY'),
      'secret' => env('SECRET_KEY'),
    ]]);

    $client = $sdk->createSecretsManager(['region' => 'sa-east-1', 'version' => 'latest']);

    $result = $client->getSecretValue([
      'SecretId' => 'pop-gateway', // 'passport-' . env('APP_ENV'),
    ]);

    $secret = isset($result['SecretString']) ? $result['SecretString'] : base64_decode($result['SecretBinary']);

    return json_decode(str_replace(array("\r", "\n"), '', $secret), true);
  }
}

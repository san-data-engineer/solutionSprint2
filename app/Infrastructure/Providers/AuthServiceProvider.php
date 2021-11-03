<?php

namespace Solutions\Infrastructure\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{

  /**
   * The policy mappings for the application.
   *
   * @var array
   */
  protected $policies = [
    'Kernel\Model' => 'Kernel\Domain\Policies\ModelPolicy',
  ];

  public function boot()
  {
    $this->registerPolicies();

    /***************************************************************************
     *                               Passport
     **************************************************************************/

    $days = request()->get('days_to_expire', 30);
    $expiresIn = now()->addDays($days);

    Passport::routes();
    Passport::tokensExpireIn($expiresIn);
    Passport::refreshTokensExpireIn($expiresIn);
    Passport::personalAccessTokensExpireIn($expiresIn);

    Passport::tokensCan([

    ]);

  }
}

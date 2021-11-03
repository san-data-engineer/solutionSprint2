<?php

namespace Solutions\Infrastructure\Providers;

use Solutions\Infrastructure\Listeners\SNSListener;
use Rennokki\LaravelSnsEvents\Events\SnsNotification;
use Bifrost\Providers\EventServiceProvider as ServiceProvider;
use Rennokki\LaravelSnsEvents\Events\SnsSubscriptionConfirmation;

class EventServiceProvider extends ServiceProvider
{
  /**
   * The event listener mappings for the application.
   *
   * @var array
   */
  protected $listen = [
    SnsNotification::class => [
      SNSListener::class
    ],
    SnsSubscriptionConfirmation::class => [

    ],
  ];

  /**
   * Register any events for your application.
   *
   * @return void
   */
  public function boot()
  {
    parent::boot();
  }
}


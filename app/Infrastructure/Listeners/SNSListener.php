<?php

namespace Solutions\Infrastructure\Listeners;

use Illuminate\Support\Facades\Log;
use Platafoor\Microservices\Listeners\SnsListener as Listener;

/**
 * Class SNSListener
 * @package Solutions\Infrastructure\Listeners
 */
class SNSListener extends Listener
{
  /**
   * @param mixed $event
   * @return void|null
   * @throws \Exception
   */
  public function handle($event)
  {

    parent::handle($event);

    Log::debug(class_basename($this->message['subject']));

    switch (class_basename($this->message['subject'])) {

    }
  }
}

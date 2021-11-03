<?php

namespace Solutions\Application\Services;

use Solutions\Application\Transformers\ExampleEntityApplicationTransformer;
use Solutions\Domain\Services\ExampleEntityDomainService;
use Solutions\Infrastructure\Repositories\ExampleEntityRepository;
use Bifrost\Services\ApplicationService;

class ExampleEntityApplicationService extends ApplicationService
{

  public function __construct (
    ?ExampleEntityDomainService $service = null,
    ?ExampleEntityApplicationTransformer $transformer = null,
    ?ExampleEntityRepository $repository = null
  )
  {
    parent::__construct($service, $transformer, $repository);
  }
}

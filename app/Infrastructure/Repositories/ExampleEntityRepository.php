<?php

namespace Solutions\Infrastructure\Repositories;

use Bifrost\Repositories\EntityRepository;
use Solutions\Domain\Models\ExampleEntity;

class ExampleEntityRepository extends EntityRepository
{

  protected string $entityClassName = ExampleEntity::class;
  protected string $defaultSort = '';
  protected array $allowedSorts = ['created_at'];
  protected array $allowedFields = [];
  protected array $allowedIncludes = [];
  protected array $allowedAppends = [];
  protected array $exactFilters = [];
  protected array $partialFilters = [];

}

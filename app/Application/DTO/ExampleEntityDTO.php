<?php

namespace Solutions\Application\DTO;

use Bifrost\DTO\DataTransferObject;
use Carbon\Carbon;

class ExampleEntityDTO extends DataTransferObject
{
  public ?string $id;
  public ?Carbon $createdAt;
  public ?Carbon $updatedAt;
  public ?bool $active;
  public ?string $appId;

}

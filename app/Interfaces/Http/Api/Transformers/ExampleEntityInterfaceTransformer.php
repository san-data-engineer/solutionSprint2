<?php

namespace Solutions\Interfaces\Http\Api\Transformers;

use Solutions\Domain\Models\ExampleEntity;
use Bifrost\Transformers\InterfaceTransformer;

class ExampleEntityInterfaceTransformer extends InterfaceTransformer
{
  protected $availableIncludes = [];

  /**
   * @param ExampleEntity $exampleEntity
   * @return array
   */
  public function transform(ExampleEntity $exampleEntity)
  {
    return [
      'id' => $exampleEntity->id,
      'created_at' => $exampleEntity->created_at,
      'updated_at' => $exampleEntity->updated_at,
      'active' => $exampleEntity->active,
      'app_id' => $exampleEntity->app_id
    ];
  }

}

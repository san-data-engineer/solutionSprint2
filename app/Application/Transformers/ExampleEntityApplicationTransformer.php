<?php

namespace Solutions\Application\Transformers;

use Solutions\Application\DTO\ExampleEntityDTO;
use Solutions\Domain\Models\ExampleEntity;
use Bifrost\DTO\DataTransferObject;
use Bifrost\Models\Model;
use Bifrost\Transformers\ApplicationTransformer;

class ExampleEntityApplicationTransformer extends ApplicationTransformer
{
  /**
   * @param ExampleEntityDTO $dto
   * @return ExampleEntity
   */
  public function toModel(DataTransferObject $dto): Model
  {
    $model = new ExampleEntity();

    $model->id = $dto->id;
    $model->created_at = $dto->createdAt;
    $model->updated_at = $dto->updatedAt;
    $model->active = $dto->active;
    $model->app_id = $dto->appId;

    return $model;
  }

  /**
   * @param ExampleEntity $model
   * @param ExampleEntityDTO $dto
   */
  public function prepareForUpdate(Model &$model, DataTransferObject $dto)
  {
    call_if($dto->filled('app_id'), fn() => $model->app_id = $dto->appId);
  }
}

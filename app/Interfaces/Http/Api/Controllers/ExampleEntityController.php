<?php

namespace Solutions\Interfaces\Http\Api\Controllers;

use Solutions\Application\DTO\ExampleEntityDTO;
use Solutions\Application\Services\ExampleEntityApplicationService;
use Solutions\Domain\Models\ExampleEntity;
use Solutions\Interfaces\Http\Api\Transformers\ExampleEntityInterfaceTransformer;
use Solutions\Interfaces\Http\Requests\ExampleEntityRequest;
use Bifrost\Http\Api\Controllers\Controller;

class ExampleEntityController extends Controller
{
  public function __construct(ExampleEntityApplicationService $service, ExampleEntityInterfaceTransformer $transformer)
  {
    parent::__construct($service, $transformer);
  }

  /**
   * @param ExampleEntityRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(ExampleEntityRequest $request)
  {
    return $this->findPaginated($request);
  }

  /**
   * @param ExampleEntity $exampleEntity
   * @return \Illuminate\Http\JsonResponse
   */
  public function show(ExampleEntity $exampleEntity)
  {
    return $this->executeShow($exampleEntity);
  }

  /**
   * @param ExampleEntityRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(ExampleEntityRequest $request)
  {
    $dto = ExampleEntityDTO::fromRequest($request);

    return $this->executeStore($dto);
  }

  /**
   * @param ExampleEntity $exampleEntity
   * @param ExampleEntityRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(ExampleEntity $exampleEntity, ExampleEntityRequest $request)
  {
    $dto = ExampleEntityDTO::fromRequest($request);

    return $this->executeUpdate($exampleEntity, $dto);
  }

  /**
   * @param ExampleEntity $exampleEntity
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception
   */
  public function trash(ExampleEntity $exampleEntity)
  {
    return $this->executeTrash($exampleEntity);
  }

  /**
   * @param ExampleEntityRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception
   */
  public function trashMultiple(ExampleEntityRequest $request)
  {
    return $this->executeTrashMultiple($request);
  }

  /**
   * @param ExampleEntity $exampleEntity
   * @return \Illuminate\Http\JsonResponse
   */
  public function untrash(ExampleEntity $exampleEntity)
  {
    return $this->executeUntrash($exampleEntity);
  }

  /**
   * @param ExampleEntityRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception
   */
  public function untrashMultiple(ExampleEntityRequest $request)
  {
    return $this->executeUntrashMultiple($request);
  }
}

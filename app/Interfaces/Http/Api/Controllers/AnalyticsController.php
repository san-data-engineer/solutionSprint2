<?php

namespace Solutions\Interfaces\Http\Api\Controllers;

use Illuminate\Http\Request;
use Bifrost\Http\Web\Controllers\Controller;

class AnalyticsController extends Controller
{
  /**
   * AnalyticsController constructor.
   * @param AnalyticsApplicationService $service
   * @param AnalyticsTransformer $transformer
   */
  public function __construct(AnalyticsApplicationService $service, AnalyticsTransformer $transformer)
  {
    parent::__construct($service, $transformer);
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function index(Request $request)
  {
    return parent::findPaginated($request);
  }

  /**
   * @param Analytics $site
   * @return JsonResponse
   */
  public function show(Analytics $site)
  {
    return $this->response($site, 200);
  }

  /**
   * @param AnalyticsRequest $request
   * @return JsonResponse
   */
  public function store(AnalyticsRequest $request)
  {
    $dto = AnalyticsDTO::fromRequest($request);

    $site = $this->service->create($dto);

    return $this->response($site, 201);
  }

  /**
   * @param Analytics $site
   * @param AnalyticsRequest $request
   * @return JsonResponse
   */
  public function update(Analytics $site, AnalyticsRequest $request)
  {
    $dto = AnalyticsDTO::fromRequest($request);
    $dto->id = $site->id;

    $site = $this->service->update($site, $dto);

    return $this->response($site, 201);
  }

}

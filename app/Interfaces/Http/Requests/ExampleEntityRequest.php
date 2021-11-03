<?php

namespace Solutions\Interfaces\Http\Requests;

use Bifrost\Http\Requests\FormRequest;

class ExampleEntityRequest extends FormRequest
{
  protected function store(): array
  {
    return [
      'app_id' => 'string|required',
    ];
  }

  protected function update(): array
  {
    return [
      'app_id' => 'string'
    ];
  }
}

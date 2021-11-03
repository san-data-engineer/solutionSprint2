<?php

namespace Solutions\Domain\Models;

use Bifrost\Models\Model;
use Carbon\Carbon;

/**
 * Class ExampleEntity
 * @package Solutions\Domain\Models
 *
 * @property string $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $app_id
 * @property bool $active
 */
class ExampleEntity extends Model
{

  protected $table = 'schema.table';

  public $casts = [
    'id' => 'string',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
    'app_id' => 'string',
    'active' => 'bool',
  ];

  public $fillable = [
    'id',
    'created_at',
    'updated_at',
    'app_id',
    'active',
  ];
}

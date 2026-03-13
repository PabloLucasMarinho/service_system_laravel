<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @mixin Model
 */
trait UserDetailDefaults
{
  protected static function bootUserDetailDefaults(): void
  {
    static::creating(function (Model $model) {
      if (empty($model->uuid)) {
        $model->uuid = (string)Str::uuid();
      }
    });
  }
}

<?php

namespace App\Models;

use App\Models\Traits\UserClientDefaults;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
  use UserClientDefaults;

  protected $primaryKey = 'uuid';
  protected $keyType = 'string';
  public $incrementing = false;

  protected $fillable = ['user_uuid', 'name', 'document', 'date_of_birth', 'phone',];

  protected $casts = ['date_of_birth' => 'date'];


  public function creator(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_uuid', 'uuid');
  }

  public function getRouteKeyName(): string
  {
    return 'uuid';
  }

  public function getDateOfBirthFormattedAttribute(): string
  {
    return $this->attributes['date_of_birth'] ? Carbon::parse($this->attributes['date_of_birth'])->format('d/m/Y') : '';
  }
}

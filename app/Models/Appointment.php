<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
  protected $primaryKey = 'uuid';
  protected $keyType = 'string';
  public $incrementing = false;

  protected $fillable = [
    'user_uuid',
    'client_uuid',
    'scheduled_at',
    'notes',
    'status'
  ];

  public function appointmentServices(): HasMany
  {
    return $this->hasMany(AppointmentService::class, 'appointment_uuid', 'uuid');
  }

  public function client(): BelongsTo
  {
    return $this->belongsTo(Client::class, 'client_uuid', 'uuid');
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_uuid', 'uuid');
  }

  protected $casts = [
    'scheduled_at' => 'datetime',
    'status' => AppointmentStatus::class
  ];

  public function getTotalAttribute(): float
  {
    return round($this->appointmentServices->sum(fn($s) => (float)$s->final_price), 2);
  }

  public function getFormattedTotalAttribute(): string
  {
    return number_format($this->total, 2, ',', '.');
  }
}

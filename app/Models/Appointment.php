<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    const SERVICE_NEW_ABAYA = 'new_abaya';
    const SERVICE_ALTERATION = 'alteration';
    const SERVICE_REPAIR = 'repair';

    protected $fillable = [
        'user_id',
        'service_type',
        'appointment_date',
        'appointment_time',
        'status',
        'notes',
        'phone'
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
        'appointment_time' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedDateAttribute()
    {
        return $this->appointment_date->format('F j, Y');
    }

    public function getFormattedTimeAttribute()
    {
        return $this->appointment_time->format('g:i A');
    }
}

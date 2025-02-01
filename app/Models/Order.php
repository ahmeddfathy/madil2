<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    const PAYMENT_METHOD_CASH = 'cash';
    const PAYMENT_METHOD_CARD = 'card';

    const PAYMENT_STATUS_PENDING = 'pending';
    const PAYMENT_STATUS_PAID = 'paid';
    const PAYMENT_STATUS_FAILED = 'failed';

    const ORDER_STATUS_PENDING = 'pending';
    const ORDER_STATUS_PROCESSING = 'processing';
    const ORDER_STATUS_COMPLETED = 'completed';
    const ORDER_STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id',
        'total_amount',
        'shipping_address',
        'phone',
        'payment_method',
        'payment_status',
        'order_status',
        'notes'
    ];

    protected $casts = [
        'total_amount' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Helper methods for status checks
    public function isPending(): bool
    {
        return $this->order_status === self::ORDER_STATUS_PENDING;
    }

    public function isProcessing(): bool
    {
        return $this->order_status === self::ORDER_STATUS_PROCESSING;
    }

    public function isCompleted(): bool
    {
        return $this->order_status === self::ORDER_STATUS_COMPLETED;
    }

    public function isCancelled(): bool
    {
        return $this->order_status === self::ORDER_STATUS_CANCELLED;
    }

    public function isPaymentPending(): bool
    {
        return $this->payment_status === self::PAYMENT_STATUS_PENDING;
    }

    public function isPaymentPaid(): bool
    {
        return $this->payment_status === self::PAYMENT_STATUS_PAID;
    }

    public function isPaymentFailed(): bool
    {
        return $this->payment_status === self::PAYMENT_STATUS_FAILED;
    }
}

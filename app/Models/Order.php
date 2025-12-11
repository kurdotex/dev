<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_first_name',
        'customer_last_name',
        'customer_email',
        'status',
        'payment_method',
        'total_amount',
    ];

    public function items(): HasMany {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeEvent extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = [
        'event_id',
        'amount_paid',
        'event_date',
    ];
}

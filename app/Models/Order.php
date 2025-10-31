<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'album_id',
        'total_price',
    ];

    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2',
        ];
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}

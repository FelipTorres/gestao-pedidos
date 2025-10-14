<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property float $subtotal
 * @property float $freight
 * @property float $total
 * @property string $status
 * @property string $cep
 * @property string $address
 * @property int|null $coupon_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static Order create(array $validate)
 * @method static Order findOrFail(int $id)
 * @method static Order where(string $column, mixed $value)
 * @method Order first()
 */
class Order extends Model
{
    protected $fillable = [
        'subtotal',
        'freight',
        'total',
        'status',
        'cep',
        'address',
        'coupon_id'
    ];

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItems::class, 'order_id');
    }

    public static function applyFreight(float $subtotalWithDiscount): float
    {
        return match (true) {
            $subtotalWithDiscount >= 52 && $subtotalWithDiscount <= 166.59 => 15.00,
            $subtotalWithDiscount > 200 => 0.00,
            default => 20.00,
        };
    }

    public static function buildAddress(array $validated): string
    {
        return $validated['logradouro'] . ', ' . $validated['numero'] . ' - ' . $validated['bairro'] . ', ' . $validated['cidade'] . ' - ' . $validated['uf'] . ($validated['complemento'] ? (', ' . $validated['complemento']) : '');
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int|null $variation_id
 * @property string $name
 * @property float $price
 * @property int $quantity
 * @property float $total
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static OrderItems create(array $validate)
 * @method static OrderItems findOrFail(int $id)
 */
class OrderItems extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'variation_id',
        'name',
        'price',
        'quantity',
        'total',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class, 'variation_id');
    }

    public static function createItems(array $item, int $orderId): void
    {
        OrderItems::create([
            'order_id' => $orderId,
            'product_id' => $item['product_id'],
            'variation_id' => $item['variation_id'],
            'name' => $item['name'],
            'price' => $item['price'],
            'quantity' => $item['quantity'],
            'total' => $item['price'] * $item['quantity'],
        ]);
    }
}

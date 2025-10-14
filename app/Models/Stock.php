<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $product_id
 * @property int $variation_id
 * @property int $quantity
 *
 * @method static Stock create(array $attributes)
 * @method static Stock where(string $column, mixed $value)
 * @method static Stock first()
 * @method static Stock whereNull(string $column)
 * @method static Stock findOrFail(int $id)
 * @method static Stock decrement(string $column, int $amount)
 */
class Stock extends Model
{
    protected $fillable = ['product_id', 'variation_id', 'quantity'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public static function updateStock(array $item): void
    {
        $stockQuery = Stock::where('product_id', $item['product_id']);

        $item['variation_id']
            ? $stockQuery->where('variation_id', $item['variation_id'])
            : $stockQuery->whereNull('variation_id')
        ;

        $stock = $stockQuery->first();
        if ($stock && $stock->quantity >= $item['quantity']) {
            $stock->decrement('quantity', $item['quantity']);
        }
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static ProductVariation create(array $validate)
 * @method static ProductVariation findOrFail(int $id)
 */
class ProductVariation extends Model
{
    protected $fillable = ['product_id', 'name'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'variation_id');
    }
}

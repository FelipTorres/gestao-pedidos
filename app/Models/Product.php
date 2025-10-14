<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property float $price
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static Product create(array $validate)
 * @method static Product findOrFail(int $id)
 */
class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['name', 'price'];

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class);
    }

    public static function createWithVariationsAndStock(array $validated): void
    {
        $product = Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
        ]);

        if (!empty($validated['variations'])) {
            foreach ($validated['variations'] as $variationData) {
                $variation = $product->variations()->create([
                    'name' => $variationData['name'],
                ]);

                $product->stocks()->create([
                    'variation_id' => $variation->id,
                    'quantity' => $variationData['stock'],
                ]);
            }
        } else {
            $product->stocks()->create([
                'quantity' => $validated['stock'] ?? 0,
            ]);
        }
    }

    public function verifyIfRemovedVariations(): self
    {
        $existingVariationIds = $this->variations()->pluck('id')->toArray();
        $sentVariationIds = collect($validated['variations'] ?? [])
            ->pluck('id')
            ->filter()
            ->map(fn($v) => (int)$v)
            ->toArray()
        ;

        $toDelete = array_diff($existingVariationIds, $sentVariationIds);

        if (!empty($toDelete)) {
            $this->variations()->whereIn('id', $toDelete)->delete();
            $this->stocks()->whereIn('variation_id', $toDelete)->delete();
        }

        return $this;
    }

    public function updateVariationsAndStock(array $validated): void
    {
        if (!empty($validated['variations'])) {
            foreach ($validated['variations'] as $data) {
                $variation = !empty($data['id'])
                    ? $this->variations()->find($data['id'])
                    : $this->variations()->create(['name' => $data['name']]);

                if ($variation) {
                    if (!empty($data['id'])) {
                        $variation->update(['name' => $data['name']]);
                    }

                    $this->stocks()->updateOrCreate(
                        ['variation_id' => $variation->id],
                        ['quantity' => $data['stock']]
                    );
                }
            }

            $this->stocks()->whereNull('variation_id')->delete();
        } else {
            $this->stocks()
                ->updateOrCreate(
                    ['variation_id' => null],
                    ['quantity' => $validated['stock'] ?? 0]
                )
            ;

            $this->variations()->delete();
            $this->stocks()->whereNotNull('variation_id')->delete();
        }
    }
}

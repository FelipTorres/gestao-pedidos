<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

/**
 * @property int $id
 * @property string $code
 * @property float $discount
 * @property float $min_value
 * @property string $validity
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static Coupon create(array $validate)
 * @method static Coupon findOrFail(int $id)
 * @method static Coupon where(string $column, mixed $value)
 * @method Coupon first()
 */
class Coupon extends Model
{
    protected $table = 'coupons';
    protected $fillable = ['code', 'discount', 'min_value', 'validity'];

    public static function getSubtotalAddedToCart(array $cart): float
    {
        return collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public static function validateCoupon(array $validated): Coupon
    {
        $coupon = Coupon::where('code', $validated['code'])->first();
        if (!$coupon) {
            throw new \Exception('Cupom não encontrado.');
        }

        $subTotal = $coupon->getSubtotalAddedToCart(Session::get('cart', []));

        if ($coupon->validity < now()) {
            throw new \Exception('Cupom expirado.');
        }

        if ($subTotal < $coupon->min_value) {
            throw new \Exception('Valor mínimo para uso do cupom não atingido.');
        }

        return $coupon;
    }

    public static function calculateDiscount(?array $coupon, float $subTotal): float
    {
        $discount = $coupon ? ($subTotal * ($coupon['discount'] / 100)) : 0;

        return $subTotal - $discount;
    }
}

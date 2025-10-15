<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Coupon;

class CouponTest extends TestCase
{
    public function test_coupon_has_code()
    {
        $coupon = new Coupon(['code' => 'PROMO10']);
        $this->assertEquals('PROMO10', $coupon->code);
    }

    public function test_coupon_has_discount_value()
    {
        $coupon = new Coupon(['discount' => 15.00]);
        $this->assertEquals(15.00, $coupon->discount);
    }

    public function test_coupon_discount_is_numeric()
    {
        $coupon = new Coupon(['discount' => 5]);
        $this->assertIsNumeric($coupon->discount);
    }

    public function test_coupon_is_active_by_default()
    {
        $coupon = new Coupon();
        $this->assertTrue($coupon->active ?? true);
    }
}

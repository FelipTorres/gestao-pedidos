<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    public function test_product_has_name()
    {
        $product = new Product(['name' => 'Test Product']);
        $this->assertEquals('Test Product', $product->name);
    }

    public function test_product_has_price()
    {
        $product = new Product(['price' => 99.99]);
        $this->assertEquals(99.99, $product->price);
    }

    public function test_product_can_set_and_get_description()
    {
        $product = new Product();
        $product->description = 'A simple description';
        $this->assertEquals('A simple description', $product->description);
    }

    public function test_product_price_is_numeric()
    {
        $product = new Product(['price' => 10.50]);
        $this->assertIsNumeric($product->price);
    }

    public function test_product_default_stock_is_zero()
    {
        $product = new Product();
        $this->assertEquals(0, $product->stock ?? 0);
    }
}

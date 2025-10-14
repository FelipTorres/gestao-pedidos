<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->decimal('subtotal', 10);
            $table->decimal('freight', 10);
            $table->decimal('total', 10);
            $table->string('status')->default('novo');
            $table->string('cep');
            $table->string('address');
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

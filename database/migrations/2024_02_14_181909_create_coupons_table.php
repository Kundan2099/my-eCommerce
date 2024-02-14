<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('summary')->nullable();
            $table->date('start_date');
            $table->date('expiry_date');
            $table->enum('discount_type',array_column(CouponDiscountType::cases(), 'value'));
            $table->decimal('discount_value', 10, 2);
            $table->decimal('minimum_purchase', 10, 2);
            $table->decimal('maximum_discount', 10, 2);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};

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
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id')->from(100001);
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->string('thumbnail_image')->nullable();
            $table->string('cover_image')->nullable();
            $table->integer('commission_percentage')->nullable();
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
        Schema::dropIfExists('services');
    }
};

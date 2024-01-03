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
        Schema::create('mst_products', function (Blueprint $table) {
            $table->string('id', 12)->primary();
            $table->string('name');
            $table->string('describe')->nullable();
            $table->integer('price');
            $table->boolean('is_sales');
            $table->boolean('is_delete');
            $table->string('img')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

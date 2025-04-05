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
        Schema::create('mercadona_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('name');
            $table->string('image_path');
            $table->string('url');
            $table->timestamps();
        });

        Schema::table('ingredients', function (Blueprint $table) {
            $table->unsignedBigInteger('mercadona_product_id')->after('image_path')->nullable();
        });

        Schema::table('ingredients', function (Blueprint $table) {
            $table->foreign('mercadona_product_id')->references('id')->on('mercadona_products')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingredients', function (Blueprint $table) {
            $table->dropForeign(['mercadona_product_id']);
            $table->dropColumn('mercadona_product_id');
        });

        Schema::dropIfExists('mercadona_products');
    }
};

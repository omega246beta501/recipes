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
        Schema::table('recipe_ingredient', function (Blueprint $table) {
            $table->decimal('supermarket_qty', 10, 2)->default(1)->nullable()->after('qty');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipe_ingredient', function (Blueprint $table) {
            $table->dropColumn('supermarket_qty');
        });
    }
};

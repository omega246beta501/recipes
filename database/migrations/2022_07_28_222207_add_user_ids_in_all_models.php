<?php

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('name')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->dropUnique(['name']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->unique(['name', 'user_id']);
        });

        Schema::table('recipes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('name')->nullable();
            $table->dropUnique('recipes_name_unique');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('recipes', function (Blueprint $table) {
            $table->unique(['name', 'user_id']);
        });

        Schema::table('ingredients', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('name')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->dropUnique('ingredients_name_unique');
        });

        Schema::table('ingredients', function (Blueprint $table) {
            $table->unique(['name', 'user_id']);
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->timestamps();
        });

        $settings = DB::table('internal_settings')->select(['*'])->get();

        foreach ($settings as $setting) {  
            Setting::create([
                'key' => $setting->key
            ]);
        }
        Schema::dropIfExists('internal_settings');

        Schema::create('user_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('setting_id');
            $table->unsignedBigInteger('user_id');
            $table->string('value');
            $table->timestamps();

            $table->foreign('setting_id')->references('id')->on('settings')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('shopping_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('name')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Category::whereNot('user_id', 1)->delete();
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropUnique(['name', 'user_id']);
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->unique('name');
        });

        Recipe::whereNot('user_id', 1)->delete();
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropUnique(['name', 'user_id']);
        });
        Schema::table('recipes', function (Blueprint $table) {
            $table->unique('name');
        });

        Ingredient::whereNot('user_id', 1)->delete();
        Schema::table('ingredients', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropUnique(['name', 'user_id']);
        });
        Schema::table('ingredients', function (Blueprint $table) {
            $table->unique('name');
        });

        Schema::create('internal_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('value')->nullable();
            $table->timestamps();
        });
        
        Schema::dropIfExists('user_settings');
        Schema::dropIfExists('settings');

        Schema::table('shopping_lists', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};

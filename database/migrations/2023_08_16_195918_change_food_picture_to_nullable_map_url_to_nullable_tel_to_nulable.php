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
        Schema::table('restaurants', function (Blueprint $table) {
            $table->string('food_picture')->nullable(true)->change()->comment('料理画像');
            $table->string('map_url')->nullable(true)->change()->comment('Google_map_url');
            $table->string('tel')->nullable(true)->change()->comment('電話番号');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->string('food_picture')->nullable(false)->change()->comment('料理画像');
            $table->string('map_url')->nullable(false)->change()->comment('Google_map_url');
            $table->string('tel')->nullable(false)->change()->comment('電話番号');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->boolean('is_available')->default(true);

            $table->decimal('latitude', 10, 8)->nullable();

            $table->decimal('longitude', 11, 8)->nullable();

            $table->timestamp('last_location_update')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'is_available',
                'latitude',
                'longitude',
                'last_location_update'
            ]);
        });
    }
};
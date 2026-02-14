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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_available')->default(true)->after('user_role');

            $table->decimal('latitude', 10, 8)->nullable()->after('phone_no');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');

            $table->timestamp('last_location_update')->nullable()->after('longitude');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_available');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('last_location_update');
        });
    }
};

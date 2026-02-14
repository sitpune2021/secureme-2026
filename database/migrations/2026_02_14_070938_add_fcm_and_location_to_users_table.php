<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. Store the FCM Token (Text is safer as tokens can be very long)
            $table->text('fcm_token')->nullable()->after('phone_no');

            // 2. Ensure Latitude/Longitude are precise if they don't exist yet
            // Using decimal(10,8) and (11,8) is standard for GPS accuracy
            if (!Schema::hasColumn('users', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable()->after('fcm_token');
            }
            if (!Schema::hasColumn('users', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            }

            // 3. Status to check if a helper is currently active/online
            $table->boolean('is_active')->default(true)->after('longitude');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['fcm_token', 'is_active']);
        });
    }
};

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

            $table->string('user_role', 200)->after('community_id');
            $table->boolean('is_available')->default(1)->after('user_role');
            $table->string('phone_no', 200)->after('password');
            $table->text('fcm_token')->nullable()->after('phone_no');
            $table->decimal('latitude', 10, 8)->nullable()->after('fcm_token');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->boolean('is_active')->default(1)->after('longitude');
            $table->timestamp('last_location_update')->nullable()->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'user_role',
                'is_available',
                'phone_no',
                'fcm_token',
                'latitude',
                'longitude',
                'is_active',
                'last_location_update'
            ]);
        });
    }
};

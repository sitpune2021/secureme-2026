<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {


            // Phone Unique
            $table->unique('phone_no');

            // Latitude Longitude Proper Type
            $table->decimal('latitude', 10, 7)->nullable()->change();
            $table->decimal('longitude', 10, 7)->nullable()->change();

            // User Role Default
            $table->string('user_role')->default('User')->change();

            // Active Status Default
            $table->boolean('is_active')->default(1)->change();

            // Available Status
            $table->boolean('is_available')->default(1)->change();

            // Foreign Key
            $table->foreign('community_id')
                  ->references('id')
                  ->on('communities')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropUnique(['email']);
            $table->dropUnique(['phone_no']);

            $table->dropForeign(['community_id']);
        });
    }
};
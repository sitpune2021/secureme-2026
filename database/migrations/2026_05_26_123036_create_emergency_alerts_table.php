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
        Schema::create('emergency_alerts', function (Blueprint $table) {

            $table->id();

            $table->string('user_name')->nullable();

            $table->string('mobile')->nullable();

            $table->text('message')->nullable();

            $table->string('latitude')->nullable();

            $table->string('longitude')->nullable();

            $table->enum('status', [
                'Pending',
                'Accepted',
                'Resolved'
            ])->default('Pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_alerts');
    }
};

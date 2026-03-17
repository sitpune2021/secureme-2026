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
        Schema::create('emergency_responses', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('signal_id');

            $table->enum('responder_type', ['helper', 'police', 'admin']);

            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('response_action');

            $table->text('response_notes')->nullable();

            $table->enum('status', ['pending', 'in_progress', 'completed'])
                ->default('pending');

            $table->timestamp('created_at')->useCurrent();

            $table->timestamp('updated_at')
                ->useCurrent()
                ->useCurrentOnUpdate();

            // Optional indexes
            $table->index('signal_id');
            $table->index('user_id');

            // Optional foreign keys (recommended)
            $table->foreign('signal_id')
                ->references('id')
                ->on('emergency_signals')
                ->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete(); // user deleted → keep response
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_responses');
    }
};

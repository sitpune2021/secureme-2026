<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        DB::table('admins')->insert([
            'id' => 1,
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => '$2y$12$o2QkweFge6TbxEfJ12zi.eTDYq8uaadx1AszTvMCX.qZr6MqgCT4a',
            'created_at' => '2025-08-17 19:30:32',
            'updated_at' => '2026-02-11 11:55:30',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('delete_token', 64)->nullable()->unique();
            $table->timestamp('delete_token_expires_at')->nullable();
        });
    }
    
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['delete_token_expires_at', 'delete_token']);
        });
    }
};

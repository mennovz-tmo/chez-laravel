<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Accounts created before email verification was enforced are treated as verified.
     */
    public function up(): void
    {
        DB::table('users')->whereNull('email_verified_at')->update(['email_verified_at' => now()]);
    }

    /**
     * Not reversible: reverting would also unverify any account that verified after this migration ran.
     */
    public function down(): void
    {
        //
    }
};

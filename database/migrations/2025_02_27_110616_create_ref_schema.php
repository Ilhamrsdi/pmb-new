<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {

        DB::statement('CREATE SCHEMA IF NOT EXISTS ref');
    }

    public function down(): void
    {

        DB::statement('DROP SCHEMA IF EXISTS ref CASCADE');
    }
};

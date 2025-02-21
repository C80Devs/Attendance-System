<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up (): void
    {
        Schema::table('settings', function(Blueprint $table) {
            $table->time('opening_time')->default('09:15:00')->after('closing_time');
        });

        DB::table('settings')->update(['opening_time' => '09:15:00']);
    }

    /**
     * Reverse the migrations.
     */
    public function down (): void
    {
        Schema::table('settings', function(Blueprint $table) {
            $table->dropColumn('opening_time');
        });
    }
};

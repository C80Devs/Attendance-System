<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up (): void
    {
        Schema::table('users', function(Blueprint $table) {
            $table->text('address')->nullable();
            $table->text('nok_name')->nullable();
            $table->text('nok_address')->nullable();
            $table->text('nok_phone')->nullable();
            $table->text('nok_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down (): void
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('nok_name');
            $table->dropColumn('nok_address');
            $table->dropColumn('nok_email');
            $table->dropColumn('nok_phone');
        });
    }
};

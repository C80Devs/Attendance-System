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
        Schema::table('leave', function(Blueprint $table) {
            // Make the department column nullable
            $table->string('department')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down (): void
    {
        Schema::table('leave', function(Blueprint $table) {
            // Revert department column to not nullable
            $table->string('department')->nullable(false)->change();
        });
    }
};

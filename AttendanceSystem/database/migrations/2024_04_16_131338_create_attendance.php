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

        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userID')->constrained('users');
            $table->dateTime('clockIn');
            $table->dateTime('clockOut')->nullable()->default(null);
            $table->text('clockin_location')->nullable();
            $table->text('clockout_location')->nullable();
            $table->text('device');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

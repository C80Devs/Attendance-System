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


        Schema::create('leave', function(Blueprint $table) {
            $table->id();
            $table->foreignId('userID')->constrained('users');
            $table->dateTime('startDate');
            $table->dateTime('endDate');
            $table->text('type');
            $table->text('reason')->nullable();
            $table->text('department');
            $table->boolean('approved')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('leave');
    }
};

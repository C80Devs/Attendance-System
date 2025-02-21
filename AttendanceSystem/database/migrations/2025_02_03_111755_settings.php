<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

// Import DB facade

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up (): void
    {
        Schema::create('settings', function(Blueprint $table) {
            $table->id()->primary();
            $table->string('name')->default('Attendly');
            $table->string('color')->default('#B44545');
            $table->string('color_dark')->default('#B44545');
            $table->integer('no_of_leave_days')->default(20);
            $table->boolean('task_active')->default(true);
            $table->boolean('clock_active')->default(true);
            $table->boolean('leave_active')->default(true);
            $table->integer('closing_time')->default(17);
            $table->boolean('clock_out_anytime')->default(false);
            $table->string('logo')->nullable();
            $table->float('lat')->nullable();
            $table->float('long')->nullable();
            $table->timestamps();
        });

        DB::table('settings')->insert([
            'color' => '#B44545',
            'color_dark' => '#A30000',
            'name' => 'Attendly',
            'no_of_leave_days' => 20,
            'clock_out_anytime' => false,
            'closing_time' => 17,
            'task_active' => true,
            'clock_active' => true,
            'leave_active' => true,
            'logo' => null,
            'lat' => null,
            'long' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down (): void
    {
        Schema::dropIfExists('settings');
    }
};

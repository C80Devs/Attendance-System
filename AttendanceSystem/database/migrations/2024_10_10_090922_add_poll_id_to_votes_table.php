<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPollIdToVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up ()
    {
        Schema::table('votes', function(Blueprint $table) {
            $table->unsignedBigInteger('poll_id')->after('poll_option_id')->nullable();
            $table->foreign('poll_id')->references('id')->on('polls')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down ()
    {
        Schema::table('votes', function(Blueprint $table) {
            $table->dropForeign(['poll_id']);

            $table->dropColumn('poll_id');
        });
    }
}

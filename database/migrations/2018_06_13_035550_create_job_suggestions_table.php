<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobSuggestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_suggestions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_profile_id');
            $table->unsignedInteger('job_id');
            $table->string('status')->default('pending');
            $table->datetime('from_date')->nullable();
            $table->datetime('to_date')->nullable();
            $table->foreign('user_profile_id')->references('id')->on('user_profiles')->onDelete('cascade');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_suggestions');
    }
}

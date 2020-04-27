<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('job_type');
            $table->string('title');
            $table->string('position');
            $table->double('min_salary')->nulabble();
            $table->double('max_salary')->nulabble();
            $table->string('currency')->nullable();
            $table->string('per')->nullable();
            $table->text('description');
            $table->boolean('is_remote');
            $table->string('status');
            $table->integer('duration');
            $table->string('duration_type')->nullable();
            $table->datetime('from_date')->nullable();
            $table->datetime('to_date')->nullable();
            $table->datetime('deadline')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->boolean('is_available');
            $table->boolean('allow_comment')->default(true);
            $table->uuid('uuid');
            $table->softDeletesTz();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('jobs');
    }
}

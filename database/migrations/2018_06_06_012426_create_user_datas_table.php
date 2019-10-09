<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->longText('about')->nullable();
            $table->string('job_status')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linked_in')->nullable();
            $table->string('github')->nullable();
            $table->string('current_job')->nullable();
            $table->string('company')->nullable();
            $table->integer('employees')->nullable();
            $table->text('quote')->nullable();
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
        Schema::dropIfExists('user_datas');
    }
}

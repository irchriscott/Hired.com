<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_from_id');
            $table->unsignedInteger('user_to_id');
            $table->string('ressource');
            $table->integer('ressource_id');
            $table->boolean('is_read')->default(false);
            $table->foreign('user_from_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_to_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('notifications');
    }
}

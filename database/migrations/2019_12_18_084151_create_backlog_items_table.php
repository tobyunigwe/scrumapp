<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBacklogItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backlog_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('sprint_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('sprint_id')->references('id')->on('sprints')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('role');
            $table->string('type');
            $table->string('activity');
            $table->integer('story_point');
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backlog_items');
    }
}

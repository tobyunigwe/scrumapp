<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetrospectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retrospectives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sprint_id');

            $table->string('description');
            $table->string('status');

            $table->foreign('sprint_id')->references('id')->on('sprints')->onDelete('cascade');
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
        Schema::dropIfExists('retrospectives');
    }
}

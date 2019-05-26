<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->datetime('start');
            $table->datetime('end')->nullable();
            $table->bigInteger('shift_id')->unsigned()->nullable();
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('cascade');
            $table->integer('member_id')->unsigned()->nullable();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('set null');
            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('status')->onDelete('set null');
            $table->integer('priority_id')->unsigned()->nullable();
            $table->foreign('priority_id')->references('id')->on('priorities')->onDelete('set null');
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
        Schema::dropIfExists('tasks');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersShiftsPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_shift', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('member_id')->unsigned()->index();
            $table->bigInteger('shift_id')->unsigned()->index();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('cascade');
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
        Schema::dropIfExists('member_shift');
    }
}

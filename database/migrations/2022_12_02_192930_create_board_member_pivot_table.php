<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardMemberPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_member', function (Blueprint $table) {
            $table->unsignedBigInteger('board_id')->index();
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('cascade');
            $table->unsignedBigInteger('member_id')->index();
            $table->foreign('member_id')->references('member_id')->on('member_workspace')->onDelete('cascade');
            $table->primary(['board_id', 'member_id']);
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
        Schema::dropIfExists('board_member');
    }
}

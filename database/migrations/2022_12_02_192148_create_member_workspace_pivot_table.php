<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberWorkspacePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_workspace', function (Blueprint $table) {
            $table->unsignedBigInteger('member_id')->index();
            $table->foreign('member_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('workspace_id')->index();
            $table->foreign('workspace_id')->references('id')->on('workspaces')->onDelete('cascade');
            $table->primary(['member_id', 'workspace_id']);
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
        Schema::dropIfExists('member_workspace');
    }
}

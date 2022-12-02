<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('list_id')->index('Card__List___fk');
            $table->boolean('archived')->default(false);
            $table->string('description', 65535)->nullable();
            $table->string('due', 0)->nullable();
            $table->boolean('due_complete')->nullable();
            $table->string('title', 25);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
};

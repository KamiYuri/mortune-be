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
        Schema::table('card_lists', function (Blueprint $table) {
            $table->foreign(['board_id'], 'List__Board___fk')->references(['id'])->on('boards')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('card_lists', function (Blueprint $table) {
            $table->dropForeign('List__Board___fk');
        });
    }
};

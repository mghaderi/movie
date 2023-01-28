<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('first_name_word_id')->nullable();
            $table->unsignedBigInteger('last_name_word_id')->nullable();
            $table->unsignedBigInteger('full_name_word_id')->nullable();
            $table->timestamps();
        });
        Schema::table('persons', function (Blueprint $table) {
            $table->foreign('first_name_word_id', 'fk-persons-first_name_word_id')
                ->on('words')
                ->references('id')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            $table->foreign('last_name_word_id', 'fk-persons-last_name_word_id')
                ->on('words')
                ->references('id')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            $table->foreign('full_name_word_id', 'fk-persons-full_name_word_id')
                ->on('words')
                ->references('id')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->dropForeign('fk-persons-full_name_word_id');
            $table->dropForeign('fk-persons-last_name_word_id');
            $table->dropForeign('fk-persons-first_name_word_id');
        });
        Schema::dropIfExists('persons');
    }
}

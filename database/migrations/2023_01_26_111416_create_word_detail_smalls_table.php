<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWordDetailSmallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('word_detail_smalls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('word_id')->nullable();
            $table->unsignedBigInteger('language_id')->nullable();
            $table->string('value')->nullable();
            $table->timestamps();
        });
        Schema::table('word_detail_smalls', function (Blueprint $table) {
            $table->foreign('word_id', 'fk-word_detail_smalls-word_id')
                ->on('words')
                ->references('id')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            $table->foreign('language_id', 'fk-word_detail_smalls-language_id')
                ->on('languages')
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
        Schema::table('word_detail_smalls', function (Blueprint $table) {
            $table->dropForeign('fk-word_detail_smalls-language_id');
            $table->dropForeign('fk-word_detail_smalls-word_id');
        });
        Schema::dropIfExists('word_detail_smalls');
    }
}

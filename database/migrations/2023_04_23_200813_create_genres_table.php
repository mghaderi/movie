<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('word_id')->nullable();
            $table->string('name')->nullable();
            $table->timestamps();
        });
        Schema::table('genres', function (Blueprint $table) {
            $table->foreign('word_id', 'fk-genres-word_id')
                ->on('words')
                ->references('id')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION')
                ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('genres', function (Blueprint $table) {
            $table->dropForeign('fk-genres-word_id');
        });
        Schema::dropIfExists('genres');
    }
}

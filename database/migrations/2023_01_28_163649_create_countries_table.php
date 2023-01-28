<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('word_id')->nullable();
            $table->string('short_name')->nullable();
            $table->timestamps();
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->foreign('word_id', 'fk-counties-word_id')
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
        Schema::table('countries', function (Blueprint $table) {
            $table->dropForeign('fk-counties-word_id');

        });
        Schema::dropIfExists('countries');
    }
}

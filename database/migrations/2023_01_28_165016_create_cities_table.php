<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('word_id')->nullable();
            $table->string('short_name')->nullable();
            $table->timestamps();
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->foreign('country_id', 'fk-cities-country_id')
                ->on('countries')
                ->references('id')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            $table->foreign('country_id', 'fk-cities-word_id')
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
        Schema::table('cities', function (Blueprint $table) {
            $table->dropForeign('fk-cities-word_id');
            $table->dropForeign('fk-cities-country_id');
        });
        Schema::dropIfExists('cities');
    }
}

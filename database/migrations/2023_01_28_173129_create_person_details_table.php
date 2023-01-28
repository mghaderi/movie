<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id')->nullable();
            $table->string('type')->nullable();
            $table->nullableMorphs('relation');
            $table->timestamps();
        });
        Schema::table('person_details', function (Blueprint $table) {
            $table->foreign('person_id', 'fk-person_details-person_id')
                ->on('persons')
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
        Schema::table('person_details', function (Blueprint $table) {
            $table->dropForeign('fk-person_details-person_id');
        });
        Schema::dropIfExists('person_details');
    }
}

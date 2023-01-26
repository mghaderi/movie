<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('media_id')->nullable();
            $table->string('type');
            $table->timestamps();
        });
        Schema::table('media_details', function (Blueprint $table) {
            $table->foreign('media_id', 'fk-media_details-media_id')
                ->on('medias')
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
        Schema::table('media_details', function (Blueprint $table) {
            $table->dropForeign('fk-media_details-media_id');
        });
        Schema::dropIfExists('media_details');
    }
}

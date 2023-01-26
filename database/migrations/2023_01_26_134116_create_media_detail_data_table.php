<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaDetailDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_detail_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('media_detail_id')->nullable();
            $table->string('name')->nullable();
            $table->string('value')->nullable();
            $table->timestamps();
        });
        Schema::table('media_detail_data', function (Blueprint $table) {
            $table->foreign('media_detail_id', 'fk-media_detail_data-media_detail_id')
                ->on('media_details')
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
        Schema::table('media_detail_data', function (Blueprint $table) {
            $table->dropForeign(
                'fk-media_detail_data-media_detail_id'
            );
        });
        Schema::dropIfExists('media_detail_data');
    }
}

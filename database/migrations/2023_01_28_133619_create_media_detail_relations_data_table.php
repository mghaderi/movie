<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaDetailRelationsDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_detail_relations_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('media_detail_datum_id')->nullable();
            $table->unsignedBigInteger('media_detail_relation_id')->nullable();
            $table->timestamps();
        });
        Schema::table('media_detail_relations_data', function (Blueprint $table) {
            $table->foreign('media_detail_datum_id', 'fk-media_detail_relations_data-media_detail_datum_id')
                ->on('media_detail_data')
                ->references('id')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            $table->foreign('media_detail_relation_id', 'fk-media_detail_relations_data-media_detail_relation_id')
                ->on('media_detail_relations')
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
        Schema::table('media_detail_relations_data', function (Blueprint $table) {
            $table->dropForeign('fk-media_detail_relations_data-media_detail_relations_id');
            $table->dropForeign('fk-media_detail_relations_data-media_detail_data_id');
        });
        Schema::dropIfExists('media_detail_relations_data');
    }
}

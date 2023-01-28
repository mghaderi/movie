<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaDetailRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_detail_relations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('media_detail_id')->nullable();
            $table->nullableMorphs('relation');
            $table->timestamps();
        });
        Schema::table('media_detail_relations', function (Blueprint $table) {
            $table->foreign('media_detail_id', 'fk-media_detail_relations-media_detail_id')
                ->on('media_details')
                ->references('id')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media_detail_relations', function (Blueprint $table) {
            $table->dropForeign('fk-media_detail_relations-media_detail_id');
        });
        Schema::dropIfExists('media_detail_relations');
    }
}

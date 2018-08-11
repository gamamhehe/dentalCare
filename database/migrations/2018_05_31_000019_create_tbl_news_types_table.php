<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblNewsTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_news_types', function (Blueprint $table) {
            $table->integer('type_id')->unsigned();
            $table->integer('news_id')->unsigned();
            $table->primary(array('type_id', 'news_id'));
            $table->timestamps();
            $table->foreign('type_id')->references('id')->on('tbl_types');
            $table->foreign('news_id')->references('id')->on('tbl_news');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('tbl_news_types');
        Schema::enableForeignKeyConstraints();
    }
}

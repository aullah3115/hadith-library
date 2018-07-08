<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHadithsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hadiths', function (Blueprint $table) {
            $table->increments('id');
          //  $table->integer('neo_id')->unsigned()->nullabale();
            $table->integer('section_id')->unsigned();
            $table->integer('number');
            $table->text('chain');
            $table->text('blurb');
            //$table->text('author_comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hadiths');
    }
}

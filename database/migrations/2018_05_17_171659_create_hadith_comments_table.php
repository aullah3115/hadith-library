<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHadithCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hadith_comments', function (Blueprint $table) {
            $table->increments('id');
        //  $table->integer('neo_id')->unsigned()->nullabale();
            $table->integer('hadith_id')->unsigned();
            $table->integer('commentary_id')->unsigned();
            $table->text('blurb');
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
        Schema::dropIfExists('hadith_comments');
    }
}

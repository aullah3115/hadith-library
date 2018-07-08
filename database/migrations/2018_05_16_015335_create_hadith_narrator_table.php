<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHadithNarratorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hadith_narrator', function (Blueprint $table) {
            $table->increments('id');
        //    $table->integer('neo_id')->unsigned()->nullabale();
            $table->integer('position');
            $table->integer('hadith_id');
            $table->integer('narrator_id');
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
        Schema::dropIfExists('hadith_narrator');
    }
}

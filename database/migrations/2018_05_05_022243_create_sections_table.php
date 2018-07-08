<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
          //  $table->integer('neo_id')->unsigned()->nullabale();
            $table->integer('book_id')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('position');
            $table->string('name');
            //$table->string('route')->nullable();
            $table->boolean('has_hadith')->nullable();
            $table->boolean('has_section')->nullable();
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
        Schema::dropIfExists('sections');
    }
}

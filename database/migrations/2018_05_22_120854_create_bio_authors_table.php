<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBioAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bio_authors', function (Blueprint $table) {
            $table->increments('id');
          //  $table->integer('neo_id')->unsigned()->nullabale();
            $table->string('kunyah')->nullable();
            $table->string('name');
            $table->string('laqab')->nullable();
            $table->string('used_name')->nullable();
            $table->string('nisbah')->nullable();
            $table->integer('yob')->nullable();
            $table->integer('yod')->nullable();
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
        Schema::dropIfExists('bio_authors');
    }
}

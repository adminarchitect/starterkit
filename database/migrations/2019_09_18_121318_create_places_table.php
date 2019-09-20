<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('active')->default(1)->index();
            $table->timestamps();
        });

        Schema::create('place_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('place_id')->nullable();
            $table->unsignedBigInteger('language_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();

            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('place_translations');
        Schema::dropIfExists('places');
    }
}

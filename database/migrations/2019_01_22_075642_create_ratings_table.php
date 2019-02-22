<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rating');
            $table->morphs('rateable');
            $table->string('rateable_on_type')->nullable();
            $table->unsignedBigInteger('rateable_on_id')->nullable();
            $table->string('rateable_on_column', 50)->nullable();
            $table->index(['rateable_on_type', 'rateable_on_id']);
            $table->text('body');
            $table->unsignedInteger('author_id')->index();
            $table->timestamps();
            $table->foreign('author_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}

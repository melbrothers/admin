<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->increments('id');
            $table->unique(['user_id', 'task_id']);
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('task_id');
            $table->boolean('accepted')->default(false);
            $table->unsignedSmallInteger('price');
            $table->timestamp('proposed_deadline')->nullable();
            $table->double('fee');
            $table->double('gst');
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
        Schema::dropIfExists('bids');
    }
}

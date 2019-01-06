<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->primary(['user_id', 'task_id']);
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('task_id');
            $table->enum('status', ['PENDING','ACCEPTED', 'DECLINED']);
            $table->unsignedSmallInteger('price');
            $table->double('service_fee');
            $table->double('gst');
            $table->text('comment');
            $table->unique(['task_id', 'status']);
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
        Schema::dropIfExists('offers');
    }
}

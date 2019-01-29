<?php

use App\Task;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->string('location_id')->nullable();
            $table->enum('state', Task::STATES);
            $table->date('deadline')->nullable();
            $table->string('specified_times')->nullable();
            $table->boolean('flexible_deadline')->default(false);
            $table->unsignedSmallInteger('price')->nullable();
            $table->unsignedSmallInteger('estimate_hourly_rate')->nullable();
            $table->unsignedSmallInteger('estimate_hours')->nullable();
            $table->boolean('comment_allowed')->default(true);
            $table->timestamp('first_posted_at')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}

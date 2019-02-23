<?php

use App\Models\Task;
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
            $table->unsignedInteger('sender_id');
            $table->unsignedInteger('runner_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->unsignedInteger('location_id')->nullable();
            $table->enum('state', Task::STATES);
            $table->dateTime('deadline')->nullable();
            $table->boolean('online_or_phone');
            $table->json('specified_times')->nullable();
            $table->boolean('flexible_deadline')->default(false);
            $table->unsignedSmallInteger('price')->nullable();
            $table->unsignedSmallInteger('estimate_hourly_rate')->nullable();
            $table->unsignedSmallInteger('estimate_hours')->nullable();
            $table->boolean('comment_allowed')->default(true);
            $table->dateTime('first_posted_at')->nullable();
            $table->timestamps();
            $table->foreign('runner_id')->references('id')->on('users');
            $table->foreign('sender_id')->references('id')->on('users');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->string('title');
            $table->string('company');
            $table->string('company_logo')->nullable();
            $table->string('location');
            $table->string('salary')->nullable();
            $table->string('description');
            $table->string('benefits')->nullable();
            $table->string('type')->nullable();
            $table->string('Category')->nullable();
            $table->string('work_condition')->nullable();
            $table->timestamps();
        });


        Schema::create('job_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->string('job_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_user');
    }
}

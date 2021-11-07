<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobtypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobtypes', function (Blueprint $table) {
            $table->id();
            $table->string('type')->unique();
            $table->timestamps();
        });

        DB::connection(env('DB_CONNECTION'))->table('jobtypes')->insert([
            ['type' => 'Full-time', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['type' => 'Temporary', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['type' => 'Contract', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['type' => 'Permanent', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['type' => 'Internship', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['type' => 'Volunteer', 'created_at' => NOW(), 'updated_at' => NOW()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobtypes');
    }
}

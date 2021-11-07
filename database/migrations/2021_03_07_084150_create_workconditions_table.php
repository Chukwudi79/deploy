<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkconditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workconditions', function (Blueprint $table) {
            $table->id();
            $table->string('type')->unique();
            $table->timestamps();
        });

        DB::connection(env('DB_CONNECTION'))->table('workconditions')->insert([
            ['type' => 'Remote', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['type' => 'Part Remote', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['type' => 'On-Premise', 'created_at' => NOW(), 'updated_at' => NOW()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workconditions');
    }
}

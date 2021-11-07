<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        DB::connection(env('DB_CONNECTION'))->table('categories')->insert([
            ['name' => 'Tech', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'Health care', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'Hospitality', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'Customer Service', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'Marketing', 'created_at' => NOW(), 'updated_at' => NOW()],

        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}

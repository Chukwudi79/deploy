<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('avatar')->nullable();
            $table->string('password');
            $table->tinyInteger('role');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::connection(env('DB_CONNECTION'))->table('users')->insert([
            'name' => 'Tedbree',
            'email' => 'business@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

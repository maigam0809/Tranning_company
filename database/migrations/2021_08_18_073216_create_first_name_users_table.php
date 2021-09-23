<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirstNameUsersTable extends Migration
{

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
        });
    }


    public function down()
    {
        Schema::table('products', function($table) {
            $table->dropColumn('frist_name');
            $table->dropColumn('last_name');
        });
    }
}

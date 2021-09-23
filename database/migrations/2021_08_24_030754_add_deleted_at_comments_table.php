<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtCommentsTable extends Migration
{
    public function up()
    {
        Schema::table('comments', function ($table) {
            $table->softDeletes('deleted_at');
        });
    }


    public function down()
    {
        Schema::table('comments', function ($table) {
            $table->dropSoftDeletes('deleted_at');
        });
    }
}

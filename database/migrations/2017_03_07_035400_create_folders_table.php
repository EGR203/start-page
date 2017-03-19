<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoldersTable extends Migration
{
    public function up()
    {
        Schema::create('folders', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name')->default('folder');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('position', false, true);
            $table->integer('real_depth', false, true);
            $table->softDeletes();

            $table->foreign('parent_id')->references('id')->on('folders')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('folders', function(Blueprint $table)
        {
            Schema::dropIfExists('folders');
        });
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFolderClosuresTable extends Migration
{
    public function up()
    {
        Schema::create('folder_closure', function(Blueprint $table)
        {
            $table->increments('closure_id');

            $table->integer('ancestor', false, true);
            $table->integer('descendant', false, true);
            $table->integer('depth', false, true);

            $table->foreign('ancestor')->references('id')->on('folders')->onDelete('cascade');
            $table->foreign('descendant')->references('id')->on('folders')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('folder_closure', function(Blueprint $table)
        {
            Schema::dropIfExists('folder_closure');
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoldersSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folder_site', function (Blueprint $table) {
            
            $table->integer('folder_id')->unsigned()->nullable();
            $table->foreign('folder_id')->references('id')
                    ->on('folders')->onDelete('cascade');
            
            $table->integer('site_id')->unsigned()->nullable();
            $table->foreign('site_id')->references('id')
                    ->on('sites')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('folder_site');
    }
}

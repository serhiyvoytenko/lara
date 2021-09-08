<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('guid')->unique()->nullable(false);
            $table->string('category');
            $table->string('title');
            $table->string('description');
            $table->string('comments');
            $table->string('shortname');
            $table->string('path');
            $table->string('fullname')->unique();
            $table->timestamps();

            $table->foreign('category')->references('name')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}

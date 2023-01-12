<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title', '1000');
            $table->text('description')->nullable();
            $table->string('status', '50')->nullable();
            $table->string('ingredients', '500')->nullable();
            $table->string('label', '500')->nullable();
            $table->string('excerpt', '1000')->nullable();
            $table->string('featured_image', '100')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->string('slug')->unique();
            $table->integer('user_id')->unsigned()->index();
            $table->string('cover')->nullable();
            $table->string('banner')->nullable();
            $table->text('intro')->nullable();
            $table->text('introduction')->nullable();
            $table->integer('price')->unsigned()->default(0);
            $table->tinyInteger('sorting')->unsigned()->default(0)->index();
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
        Schema::dropIfExists('courses');
    }
}

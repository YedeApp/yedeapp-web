<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index();
            $table->text('content');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('course_id')->unsigned()->index();
            $table->integer('chapter_id')->unsigned()->index();
            $table->integer('comment_count')->unsigned()->default(0);
            $table->integer('view_count')->unsigned()->default(0);
            $table->tinyInteger('is_free')->unsigned()->default(0);
            $table->string('slug')->nullable();
            $table->string('description')->nullable();
            $table->smallInteger('sorting')->unsigned()->default(0)->index();
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
        Schema::dropIfExists('topics');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration 
{
	public function up()
	{
		Schema::create('answers', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('question_id')->index();
            $table->integer('vote_count')->default(0);
            $table->longText('body');
            $table->boolean('accepted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('answers');
	}
}

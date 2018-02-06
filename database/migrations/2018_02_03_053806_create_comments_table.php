<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration 
{
	public function up()
	{
		Schema::create('comments', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('commentable_id');
            $table->string('commentable_type');
            $table->text('body');
            $table->softDeletes();
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('comments');
	}
}

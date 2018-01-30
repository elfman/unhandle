<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration 
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
	public function up()
	{
		Schema::create('questions', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index();
            $table->text('brief');
            $table->longText('body');
            $table->unsignedInteger('user_id');
            $table->integer('vote_count')->default(0);
            $table->unsignedInteger('solved_by')->nullable();
            $table->unsignedInteger('view_count')->default(0);
            $table->unsignedInteger('answer_count')->default(0);
            $table->timestamps();

            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
	}

    public function down()
    {
        Schema::drop('questions');
    }
}

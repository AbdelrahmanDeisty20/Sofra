<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentsTable extends Migration {

	public function up()
	{
		Schema::create('comments', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('comment');
			$table->integer('client_id')->unsigned();
			$table->enum('rate', array('1', '2', '3', '4', '5'));
			$table->integer('restaurant_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('comments');
	}
}
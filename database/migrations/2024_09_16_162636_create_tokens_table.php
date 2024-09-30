<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTokensTable extends Migration {

	public function up()
	{
		Schema::create('tokens', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->morphs('tokenable');
			$table->string('token');
			$table->integer('client_id')->unsigned();
			$table->integer('restaurant_id')->unsigned();
			$table->enum('type', array('android', 'ios'));
		});
	}

	public function down()
	{
		Schema::drop('tokens');
	}
}
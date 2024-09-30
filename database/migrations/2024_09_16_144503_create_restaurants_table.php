<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRestaurantsTable extends Migration {

	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->integer('region_id')->unsigned();
			$table->string('password');
			$table->decimal('minimum_order');
			$table->string('image');
			$table->decimal('delivery_fees');
			$table->string('pin_code');
			$table->string('api_token')->nullable();
			$table->string('whatsapp');
			$table->boolean('status');
		});
	}

	public function down()
	{
		Schema::drop('restaurants');
	}
}